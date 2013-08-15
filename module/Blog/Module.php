<?php
namespace  Blog;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
* This is module class for blog
*@author Bineet Kumar Chaubey
*/
class Module 
{
	
   function getConfig()
   {
   	 return include __DIR__ . '/config/module.config.php';
   }

   function getAutoloaderConfig()
   {
	   return array(
	            'Zend\Loader\ClassMapAutoloader' => array(
	                __DIR__ . '/autoload_classmap.php',
	            ),
	            'Zend\Loader\StandardAutoloader' => array(
	                'namespaces' => array(
	                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
	                ),
	            ),
	        );
    }

     public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Blog\Model\PostTable' =>  function($sm) {
                    $tableGateway = $sm->get('PostTableGateway');
                    $table = new Model\PostTable($tableGateway);
                    return $table;
                },
                'PostTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Post());
                    return new TableGateway('posts', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
 
   /* public function onBootstrap(MvcEvent $event)
    {
        $events = $event->getApplication()->getEventManager()->getSharedManager();
        $events->attach('Incuser\Form\RegisterForm','init', function($e) {
            $form = $e->getTarget();
             
            $form->add(array(
            'name' => 'extra',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                 'label' => 'extra'
               ),
            ));
        });
        $events->attach('ZfcUser\Form\RegisterFilter','init', function($e) {
            $filter = $e->getTarget();
            // Do what you please with the filter instance ($filter)
        });
    }*/

}