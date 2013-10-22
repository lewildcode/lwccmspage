<?php
namespace LwcCmsPage\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbTable = $serviceLocator->get('LwcCmsPage\Table\Page');
        return new PageService($dbTable);
    }
}