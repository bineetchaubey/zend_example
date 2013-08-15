<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Incuser\Controller\Hello' => 'Incuser\Controller\HelloController',
            // Do similar for each other controller in your module
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'UserAuth' => 'Incuser\Plugin\UserAuth',
        )
    ),
    'router' => array(
        'routes' => array(
            'incuser' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/incuser[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Incuser\Controller\Hello',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
            'db-adapter' => function($sm) {
                    $config = $sm->get('config');
                    $config = $config['db'];
                    $dbAdapter = new Zend\Db\Adapter\Adapter($config);
                    return $dbAdapter;
                 },
             'em' => function($sm){
                $em = $sm->get('Doctrine\ORM\EntityManager');
                return $em ;
             }   
        ),
        'invokables' => array(
            'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    // ... other configuration ...
);