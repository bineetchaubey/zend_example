<?php
namespace Blog\plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\EventManager\EventManager;
use Zend\EventManager\Event;

/**
* Controller plugin  
* @author Bineet kumar chaubey
*/

class MyFirstPlugin extends AbstractPlugin
{
	
	var $name ;

	public $events;
 
    
	
	function __construct()
	{
		$this->name = "this is first controller plugin";
	}


    public function events() 
    {
        if (!$this->events) {
            $this->events = new EventManager(__CLASS__); 
        }
        return $this->events;
    }


	public function getname(){

		return $this->name;
	}

   
    public function getuseradetal(){
      
       /**
       * This is example for Eventmanager
       * and this will implement in blog/ForumCOntroller gettestplugin action
       */

       $result = $this->events()->trigger('WordpressLikehook', $this,
            array('username' => "This My Test Plugin User"));
        
        $data = array('a' => $result ,'b' => 'here we are going to change specific requirement');
       
       return $data ;

    }



}
