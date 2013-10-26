<?php
namespace LwcCmsPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LwcCmsPage\Service\PageServiceAwareInterface;
use LwcCmsPage\Service\PageService;

class PageController extends AbstractActionController implements PageServiceAwareInterface
{
    /**
     * 
     * @var PageService
     */
    protected $pageService;

    /**
     * (non-PHPdoc)
     * 
     * @see \LwcCmsPage\Service\PageServiceAwareInterface::setPageService()
     */
    public function setPageService(PageService $pageService)
    {
        $this->pageService = $pageService;
        return $this;
    }

    /**
     *
     * @return PageService
     */
    public function getPageService()
    {
        return $this->pageService;
    }

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction()
    {
        $path = array();
        foreach ($this->params()->fromRoute() as $param => $value) {
            if (substr($param, 0, 3) == 'lvl') {
                $path[] = $value;
            }
        }
        
        $service = $this->getServiceLocator()->get('LwcCmsPage\Service\Page');
        $page = $service->findPageByUri('/' . join('/', $path));
        
        if (! $page || ! $page->getIsVisible()) {
            return $this->notFoundAction();
        }
        
        $rowService = $this->getServiceLocator()->get('LwcCmsPage\Service\Row');
        $contentService = $this->getServiceLocator()->get('LwcCmsContent\Service\Content');
        $rows = $rowService->getRowsForPage($page);
        foreach ($rows as $row) {
            $contents = $contentService->getContentsForRow($row);
            $row->setContents($contents);
            $page->addContentRow($row);
        }
        
        return array(
            'page' => $page
        );
    }

    public function sitemapAction()
    {
        $this->layout('layout/sitemap');
        $this->getResponse()
            ->getHeaders()
            ->addHeaders(array(
            'Content-type' => 'text/xml'
        ));
    }
}