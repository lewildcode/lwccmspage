<?php
$settings = array(
    // sql table name of the pages
    'pagetable' => 'cms_page',
    
    // sql table name of rows of contents per page
    'rowtable' => 'cms_row',
    
    // allowed page url letters
    'url_tree_constraint' => '[a-zA-Z][a-zA-Z0-9_-]*',
);

return array(
    'lwccmspage' => $settings,
    'console' => array(
        'router' => array(
            'routes' => array(
                'lwccmspage_create' => array(
                    'options' => array(
                        'route' => 'create page [after|before|last|first] <id> --title= [--identifier=] [--summary=] [--visible=]',
                        'defaults' => array(
                            'controller' => 'LwcCmsPage\Controller\Cli',
                            'action' => 'create',
                            'visible' => true
                        )
                    )
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'lwccmssitemap' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/sitemap.xml',
                    'defaults' => array(
                        'controller' => 'LwcCmsPage\Controller\Page',
                        'action' => 'sitemap'
                    )
                )
            ),
            'lwccmspage' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/:lvl1[/:lvl2[/:lvl3[/:lvl4[/:lvl5]]]]',
                    'defaults' => array(
                        'controller' => 'LwcCmsPage\Controller\Page',
                        'action' => 'view'
                    ),
                    'constraints' => array(
                        'lvl1' => $settings['url_tree_constraint'],
                        'lvl2' => $settings['url_tree_constraint'],
                        'lvl3' => $settings['url_tree_constraint'],
                        'lvl4' => $settings['url_tree_constraint'],
                        'lvl5' => $settings['url_tree_constraint']
                    )
                )
            ),
            'zfcadmin' => array(
                'child_routes' => array(
                    'lwcpages' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/pages[/:action][/:id]',
                            'defaults' => array(
                                'controller' => 'LwcCmsPage\Controller\Admin',
                                'action' => 'index'
                            )
                        )
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'aliases' => array(
            'LwcCmsPage\DbAdapter' => 'dbAdapter'
        ),
        'factories' => array(
            'LwcCmsPage\Table\Page' => 'LwcCmsPage\Table\PageTableFactory',
            'LwcCmsPage\Table\Row' => 'LwcCmsPage\Table\RowTableFactory',
            'LwcCmsPage\Service\Page' => 'LwcCmsPage\Service\PageServiceFactory',
            'LwcCmsPage\Service\Row' => 'LwcCmsPage\Service\RowServiceFactory',
            'cms_tree' => 'LwcCmsPage\Navigation\Service\CmsTreeNavigationFactory'
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'LwcCmsPage\Controller\Page' => 'LwcCmsPage\Controller\PageController',
            'LwcCmsPage\Controller\Admin' => 'LwcCmsPage\Controller\AdminController',
            'LwcCmsPage\Controller\Cli' => 'LwcCmsPage\Controller\CliController'
        ),
        'initializers' => array(
            'pageService' => function ($controller, $manager)
            {
                if ($controller instanceof \LwcCmsPage\Service\PageServiceAwareInterface) {
                    $service = $manager->getServiceLocator()->get('LwcCmsPage\Service\Page');
                    $controller->setPageService($service);
                }
            }
        )
    ),
    'navigation' => array(
        'admin' => array(
            'pages' => array(
                'type' => 'mvc',
                'route' => 'zfcadmin/lwcpages',
                'label' => 'Pages'
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'template_map' => array(
            'layout/sitemap' => __DIR__ . '/../view/lwc-cms-page/layout/sitemap.xml.phtml'
        )
    )
);