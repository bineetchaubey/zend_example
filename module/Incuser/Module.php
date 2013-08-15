<?php

namespace  Incuser;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
* this is module class for blog
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

    public function getViewHelperConfig()
    {
        return array(
           'invokables' => array(
              'UserAuth' => 'Incuser\View\Helper\UserAuth',
           ),
        );
   }
    
}