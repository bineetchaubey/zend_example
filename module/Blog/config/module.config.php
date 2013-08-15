<?php
namespace Blog;
return array(
    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Hello' => 'Blog\Controller\HelloController',
            'Blog\Controller\Forum' => 'Blog\Controller\ForumController',
            // Do similar for each other controller in your module
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'MyFirstPlugin' => 'Blog\Plugin\MyFirstPlugin',
        )
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/blog[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Hello',
                        'action'     => 'index',
                    ),
                ),
            ),
            'forum' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/forum[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Forum',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array( 
            'pagination' => __DIR__ . '/../view/layout/pagination.phtml',
        ),
    ),
    // ... other configuration ...
    'CustomSetting' =>  array(
            'nameSetting' => 'setyouname',
            'locationsetting' => 'set yoou location',
            'key_for_facebook' => 'HJHSKJA&A&HGG6GJGS6HH7383H8GG8',
            'faceboo_pass' => 'hud8hsd7&87ghhd',
        ),

);