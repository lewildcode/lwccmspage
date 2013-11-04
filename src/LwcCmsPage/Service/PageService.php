<?php
namespace LwcCmsPage\Service;

use LwcCmsPage\Table\PageTable;
use LwcCmsPage\Entity\PageEntity;

class PageService
{

    /**
     *
     * @var PageTable
     */
    protected $table;

    /**
     *
     * @param PageTable $table
     */
    public function __construct(PageTable $table)
    {
        $this->setTable($table);
    }

    /**
     *
     * @return \LwcCmsPage\Table\PageTable
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     *
     * @param PageTable $table
     * @return \LwcCmsPage\Service\PageService
     */
    public function setTable(PageTable $table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     *
     * @param PageEntity $p
     * @param integer $id
     * @param string $mode
     * @return \LwcCmsPage\Entity\PageEntity
     */
    public function insertPage(PageEntity $p, $id, $mode)
    {
        return $this->getTable()->insertPage($p, $id, $mode);
    }

    /**
     *
     * @param integer $id
     * @return \LwcCmsPage\Entity\PageEntity
     */
    public function findPageById($id)
    {
        return $this->getTable()
            ->select('id = ' . (int) $id)
            ->current();
    }
    
    public function savePage(PageEntity $page)
    {
        if($page->getId()) {
            $data = $page->getArrayCopy();
            $this->getTable()->update($data, 'id = ' . (int) $page->getId());
        }
    }

    /**
     *
     * @param string $uri
     * @return \LwcCmsPage\Entity\PageEntity
     */
    public function findPageByUri($uri)
    {
        if (trim($uri) == '') {
            return false;
        }

        $dbTable = $this->getTable();
        $select = $dbTable->getPageSelectForUri($uri);
        return $dbTable->selectWith($select)->current();
    }
}