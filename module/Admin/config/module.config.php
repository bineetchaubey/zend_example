<?php
namespace  Admin;
return array(
	'controllers' => array(
		'invokables' => array(
			'Admin\Controller\Home' => 'Admin\Controller\HomeController'
			)

		),
	'router' => array(
		'routes' => array(
			'admin' => array(
				'type' => 'segment',
				'options' =>array(
					'route' => '/admin[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
						),
					'defaults' =>array(
						'controller' => 'Admin\Controller\Home',
						'action' => 'index',
						)

					)

				)

			)
		),
	'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array( 
            'layout/admin' => __DIR__ . '/../view/layout/admin.phtml',
        ),
    ),
    'module_layouts' => array(
      'Admin' => array(
          'default' => 'layout/admin',
        )
     ),

);