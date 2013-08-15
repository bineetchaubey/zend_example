<?php
namespace Blog\Form;

use Zend\Form\Form;

/**
* user form to generate a form for add and update  post
*@author Bineet kumar chaubey
*/
class PostForm extends Form
{
	
	public function __construct($name = Null)
	{
		parent::__construct('post');
        $this->setAttribute('method','post');
        $this->add(array(
	            'name' => 'id',
	            'type' => 'Zend\Form\Element\Hidden',
        	));

        $this->add(array(
              'name' => 'title',
              'type' => 'Zend\Form\Element\Text',
              'options' =>array(
              		'label' => 'Title',
              	)
        	));
        $this->add(array(
              'name' => 'tag',
              'type' => 'Zend\Form\Element\Text',
              'options' =>array(
                    'label' => 'tags',
                )
            ));
        $this->add(array(
 				'name' => 'body',
 				'type' => 'Zend\Form\Element\Textarea',
 				'options' => array(
 						'label' => 'Post Content'
 					)
        	));
        $this->add(array(
        		'name' => 'user_id',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => 'Author Id',
                        'disable_inarray_validator' => true,
        			)
        	));

        $this->add(array(
        		'name' => 'submit',
        		'type' => 'Zend\Form\Element\Submit',
        		'attributes' => array(
        				'Value' => 'Go',
        				'id' => 'SubmitButton'
        			)
        	));
	}
}



