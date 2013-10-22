<?php
namespace LwcCmsPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LwcCmsPage\Form\PageForm;

class AdminController extends AbstractActionController
{
    public function indexAction()
    {
        $service = $this->getServiceLocator()->get('LwcCmsPage\Service\Page');
        return array(
            'pages' => $service->getTable()->select()
        );
    }

    public function editAction()
    {
        $id = (int) $this->params('id', 0);
        $service = $this->getServiceLocator()->get('LwcCmsPage\Service\Page');

        $page = $service->findPageById($id);
        $form = new PageForm();
        $form->bind($page);
        return array(
            'page' => $page,
            'form' => $form
        );
    }

    public function saveAction()
    {
        if(!$this->getRequest()->isPost()) {
            return $this->redirect('index');
        }

    }
}