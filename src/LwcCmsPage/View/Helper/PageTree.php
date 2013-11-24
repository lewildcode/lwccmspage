<?php
namespace LwcCmsPage\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Navigation\Navigation;

class PageTree extends AbstractHelper
{

    /**
     *
     * @var Navigation
     */
    protected $navigation;

    /**
     *
     * @param Navigation $container            
     */
    public function __construct(Navigation $container)
    {
        $this->setNavigation($container);
    }

    /**
     *
     * @return \LwcCmsPage\View\Helper\PageTree
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     *
     * @param Navigation $container            
     * @return \LwcCmsPage\View\Helper\PageTree
     */
    public function setNavigation(Navigation $container)
    {
        $this->navigation = $container;
        return $this;
    }

    /**
     *
     * @return \Zend\Navigation\Navigation
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     *
     * @param integer $id            
     * @return string
     */
    public function getPageUrlById($id)
    {
        if (! $page = $this->getPageById($id)) {
            return '/404';
        }
        return $page->getHref();
    }

    /**
     *
     * @param integer $id            
     * @return \Zend\Navigation\Page\AbstractPage
     */
    public function getPageById($id)
    {
        return $this->getNavigation()->findOneBy('id', 'cmspage-' . $id);
    }
}