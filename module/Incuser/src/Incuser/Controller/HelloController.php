<?php
namespace Incuser\Controller;
/**
*  main controler for Forum Module
* 
* @author Bineet Chaubey 
* @version 1.0
* @package Zend2
*/

use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\Bcrypt;
use Zend\Crypt\BlockCipher;
use Zend\View\Model\ViewModel;
use Blog\Form\GroupForm;
use Blog\Entity\Post;
use Blog\Entity\User;
use Blog\Entity\Group;
use Incuser\Form\LoginForm;
use Incuser\Form\RegisterForm;
use Zend\Session\Container;

class HelloController extends AbstractActionController 
{
   /**
   *  get instaend dbadpter ;
   */
   var $db;

   /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
 
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    } 

    
	public function indexAction(){
         return new ViewModel(array('message' => "Welcome"));
	}

   function getallpostAction(){
       return new ViewModel(array(
            // 'Posts' => $this->getEntityManager()->getRepository('Blog\Entity\Post')->findAll() 
            'Posts' => $this->getServiceLocator()->get('em')->getRepository('Blog\Entity\Post')->findAll()
        )); 

    }

    function addgroupAction(){
    	$form = new GroupForm();
      $this->getEntityManager();

        $request = $this->getRequest();
         if($request->isPost()){
           $newgroup = new Group();
           $form->setInputFilter($newgroup->getInputFilter());
           $form->setData($request->getPost());

           if($form->isValid()){
             $newgroup->parsearraydata($request->getPost());
             // $this->getEntityManager();
             $this->em->persist($newgroup) ;
             $this->em->flush();
             echo "save data";
           }
         }

       return new ViewModel( array('form' => $form ));
    }

    /**
    *  This funtion is test for use a custom setting define in any module.config.php
    *  file and find  his array elements her like bellow;
    *  CustomSetting is an array difine in Blog \ config\ module.config.php file 
    *  and  here i am access  those value; only for example;
    * 
    */

    public function getcustomcettingAction(){

    	$CustomSetting = $this->getServiceLocator()->get('config');

         echo "<pre>";
         var_dump($CustomSetting['CustomSetting']);

         var_dump($CustomSetting['db']);

         var_dump($CustomSetting['DefaultConfigsetting'] );

         die("this is get module.config.php  file value and config\autoload\(local,global).php file contents");
    }


    public function login2Action(){

          $form = new LoginForm();
          /** Find the Dbadapter instance  */
          $auth = new AuthenticationService();

          /**  check use login or not */
          if ($auth->hasIdentity()) {
            return $this->redirect()->toRoute('forum');
          }
          
          $request = $this->getRequest();
          if($request->isPost()){
              $this->db = $this->getServiceLocator()->get('db-adapter');
              $authAdapter = new AuthAdapter($this->db);
              //$bcrypt = new Bcrypt();
               
              $data = $request->getPost();
              // echo md5($data['password']) ;
              $authAdapter
                  ->setTableName('users')
                  ->setIdentityColumn('username')
                  ->setCredentialColumn('password');
              $authAdapter
                  ->setIdentity($data['username'])
                  ->setCredential(md5($data['password'])); 

              $result = $authAdapter->authenticate();

              if($result->isValid()){
                  $storage = $auth->getStorage();
                  // store the identity as an object where the password column has
                  // been omitted
                  $storage->write($authAdapter->getResultRowObject(
                      null,
                      'password'
                  ));
                return $this->redirect()->toRoute('incuser',array(
                                                              'action' => 'checklogin',
                                                              'id' => '1234'
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
        return new ViewModel(array('form' => $form));
    }

    public function checkloginAction(){
        
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
             // echo $auth->getIdentity();
        }else{
          return $this->redirect()->toRoute('application');
        }
       return new ViewModel(array('userdata' => $auth->getIdentity()));
    }

   /**
   * User Logout Functionality Login With Zend\Authentication
   */

   public function logoutAction(){
     $auth = new AuthenticationService();
     $auth->clearIdentity();

     $session_user = new Container('IndaNICUser');
     $session_user->getManager()->getStorage()->clear('IndaNICUser');

     return $this->redirect()->toRoute('incuser');
   }

  function registerAction(){

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
        $this->flashMessenger()->addMessage('Registration Done Successfull');

          return $this->redirect()->toRoute('incuser',array(
                                                              'action' => 'login',
                                                              
                                                            )
                                                  );

       }
    }
    return new ViewModel(array('regform' => $regform ));

  }

  
 public function loginAction(){

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
                return $this->redirect()->toRoute('incuser',array(
                                                              'action' => 'index',
                                                              /*'id' => '1234'*/
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
        return new ViewModel(array('form' => $form));
    }
}
