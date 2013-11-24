<?php
namespace LwcCmsPage\Navigation\Service;

use Zend\Navigation\Service\AbstractNavigationFactory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Adapter\Adapter;

use LwcCmsPage\Table\PageTable;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Navigation\Navigation;
use Zend\Navigation\Page\AbstractPage;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface as Router;

class CmsTreeNavigationFactory extends AbstractNavigationFactory implements AdapterAwareInterface
{

    /**
     *
     * @var PageTable
     */
    protected $tableGateway;

    /**
     *
     * @var Adapter
     */
    protected $dbAdapter;

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Db\Adapter\AdapterAwareInterface::setDbAdapter()
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->dbAdapter = $adapter;
        return $this;
    }

    /**
     *
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Navigation\Service\AbstractNavigationFactory::getName()
     */
    protected function getName()
    {
        return 'cms_tree';
    }

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Zend\Navigation\Navigation
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->setDbAdapter($serviceLocator->get('LwcCmsPage\DbAdapter'));
        $this->setTableGateway($serviceLocator->get('LwcCmsPage\Table\Page'));

        $navigation = new Navigation();
        $pages = $this->getPages($serviceLocator);

        $previousDepth = null;
        $parentPage = null;
        $previousPage = null;

        foreach ($pages as $page) {
            $depth = $page->depth;
            if ($depth == 0) {
                $navigation->addPage($page);
                $parentPage = $page;
            } elseif ($depth > $previousDepth) {
                $previousPage->addPage($page);
            } else if ($depth == $previousDepth) {
                $previousPage->getParent()->addPage($page);
            } else {
                $previousPage->getParent()->getParent()->addPage($page);
            }

            $previousPage = $page;
            $previousDepth = $depth;
        }

        return $navigation;
    }

    /**
     *
     * @param PageTable $gateway
     * @return \LwcCmsPage\Navigation\Service\CmsTreeNavigationFactory
     */
    public function setTableGateway(PageTable $gateway)
    {
        $this->tableGateway = $gateway;
        return $this;
    }

    /**
     *
     * @return \LwcCmsPage\Table\PageTable
     */
    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    /**
     *
     * @return array
     */
    protected function getTreeColumns()
    {
        $joinName = 'parent';
        $expr = new Expression('COUNT(' . $joinName . '.id) - 1');
        return array(
            '*',
            'depth' => $expr,
            'identifier' => $this->getTableGateway()->getPathExpression()
        );
    }

    /**
     *
     * @return \Zend\Db\Sql\Select
     */
    protected function getTreeSelect()
    {
        $table = $this->getTableGateway()->getTable();
        $joinName = 'parent';

        $select = new Select($table);
        $select->columns($this->getTreeColumns());
        $on = '(' . $table . '.lft BETWEEN ' . $joinName . '.lft AND ' . $joinName . '.rgt)';

        $select->join(array(
            $joinName => $table
        ), $on, array());
        $select->group($table . '.id');
        $select->order($table . '.lft');
        return $select;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Navigation\Service\AbstractNavigationFactory::getPages()
     */
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            $gateway = $this->getTableGateway();
            $resultSet = $gateway->selectWith($this->getTreeSelect());

            $pages = array();
            foreach ($resultSet as $row) {
                if(!$title = $row->getSubtitle()) {
                    $title = $row->getTitle();
                }
                $pages[] = AbstractPage::factory(array(
                    'id' => 'cmspage-' . $row->getId(),
                    'uri' => $row->getIdentifier(),
                    'depth' => $row->getDepth(),
                    'label' => $row->getTitle(),
                    'title' => $title,
                    'visible' => $row->getIsVisible(),
                    'order' => $row->getLft(),
                    'changefreq' => $row->getChangefreq(),
                    'priority' => $row->getPriority()
                ));
            }
            $this->pages = $pages;
        }
        return $this->pages;
    }
}