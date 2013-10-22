<?php
namespace LwcCmsPage\Table;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Expression as PredicateExpression;
use LwcCmsPage\Entity\PageEntity;

class PageTable extends TableGateway
{

    /**
     *
     * @var string
     */
    const MODE_CHILD_LAST = 'last';

    /**
     *
     * @var string
     */
    const MODE_CHILD_FIRST = 'first';

    /**
     *
     * @var string
     */
    const MODE_SIBLING_PREV = 'before';

    /**
     *
     * @var string
     */
    const MODE_SIBLING_NEXT = 'after';

    /**
     *
     * @param string $mode
     * @return boolean
     */
    public function validateMode($mode)
    {
        return in_array($mode, array(
            self::MODE_CHILD_FIRST,
            self::MODE_CHILD_LAST,
            self::MODE_SIBLING_NEXT,
            self::MODE_SIBLING_PREV
        ));
    }

    /**
     *
     * @param PageEntity $p
     * @param integer $id
     * @param string $mode
     *            OPTIONAL see MODE_ constants
     * @throws \InvalidArgumentException
     * @return PageEntity
     */
    public function insertPage(PageEntity $p, $id, $mode = self::MODE_CHILD_LAST)
    {
        if (! $this->validateMode($mode)) {
            throw new \InvalidArgumentException('Invalid insert mode ' . $mode);
        }
        $objective = $this->getPageById($id);
        if($objective) {
            $lft = $objective->getLft();
            $rgt = $objective->getRgt();
        } else {
            $lft = 0;
            $rgt = 1;
        }

        $rgtExpr = new Expression('rgt + 2');
        $lftExpr = new Expression('lft + 2');

        switch ($mode) {
            case self::MODE_CHILD_FIRST:
                $this->update(array(
                    'rgt' => $rgtExpr
                ), 'rgt > ' . $lft);
                $this->update(array(
                    'lft' => $lftExpr
                ), 'lft > ' . $lft);

                $p->setLft($lft + 1);
                $p->setRgt($lft + 2);
                break;
            case self::MODE_CHILD_LAST:
                $this->update(array(
                    'rgt' => $rgtExpr
                ), 'rgt >= ' . $rgt);

                $this->update(array(
                    'lft' => $lftExpr
                ), 'lft > ' . $rgt);

                $p->setLft($rgt);
                $p->setRgt($rgt + 1);
                break;
            case self::MODE_SIBLING_NEXT:
                $this->update(array(
                    'rgt' => $rgtExpr
                ), 'rgt > ' . $rgt);

                $this->update(array(
                    'lft' => $lftExpr
                ), 'lft  > ' . $rgt);

                $p->setLft($rgt + 1);
                $p->setRgt($rgt + 2);
                break;
            case self::MODE_SIBLING_PREV:
                $this->update(array(
                    'rgt' => $rgtExpr
                ), 'rgt > ' . $lft);

                $this->update(array(
                    'lft' => $lftExpr
                ), 'lft >= ' . $lft);

                $p->setLft($lft);
                $p->setRgt($lft + 1);
                break;
        }

        $this->insert($p->getArrayCopy());

        return $p->setId($this->getLastInsertValue());
    }

    /**
     *
     * @param integer $id
     * @return PageEntity
     */
    public function getPageById($id)
    {
        return $this->select(array(
            'id' => (int) $id
        ))->current();
    }

    /**
     *
     * @return \Zend\Db\Sql\Expression
     */
    public function getPathExpression()
    {
        $pf = $this->getAdapter()->getPlatform();
        $select = $this->getPathSubSelect();
        return new Expression('(' . $select->getSqlString($pf) . ')');
    }

    /**
     *
     * @param string $t1
     *            OPTIONAL table alias
     * @param string $t2
     *            OPTIONAL table alias
     * @return \Zend\Db\Sql\Select
     */
    protected function getPathSubSelect($t1 = 't1', $t2 = 't2')
    {
        $table = $this->getTable();
        $expr = new Expression('IFNULL(CONCAT("/", GROUP_CONCAT(' . $t1 . '.identifier ORDER BY ' . $t1 . '.lft SEPARATOR "/")), "/")');

        $on = $t1 . '.lft <= ' . $t2 . '.lft AND ' . $t1 . '.rgt >= ' . $t2 . '.rgt';

        $sql = new Select(array(
            $t1 => $table
        ));
        return $sql->columns(array(
            $expr
        ))
            ->join(array(
            $t2 => $table
        ), $on, array(), Select::JOIN_LEFT)
            ->where(array(
            $t2 . '.identifier = ' . $table . '.identifier'
        ));
    }

    /**
     *
     * @return string
     */
    protected function getPathSubSelectString()
    {
        $select = $this->getPathSubSelect();
        $dbPlatform = $this->getAdapter()->getPlatform();
        return $select->getSqlString($dbPlatform);
    }

    /**
     *
     * @param string $uri
     * @return \Zend\Db\Sql\Select
     */
    public function getPageSelectForUri($uri)
    {
        $table = $this->getTable();
        $joinName = 'parent';

        $select = new Select($table);
        $columns = array(
            '*',
            'path' => $this->getPathExpression()
        );
        $on = '(' . $table . '.lft BETWEEN ' . $joinName . '.lft AND ' . $joinName . '.rgt)';

        $whereSubSelect = '(' . $this->getPathSubSelectString() . ')';
        $whereUri = new PredicateExpression($whereSubSelect . ' = ?', $uri);

        $joinDef = array(
            $joinName => $table
        );

        return $select->columns($columns)
            ->join($joinDef, $on, array())
            ->group($table . '.id')
            ->order($table . '.lft')
            ->where($whereUri);
    }
}