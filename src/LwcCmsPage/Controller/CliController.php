<?php
namespace LwcCmsPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LwcCmsPage\Service\PageService;
use LwcCmsPage\Entity\PageEntity;
use LwcCmsPage\Filter\UrlPath;

class CliController extends AbstractActionController
{

    /**
     *
     * @var PageService
     */
    protected $service;

    /**
     *
     * @param PageService $service
     */
    public function __construct(PageService $service)
    {
        $this->setPageService($service);
    }

    /**
     *
     * @param PageService $service
     * @return \LwcCmsPage\Controller\CliController
     */
    public function setPageService(PageService $service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     *
     * @return \LwcCmsPage\Service\PageService
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