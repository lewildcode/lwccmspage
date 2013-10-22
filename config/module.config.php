<?php
$constraint = '[a-zA-Z][a-zA-Z0-9_-]*';
return array(
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
                        'lvl1' => $constraint,
                        'lvl2' => $constraint,
                        'lvl3' => $constraint,
                        'lvl4' => $constraint,
                        'lvl5' => $constraint
                    )
                )
            ),
            'lwccmspageadmin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/pages[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'LwcCmsPage\Controller\Admin',
                        'action' => 'index'
                    )
                )
            ),
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
            'LwcCmsPage\Controller\Admin' => 'LwcCmsPage\Controller\AdminController'
        ),
        'factories' => array(
            'LwcCmsPage\Controller\Cli' => function ($cm)
            {
                $ps = $cm->getServiceLocator()->get('LwcCmsPage\Service\Page');
                return new LwcCmsPage\Controller\CliController($ps);
            }
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'template_map' => array(
            'layout/sitemap' => __DIR__ . '/../view/lwc-cms-page/layout/sitemap.xml.phtml',
         )
    )
);