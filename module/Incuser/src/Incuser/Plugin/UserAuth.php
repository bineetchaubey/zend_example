<?php
namespace Incuser\plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\EventManager\EventManager;
use Zend\EventManager\Event;
use Blog\Entity\User;
use Zend\Crypt\Password\Bcrypt;
use Zend\Session\Container;

/**
* Controller plugin For userAuthentication With Bcript password encription method 
* @author Bineet kumar chaubey
*/

class UserAuth extends AbstractPlugin
{
	
	var $name ;
  var $em ;
	var $events;
	var $username;
	var $password;
 
    
	
	function __construct()
	{
		$this->name = "User Authentication plugin";
	}

	/**
    *  Set Username
    */

    function setUsername($username){
    	$this->username = $username;
    }

    /**
    *  Set password
    */

    function setPassword($password){
    	$this->password = $password;
    }

    public function events() 
    {
        if (!$this->events) {
            $this->events = new EventManager(__CLASS__); 
        }
        return $this->events;
    }

    public function authenticate(){

      $bcrypt = new Bcrypt();
      $this->em = $this->getController()->getServiceLocator()->get('em');
      $query = $this->em->createQuery('SELECT u FROM Blog\Entity\User u WHERE u.username = :username');
      $query->setParameter('username', $this->username);
      // $users = $query->getResult();
      $users = $query->getSingleResult();

      /*echo "<pre>";
       var_dump($users->name);
       var_dump($users->username);
       var_dump($users->password);
       var_dump($users->age);
      echo "</pre>";
      $varifupass =  $bcrypt->create($this->password);
      echo $varifupass ;

       if($bcrypt->verify($this->password,$varifupass)){
      	echo "true and yes ";
      }else{
      	echo "fail and no";
      } */

       $user_cagential['name'] = $users->name ;
       $user_cagential['username'] = $users->username ;
       $user_cagential['age'] = $users->age ;
       $user_cagential['role'] = $users->role ;
       $user_cagential['id'] = $users->id ;

      if($bcrypt->verify($this->password,$users->password)){

          $user_container = new Container('IndaNICUser');
          $user_container->user_login = $user_cagential;        
      	  return true;
      }else{
      	return false;
      } 
    }
}
