<?php
namespace Admin;

 use Zend\ModuleManager\ModuleManager;
 use Zend\Session\Container;
 use Locale;
class Module
{

     public function onBootstrap($e)
    {

        $user_container = new Container('IndaNICUser');
        if($user_container->locals){
            $lang = $user_container->locals;
        }else{
            $lang = "en_US";
        }

        $translator = $e->getApplication()->getServiceManager()->get('translator');
        \Locale::setDefault($lang);
        $translator
          ->setLocale($lang)
          ->setFallbackLocale('en_US');
        // echo "3".$translator->getLocale();
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    

 

    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            // This event will only be fired when an ActionController under the MyModule namespace is dispatched.
            $controller = $e->getTarget();
            $controller->layout('layout/admin');
        }, 100);
    }

}
