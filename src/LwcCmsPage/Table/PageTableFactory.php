<?php
namespace LwcCmsPage\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\ClassMethods;
use LwcCmsPage\Entity\PageEntity;

class PageTableFactory implements FactoryInterface
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

        $table = $config['lwccmspage']['pagetable'];
        $resultSet = new HydratingResultSet(new ClassMethods(), new PageEntity());
        return new PageTable($table, $db, null, $resultSet);
    }
}