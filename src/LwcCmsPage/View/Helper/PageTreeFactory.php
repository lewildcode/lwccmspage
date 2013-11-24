<?php
namespace LwcCmsPage\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageTreeFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $helperPluginManager)
    {
        $cms = $helperPluginManager->getServiceLocator()->get('cms_tree');
        return new PageTree($cms);
    }
}