<?php
namespace LwcCmsPage\Service;

interface PageServiceAwareInterface
{

    /**
     *
     * @param PageService $pageService            
     */
    public function setPageService(PageService $pageService);

    /**
     *
     * @return PageService
     */
    public function getPageService();
}