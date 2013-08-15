<?php 
namespace Incuser\Form;

use Zend\Form\Form;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

/**
* Form Fo Registration  a User
* @author Bineet Kumar Chaubey
*/
class RegisterForm extends Form  implements EventManagerAwareInterface
{

	protected $eventManager;
	
	function __construct($name = null)
	{
		 parent::__construct('register');

		 $this->setAttribute('method','post');
		 $this->add(array(
		 	      'name' => 'name',
		 	      'type' => 'Zend\Form\Element\Text',
		 	      'options' => array(
		 	      	   'label' => 'name'
		 	      	 ),
		 	      ));


		 $this->add(array(
		 	      'name' => 'username',
		 	      'type' => 'Zend\Form\Element\Text',
		 	      'options' => array(
		 	      	   'label' => 'Username'
		 	      	 ),
		 	      ));

		 $this->add(array(
		 	      'name' => 'password',
		 	      'type' => 'Zend\Form\Element\Password',
		 	      'options' => array(
		 	      	   'label' => 'Password'
		 	      	 ),
		 	      ));

		 $this->add(array(
		 	      'name' => 'age' ,
		 	      'type' => 'Zend\Form\Element\text',
		 	      'options' => array(
		 	      	   'label' => 'age'
		 	      	 ),
		 	      ));

		 $this->add(array(
		 	      'name' => 'email' ,
		 	      'type' => 'Zend\Form\Element\text',
		 	      'options' => array(
		 	      	   'label' => 'Email'
		 	      	 ),
		 	      ));

		 $this->add(array(
		 	      'name' => 'role' ,
		 	      'type' => 'Zend\Form\Element\Select',
		 	      'options' => array(
		 	      	   'label' => 'Role'
		 	      	 ),
		 	      'attributes' =>  array(
				        'id' => 'usernames',                
				        'options' => array(
				            'admin' => 'Admin',
				            'user' => 'User',
				        ),
				    ),
		 	    ));

		 $this->add(array(
		 	      'name' => 'state' ,
		 	      'type' => 'Zend\Form\Element\Select',
		 	      'options' => array(
		 	      	   'label' => 'State'
		 	      	 ),
		 	      'attributes' =>  array(
				        'id' => 'usernames',                
				        'options' => array(
				            '0' => 'Inactive',
				            '1' => 'Active',
				        ),
				    ),
		 	    ));

		 $this->add(array(
		 	      'name' => 'submit' ,
		 	      'type' => 'Zend\Form\Element\Submit',
		 	      'attributes' =>  array(
				        'id' => 'submit',
				        'value' => 'Sign in '
				    ),
		 	     )); 	

	   $this->getEventManager()->trigger('init', $this);	 	         		
	}


	 /**
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }
 
    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
    	if(!$this->eventManager){
    		$this->setEventManager(new EventManager(__CLASS__)); 
    	}
        return $this->eventManager;
    }
}

