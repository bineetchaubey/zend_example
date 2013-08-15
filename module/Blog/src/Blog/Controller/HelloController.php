<?php

namespace Blog\Controller;

/**
*  Hello controller class
* 
* @author bineet kumar chaubey
*/

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Model\Post; 
use Blog\Form\PostForm;
use Blog\Form\JoinGroupForm;
use Incuser\Form\RegisterForm;
use Zend\Session\Container;
// use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManager;
use Zend\Db\TableGateway\TableGateway; 
use Zend\Db\Sql\Sql;


// use Doctrine\ORM\Tools\Pagination\Paginator; // for only Doctrine pagination

// for Doctrine with zend pagination 
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;



class HelloController  extends  AbstractActionController
{
    protected $em;

    protected $postTable;

	 public function worldAction()
    {
        $message = $this->params()->fromQuery('message', 'foo');
        return new ViewModel(array('message' => $message));
    }

     public function indexAction()
    {
    	$messaage = "Blog index page";
    	return new ViewModel(array('anything' => $messaage));
    }

    public function userAction()
    {
         echo "I did it";
         die("Thanks");
    }


    public function getPostTable()
    {
        if (!$this->postTable) {
            $sm = $this->getServiceLocator();
            $this->postTable = $sm->get('Blog\Model\PostTable');
        }
        return $this->postTable;
    }
    
     function getpostAction(){

          return new ViewModel(array(
            'posts' => $this->getPostTable()->fetchAll(),
        ));   

     }

    public function addAction(){

        $form = new PostForm();
        $form->get('submit')->setValue('Add Post');

        $request = $this->getRequest();
        if($request->isPost()){
            $post = new Post();
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){

                $post->exchangeArray($form->getData());

                /*var_dump($post);
                 die("sdhjdf");*/

                $this->getPostTable()->savePost($post);
                /*echo "data save" ;
                die("dfdsf");*/
                return $this->redirect()->toRoute('blog',array(
                                                              'action' => 'getpost',
                                                                                                                   )
                                                  );
            }
        }

      $adapter = $this->getServiceLocator()->get('db-adapter');
      $projectTable = new TableGateway('users', $adapter);
      $rowset = $projectTable->select();


        foreach ($rowset as $users){
          $listuser[$users['id']] =  $users['name'] ;
        }

        return array('form' => $form,'user' => $listuser);
    }



    public function createregisterAction(){

        $event = new EventManager();

        $events = $event->getSharedManager();
        $events->attach('Incuser\Form\RegisterForm','init', function($e) {
            $form = $e->getTarget();
            $form->add(array(
            'name' => 'newextra',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                 'label' => 'New Extra dynamic'
               ),
            ));
        });

       
    $regform = new RegisterForm();
    $this->em = $this->getServiceLocator()->get('em') ;
     $request = $this->getRequest();
   

    if($request->isPost()){
       $newuser = new User();
       $regform->setInputFilter($newuser->getInputFilter());
       $regform->setData($request->getPost());
       if($regform->isValid()){
        
       $data =   $request->getPost() ;

         /**
          * below is use for Bcrypt method to encript password 
          * but did not implement in zend auth component
          * still working on it
          */
        
        /*$bcrypt = new Bcrypt();
        $data->password = $bcrypt->create($data->password);*/

        $data->password  = md5($data->password);
        $newuser->populate($data);
        $this->em->persist($newuser) ;
        $this->em->flush();
        echo "save new user data";
       }
    } 
    return new ViewModel(array('regform' => $regform ));
    }


  function ajaxdataAction(){

      /*$response = $this->getResponse();
      $response->setStatusCode(200);
      $response->setContent(array('abc' => array("writer",'publisher','moderater')));*/
       
      echo "<pre>";
      var_dump($this->getRequest()->getQuery()->firstvalue);
      echo "</pre>";
      echo  json_encode(array('abc' => array("writer",'publisher','moderater')));
      return $this->response ;
  }

   /**
   * Below action is test  for user tableGetway adapter class.
   * fetch all data form User table
   */
   
   function testtablegetwayAction(){

    $adapter = $this->getServiceLocator()->get('db-adapter');
    $projectTable = new TableGateway('users', $adapter);
    $rowset = $projectTable->select();

    /*echo "<pre>";
    var_dump($rowset);
    echo "</pre>";*/

   return new ViewModel(array('rowset' => $rowset ));

   }

   public function testsqlAction(){

    $adapter = $this->getServiceLocator()->get('db-adapter');
    $sql = new Sql($adapter);
    $select = $sql->select();
    $select->from('users');
    $select->where(array('id' => array(2,4,5)));

    // echo $select->getSqlString();
    $statement = $sql->prepareStatementForSqlObject($select);
    $results = $statement->execute();
    
   return new ViewModel(array('results' => $results));

   }

  public function jointestAction(){

    $adapter = $this->getServiceLocator()->get('db-adapter');
    $sql = new Sql($adapter);
    $select = $sql->select();
    $select->from(array('f' => 'users'))  // base table
            ->join(array('b' => 'posts'),     // join table with alias
                        'f.id = b.user_id'); 
    // $select->where(array('id' => array(2,4,5)));

    // echo $select->getSqlString();
    $statement = $sql->prepareStatementForSqlObject($select);
    $results = $statement->execute();

    return new ViewModel(array('results' => $results));

  }
  
  /**
  * Test Data  for Doctrine pagination 
  *
  */

  public function paginationdoctrineAction(){


      // with doctrine pagination only 
      /*$dql = "SELECT c  FROM Blog\Entity\User c ";
      $this->em = $this->getServiceLocator()->get('em') ;
      $query = $this->em->createQuery($dql)
                             ->setFirstResult(0)
                             ->setMaxResults(2);

      $paginator = new Paginator($query, $fetchJoinCollection = true);*/

      /*echo $c = count($paginator);
      foreach ($paginator as $user) {
          echo $user->name . "\n";
      }*/

      // find page query parameter 
      // var_dump($this->getRequest()->getQuery()->page) ;
     
      $page = $this->getRequest()->getQuery()->page ? (int) $this->getRequest()->getQuery()->page : 1;

      $this->em = $this->getServiceLocator()->get('em') ;
      $query = $this->em->createQuery("SELECT c  FROM Blog\Entity\User c ");

      $paginator = new Paginator(
                  new DoctrinePaginator(new ORMPaginator($query))
            );

      $paginator
          ->setCurrentPageNumber($page)
          ->setItemCountPerPage(2);

      return new ViewModel(array('paginator' => $paginator ));
  }

  function joingroupAction(){

    $joingorupform = new JoinGroupForm();
    $this->em =  $this->getServiceLocator()->get('em') ;

    $user_container = new Container('IndaNICUser');
    $user_id = $user_container->user_login['id'];
    // var_dump($user_container->user_login['id']) ;
    $curentuser = $this->em->find('Blog\Entity\User', $user_id);

    $poestrequest = $this->getRequest();
    if($poestrequest->isPost()){

       
       /*$userdeleteGroup = $curentuser->getGroups()->removeElement();
       foreach($userdeleteGroup as $selectdelgroups){
            $curentuser->removeElement($selectdelgroups);
        }
        $this->em->flush();*/

        $selected_group = $poestrequest->getPost('gorupname');
         foreach($selected_group  as $groupids){
          $newaddgroup = $this->em->getRepository('Blog\Entity\Group')->find($groupids);
            
          echo $groupids ;  
          $curentuser->removeGroup($groupids); //make sure the removeGroup method is defined in your User model. 
          $this->em->persist($curentuser);
          $this->em->flush();
         }
          
  
        /*foreach($selected_group  as $groupids){
              $newaddgroup = $this->em->getRepository('Blog\Entity\Group')->find($groupids);
              $curentuser->addGroups($newaddgroup);
              $this->em->flush();

        }*/


    }
    /// find loggeed in user group and format array with id
   
    $userGroup = $curentuser->getGroups();
    foreach($userGroup as $selectgroups){
        $usergorupid[] = $selectgroups->id;
    }
    
  
    // find all group 
    $groupresult = $this->em->getRepository('Blog\Entity\Group')->findAll();
    foreach($groupresult as $listgroups){
      $groups[$listgroups->id] = $listgroups->display_name;
    }

    return new ViewModel(array('form' => $joingorupform ,'groups' => $groups,'selectgroup' => $usergorupid ));

  }



}

