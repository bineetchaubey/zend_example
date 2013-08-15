<?php
namespace Myacl\Controller\Plugin;
/**
* This is Acl controoler Plugin 
* @author Bineet Kumar chaubey
* @version 1.0
* @package Zend 2
* @subpackage Zend\Acl
*/


use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Authentication\AuthenticationService,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;
    use Zend\Session\Container;


class MyAclPlugin extends AbstractPlugin
{
	
	protected $sesscontainer ;
    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('zftutorial');
        }
        return $this->sesscontainer;
    }
    
    public function doAuthorization($e)
    {
        // auth component for chek ogin user Role
        $auth = new AuthenticationService();

        $ehodh = $this->getController()->getServiceLocator()->get('config');

       /* echo "<pre>";
        var_dump($ehodh);
        echo "</pre>";*/


        // set ACL
        $acl = new Acl();
        $acl->deny(); // on by default
        //$acl->allow(); // this will allow every route by default so then you have to explicitly deny all routes that you want to protect.             
                
       /* # ROLES ############################################
        $acl->addRole(new Role('anonymous'));
        $acl->addRole(new Role('user'),  'anonymous');
        $acl->addRole(new Role('admin'), 'user');
        # end ROLES ########################################
       
        # RESOURCES ########################################
        $acl->addResource('application'); // Application module
        $acl->addResource('blog'); // Album module
        $acl->addResource('forum');
        # end RESOURCES ########################################
                
        ################ PERMISSIONS #######################
        // $acl->allow('role', 'resource', 'controller:action');
                
        // Application -------------------------->
        $acl->allow('anonymous', 'application', 'index:index');
        $acl->allow('anonymous', 'application', 'profile:index');
       
        // Album -------------------------->
        $acl->allow('anonymous', 'blog', 'forum:index'); 
        $acl->allow('anonymous', 'blog', 'forum:insertuserwithgroup'); 
        $acl->deny('anonymous', 'blog', 'forum:gettestplugin'); 
        $acl->allow('anonymous', 'forum', 'blog:view');
        $acl->allow('anonymous', 'forum', 'hello:addGroup');
        $acl->allow('anonymous', 'forum', 'hello:getallpost');*/

        # Start dynamic create role , resource and acl based of acl.config.global.php config file ########################

        // $useracl = $this->getServiceLocator()->get('userAcl');
        $useracl = $this->getController()->getServiceLocator()->get('config');
         
        $aclRecords = $useracl['userAcl'];

        $preuser = null ;
        foreach ($aclRecords as $key => $value) {
             $acl->addRole(new Role($key), $preuser);
             $preuser = $key ;
             foreach($value  as $resource => $permissions){
                if(!$acl->hasResource($resource)){
                     $acl->addResource($resource);
                 }
                 foreach($permissions as $permission){
                    $acl->allow($key, $resource, $permission);
                 }
             }
        }

        // also allows route: zf2-tutorial.com/album/edit/1
        //$acl->deny('anonymous', 'Album', 'Album:song');
        ################ end PERMISSIONS #####################
                
                
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $moduleName = strtolower(substr($controllerClass, 0, strpos($controllerClass, '\\')));
        
        /**
        *  get current user role  if not logged in the role is anonymous if using default
        *  zend 2 auththetication module 
        */

        /*$storage = $auth->getStorage();
        $userdetail = $storage->read();*/

        // this is custom authetication user role when using Bcript method to encript password
        $user_container = new Container('IndaNICUser');
       
        // var_dump($user_container->user_login);
         
        // $role = (! $this->getSessContainer()->role ) ? 'user' : $this->getSessContainer()->role;
        $role = (!isset($userdetail) ) ? 'anonymous' : $userdetail->role;
        $role = (!isset($user_container->user_login) ) ? 'anonymous' : $user_container->user_login['role'];

        $routeMatch = $e->getRouteMatch();
                
        $actionName = strtolower($routeMatch->getParam('action', 'not-found')); // get the action name  
        $controllerName = $routeMatch->getParam('controller', 'not-found');     // get the controller name      
        $valuepass = explode('\\', $controllerName);
        $controllerName = strtolower(array_pop($valuepass));
        
				
               /* print '<br>$moduleName: '.$moduleName.'<br>'; 
                print '<br>$controllerClass: '.$controllerClass.'<br>'; 
                print '$controllerName: '.$controllerName.'<br>'; 
                print '$action: '.$actionName.'<br>'; */
               
                
                #################### Check Access ########################
       if ( ! $acl->isAllowed($role, $moduleName, $controllerName.':'.$actionName)){
            $router = $e->getRouter();
           // $url    = $router->assemble(array(), array('name' => 'Login/auth')); // assemble a login route
             $this->getController()->flashMessenger()->addMessage('Access Denied, You are not authorized to access this page.');

            $url    = $router->assemble(array(), array('name' => 'forum'));
            $response = $e->getResponse();
            $response->setStatusCode(302);
            // redirect to login page or other page.
            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();            
        }           
    }
}
