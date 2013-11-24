<?php
namespace LwcCmsPage\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LwcCmsPage\Options\ModuleOptions;

class PageFormFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        
        $options = new ModuleOptions($config['lwccmspage']);
        $form = new PageForm('lwccmspage', $options);
        $filter = new PageFormFilter();
        $form->setInputFilter($filter);
        return $form;
    }
}