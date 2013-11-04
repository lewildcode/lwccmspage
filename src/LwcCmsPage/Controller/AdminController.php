<?php
namespace LwcCmsPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LwcCmsPage\Form\PageForm;
use LwcCmsPage\Service\PageServiceAwareInterface;
use LwcCmsPage\Service\PageService;
use LwcCmsPage\Entity\PageEntity;

class AdminController extends AbstractActionController implements PageServiceAwareInterface
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

    public function indexAction()
    {
        return array(
            'pages' => $this->getPageService()
                ->getTable()
                ->select()
        );
    }

    public function editAction()
    {
        $id = (int) $this->params('id', 0);
        $service = $this->getPageService();
        
        $page = new PageEntity();
        if ($id > 0) {
            $page = $service->findPageById($this->params('id'));
        }
        $form = new PageForm();
        $form->bind($page);
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $service->savePage($page);
            }
        }
        return array(
            'page' => $page,
            'form' => $form
        );
    }
}