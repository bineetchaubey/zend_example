<?php
namespace Blog\Form;

use Zend\Form\Form; 

/**
*  class for Generate group Form
*/
class GroupForm extends Form
{
	
	public function __construct($name = Null)
	{
		parent::__construct('group');
		$this->setAttribute('method','post');
		$this->add(array(
				'name' => 'name',
				'type' => 'Zend\Form\Element\Text',
				'options' => array(
					'label' => "Group Name", 
					)
				));

		$this->add(array(
			    'name' => 'display_name',
			    'type' => 'Zend\Form\Element\Text',
			    'options' => array(
			    	  'label' => 'Display Name',
			    	)
			));
		$this->add(array(
			    'name' => 'Submit',
			    'type' => 'Zend\Form\Element\Submit',
			    'attributes' => array(
			    		'value' =>  'Create Group',
			    		'id'    => 'groupsubmitbtn'
			    	)
			));
	}
}
