<?php
namespace LwcCmsPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LwcCmsPage\Service\PageServiceAwareInterface;
use LwcCmsPage\Service\PageService;
use LwcCmsPage\Entity\PageEntity;
use Zend\View\Model\ViewModel;

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
    
    public function treeAction()
    {
        $view = new ViewModel();
        return $view->setTerminal(true);
    }

    public function editAction()
    {
        $id = (int) $this->params('id', 0);
        $service = $this->getPageService();
        
        $page = new PageEntity();
        if ($id > 0) {
            $page = $service->findPageById($this->params('id'));
        }
        $form = $this->getServiceLocator()->get('LwcCmsPage\Form\Page');
        $form->bind($page);
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $service->savePage($form->getData());
                $this->flashmessenger()->addSuccessMessage('Page saved!');
            }
        }
        
        $view = new ViewModel();
        $view->setVariables(array(
            'page' => $page,
            'form' => $form
        ));
        if($this->getRequest()->isXmlHttpRequest()) {
            $view->setTerminal(true);
        }
        return $view;
    }
}