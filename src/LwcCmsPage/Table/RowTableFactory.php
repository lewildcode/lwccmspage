<?php
namespace LwcCmsPage\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\ClassMethods;
use LwcCmsPage\Entity\RowEntity;

class RowTableFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $db = $serviceLocator->get('LwcCmsPage\DbAdapter');
        $config = $serviceLocator->get('Config');

        $table = $config['lwccmspage']['rowtable'];
        $resultSet = new HydratingResultSet(new ClassMethods(), new RowEntity());
        return new RowTable($table, $db, null, $resultSet);
    }
}