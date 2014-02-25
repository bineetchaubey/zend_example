<?php
namespace Admin\Controller;

/**
*  This is admin home page controller  clas  file
*
*
* PHP 5.4
*
* @author Bineet kumar chaubey
*/
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\Bcrypt;
use Zend\Crypt\BlockCipher;
use Zend\View\Model\ViewModel;
use Blog\Entity\User;
use Blog\Entity\Post;
use Blog\Entity\Group;
use Incuser\Form\LoginForm;
use Incuser\Form\RegisterForm;
use Admin\Form\CmsForm;
use Zend\Session\Container;

class HomeController extends  AbstractActionController
{

	/**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
    * Set Doctrine Entity manager
    * $2y$14$grHsYFaK0B56GpZFj1qkLe3iykGB7ZtTtYA4vF6g7OK37MlCrim76
    *
    * @author Bineet Kumar Chaubey
    * @param Object  DOctrine EntityMnager
    * @return Object Entity manager
    */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    /**
    * Set Doctrine Entity manager
    *
    * @author Bineet Kumar Chaubey
    * @return Object Entity manager
    */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    } 

    /**
    * Index default action 
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
    function indexAction(){

    	// var_dump($this->UserAuth()->checkLogin()) ;
 
       $this->getEntityManager();
       
    	if($this->UserAuth()->checkLogin() == false){
             
    		return $this->redirect()->toRoute("admin",array('module' =>"admin",'Contoller' => 'home','action' =>'login'));
    	}


     $query = $this->em->createQuery('SELECT count(u.id) FROM Blog\Entity\User u');
     $usersresult = $query->getResult();    
     $query2 = $this->em->createQuery('SELECT count(u.id) FROM Blog\Entity\Cms u');
     $cmsresult = $query2->getResult();

     return new ViewModel(array("usercount" => $usersresult, 'cmscount' => $cmsresult));

    }
    
    /**
    * Fetch all user action 
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
    function usersAction(){
       
       $queryresult = $this->getEntityManager()->getRepository('Blog\Entity\User')->findAll();     
       return new ViewModel(array('userresult' => $queryresult ));

    }

    /**
    * Fetch all cms page action 
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
    function cmsAction(){
    	$queryresult = $this->getEntityManager()->getRepository('Blog\Entity\Cms')->findAll();
        return new ViewModel(array('cmsresult' => $queryresult ));
    }

    /**
    * Login  Action
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
    function loginAction(){

    	 $form = new LoginForm();
          /** Find the Dbadapter instance  */
          /* $auth = new AuthenticationService();*/

          /**  check use login or not */
          /*if ($auth->hasIdentity()) {
            return $this->redirect()->toRoute('forum');
          }*/
          
          $request = $this->getRequest();
          if($request->isPost()){
             
              //$bcrypt = new Bcrypt();

              $outhpluobj =  $this->UserAuth();           
              $outhpluobj->setUsername($request->getPost()->username);
              $outhpluobj->setPassword($request->getPost()->password);
              $result = $outhpluobj->authenticate();

              if($result){                 
                return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'index',
                                                              /*'id' => '1234'*/
                                                            )
                                                  );
              }else{
                $this->flashMessenger()->addMessage(_("User and password does not match .please try again."),'error');
                return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'login',
                                                          
                                                            )
                                                  );
              }

          }
          /**
          * below is what we want to return after  authecticate;
          * $authAdapter->getResultRowObject($columnsToReturn)
          */
          // $columnsToReturn = array('id', 'username', 'real_name');
          /*echo $result->getIdentity() . "\n\n";
          print_r($authAdapter->getResultRowObject());*/  
        $loginview =  new ViewModel(array('form' => $form));
        $loginview->setTerminal(true);
        return $loginview;
    }


   /**
   * Admin Logout Functionality Login With Zend\Authentication
   */
   public function logoutAction(){
     $auth = new AuthenticationService();
     $auth->clearIdentity();

     $session_user = new Container('IndaNICUser');
     $session_user->getManager()->getStorage()->clear('IndaNICUser');
     return $this->redirect()->toRoute('admin' ,array('action' =>'login'));
   }
 
    /**
    * Create new user 
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
   function createuserAction(){
       
        $regform = new RegisterForm();
    $this->getEntityManager();
    $request = $this->getRequest();
   
    if($request->isPost()){
       $newuser = new User();
       $regform->setInputFilter($newuser->getInputFilter());
       $regform->setData($request->getPost());
       if($regform->isValid()){
        
        $data =   $request->getPost() ;

         /**
          * below is use for Bcrypt method to encript password 
          */

        $bcrypt = new Bcrypt();
        $data->password = $bcrypt->create($data->password);

        /**
        * For md5 hash and Use Zend/DbAdapter/Authentication for Login time authenticate
        */
         /*$data->password  = md5($data->password);*/

        $newuser->populate($data);
        $this->em->persist($newuser);
        $this->em->flush();
        $this->flashMessenger()->addMessage(_('Create new User Successfully'));

          return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'users',
                                                              
                                                            )
                                                  );

       }
    }
    return new ViewModel(array('regform' => $regform ));

   }
   
   /**
    * Edit user  action 
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
   function edituserAction(){

   
    $id = $this->params('id');
    if(!$this->params('id')){
      return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'users',
                                                              
                                                            )
                                                  );
    }
    $regform = new RegisterForm();
    $this->getEntityManager();
    $request = $this->getRequest();

   
    if($request->isPost()){
       $newuser = new User();
       $regform->setInputFilter($newuser->getInputFilter());
       $regform->setValidationGroup('name', 'email', 'username', 'age','role','state');
       $regform->setData($request->getPost());
       if($regform->isValid()){
        
        $data =   $request->getPost() ;

         /**
          * below is use for Bcrypt method to encript password 
          */
        if($data->password != ''){
         $bcrypt = new Bcrypt();
         $newuser->password = $bcrypt->create($data->password);
        }else{
          // unset($data->password);
        }
        /**
        * For md5 hash and Use Zend/DbAdapter/Authentication for Login time authenticate
        */
         /*$data->password  = md5($data->password);*/
        $newuser->id = $id;
        $newuser->name = $data->name;
        $newuser->username = $data->username;
        $newuser->age = $data->age;
        $newuser->email = $data->email;
        $newuser->role = $data->role;
        $newuser->state = $data->state;

        // $newuser->populate($data);
        $this->em->merge($newuser);
        $this->em->flush();
        $this->flashMessenger()->addMessage(_('Update Done Successfull'));

          return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'users',
                                                              
                                                            )
                                                  );

       }
    }
   
     $formesult = $this->getEntityManager()->getRepository('Blog\Entity\User')->findById($id);    
    
    if(empty($formesult)){
       return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'users',
                                                              
                                                            )
                                                  );
    }

    return new ViewModel(array('regform' => $regform,'form_result' => $formesult ));
   }
   
   /**
    * Change lnagugae by admin
    *
    *
    * @author Bineet Kumar Chaubey
    */
   function changelangAction(){

         $user_container = new Container('IndaNICUser');
         if($this->params('id') == 2){
          $user_container->locals = 'hin_IN';
         }else if($this->params('id') == 3){
          $user_container->locals = 'gu_IN';
         }else{
          $user_container->locals = 'en_US';
         }

         $asdurl = $this->getRequest()->getHeader('Referer')->getUri();
         $this->redirect()->toUrl($asdurl);
        /* return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'users',
                                                              
                                                            )
                                                  );*/
   }
    
  /**
    * Create new page action 
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
   function createnewpageAction(){
           
    $cmsform = new CmsForm();
    $this->getEntityManager();
    
    $request = $this->getRequest();
    if($request->isPost()){
      $cmsEntity = new  \Blog\Entity\Cms();

      $cmsform->setInputFilter($cmsEntity->getInputFilter());
      // $regform->setInputFilter($newuser->getInputFilter());
      $cmsform->setData($request->getPost());
      if($cmsform->isValid()){
          $data = $request->getPost();
          $cmsEntity->populate($data);
          $this->em->persist($cmsEntity);
          $this->em->flush();
          $this->flashMessenger()->addMessage(_('Page add Successfull'));
          return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'cms',
                                                              
                                                            )
                                                  );

       }
    }

      return new ViewModel(array('cmsform' => $cmsform));
   }

   /**
    * Edit cms page action 
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
   function editcmspageAction(){
           
    $id = $this->params('id');

    $cmsform = new CmsForm();
    $this->getEntityManager();
    
    $request = $this->getRequest();
    if($request->isPost()){
      $cmsEntity = new  \Blog\Entity\Cms();

      $cmsform->setInputFilter($cmsEntity->getInputFilter());
      // $regform->setInputFilter($newuser->getInputFilter());
      $cmsform->setData($request->getPost());
      if($cmsform->isValid()){
          $data = $request->getPost();
          $cmsEntity->id = $id;
          $cmsEntity->uppopulate($data);

          $this->em->merge($cmsEntity);
          $this->em->flush();
          $this->flashMessenger()->addMessage(_('Update Page Successfully'));
          return $this->redirect()->toRoute('admin',array(
                                                              'action' => 'cms',
                                                              
                                                            )
                                                  );

       }
    }
    
    $cmspageres = $this->em->getRepository('\Blog\Entity\Cms')->findById($id);
    return new ViewModel(array('cmsform' => $cmsform,'cmspageres' => $cmspageres));

   }
   
   /**
    * Delete cms page action 
    *
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel 
    */
   function deletepageAction(){

       $id = $this->params('id');
      // $cmspage = $this->getEntityManager()->getRepository('Blog\Entity\Cms')->findById($id);
       $cmspage = $this->getEntityManager()->find('Blog\Entity\Cms', $id);
       $this->em->remove($cmspage);
       $this->em->flush();
       $this->flashMessenger()->addMessage(_('Page deleted successfully'));
       return $this->redirect()->toRoute('admin',array(
                                                                'action' => 'cms',
                                                                
                                                              )
                                                    );
      die();
   }

}