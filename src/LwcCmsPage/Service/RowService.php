<?php
namespace LwcCmsPage\Service;

use LwcCmsPage\Table\RowTable;
use LwcCmsPage\Entity\PageEntityInterface;

class RowService
{

    /**
     *
     * @var PageTable
     */
    protected $table;

    /**
     *
     * @param RowTable $table
     */
    public function __construct(RowTable $table)
    {
        $this->setTable($table);
    }

    /**
     *
     * @return \LwcCmsPage\Table\RowTable
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     *
     * @param RowTable $table
     * @return \LwcCmsPage\Service\RowService
     */
    public function setTable(RowTable $table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     *
     * @param PageEntityInterface $p
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getRowsForPage(PageEntityInterface $p)
    {
        return $this->getTable()->getRowsByPageId($p->getId());
    }
}