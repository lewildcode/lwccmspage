<?php
namespace LwcCmsPage\Table;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class RowTable extends TableGateway
{

    /**
     *
     * @param integer $id
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getRowsByPageId($id)
    {
        $select = new Select($this->getTable());
        $select->order(array(
            'position ASC',
            'id ASC'
        ));
        $select->where('page_id = ' . (int) $id);
        return $this->selectWith($select);
    }
}