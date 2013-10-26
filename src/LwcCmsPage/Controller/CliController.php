<?php
namespace LwcCmsPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LwcCmsPage\Service\PageService;
use LwcCmsPage\Entity\PageEntity;
use LwcCmsPage\Filter\UrlPath;
use LwcCmsPage\Service\PageServiceAwareInterface;

class CliController extends AbstractActionController implements PageServiceAwareInterface
{

    /**
     *
     * @var PageService
     */
    protected $service;

    /**
     * (non-PHPdoc)
     * 
     * @see \LwcCmsPage\Service\PageServiceAwareInterface::setPageService()
     */
    public function setPageService(PageService $pageService)
    {
        $this->service = $pageService;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \LwcCmsPage\Service\PageServiceAwareInterface::getPageService()
     */
    public function getPageService()
    {
        return $this->service;
    }

    public function createAction()
    {
        $visible = (bool) $this->params('visible', false);
        $mode = (string) $this->params('unnamedGroup1', '');
        $title = trim($this->params('title'));
        $service = $this->getPageService();
        
        $page = new PageEntity();
        $page->setTitle($title)->setIsVisible($visible);
        
        if ($summary = $this->params('summary', false)) {
            $page->setSummary($summary);
        }
        $filter = new UrlPath();
        if ($identifier = $this->params('identifier', false)) {
            $page->setIdentifier($filter->filter($identifier));
        } else {
            $page->setIdentifier($filter->filter($title));
        }
        
        $service->insertPage($page, $this->params('id'), $mode);
        
        return array();
    }
}