<?php
 namespace Admin\ForM;

 use Zend\Form\Form;

/**
* user form to generate a form for add and update  post
*@author Bineet kumar chaubey
*/
class CmsForm extends Form
{
	
	public function __construct($name = Null)
	{
		parent::__construct('cms');
        $this->setAttribute('method','post');
        
        $this->add(array(
              'name' => 'title',
              'type' => 'Zend\Form\Element\Text',
              'options' =>array(
              		'label' => _('Title'),
              	)
        	));
        $this->add(array(
              'name' => 'seo_page_title',
              'type' => 'Zend\Form\Element\Text',
              'options' =>array(
                    'label' => _('Seo Page Title'),
                )
            ));
        $this->add(array(
              'name' => 'slug',
              'type' => 'Zend\Form\Element\Text',
              'options' =>array(
                    'label' => _('slug'),
                )
            ));

        $this->add(array(
              'name' => 'meta_keywords',
              'type' => 'Zend\Form\Element\Text',
              'options' =>array(
                    'label' => _('Meta keywords'),
                )
            ));

        $this->add(array(
              'name' => 'meta_description',
              'type' => 'Zend\Form\Element\Text',
              'options' =>array(
                    'label' => _('Meta Description'),
                )
            ));


        $this->add(array(
 				'name' => 'body',
 				'type' => 'Zend\Form\Element\Textarea',
 				'options' => array(
 						'label' => _('Page Content')
 					)
        	));
        $this->add(array(
        		'name' => 'lang',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => _('lang'),
                        'disable_inarray_validator' => true,
        			),
        		'attributes' =>  array(
				        'id' => 'cmslang',
				        'data-rel' => 'chosen',                
				        'options' => array(
				           'en' => 'English',
                           'fr' => 'French',
				        ),
				    ),
        	));
         $this->add(array(
        		'name' => 'status',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => _('Status'),
                        'disable_inarray_validator' => true,
        			),
        		'attributes' =>  array(
				        'id' => 'cmsStatus',
				        'data-rel' => 'chosen',                
				        'options' => array(
				            '0' => 'Inactive',
				            '1' => 'Active',
				        ),
				    ),
        	));

        $this->add(array(
        		'name' => 'submit2',
        		'type' => 'Zend\Form\Element\Submit',
        		'options' => array(
        				'label' => _(''),
        			),
        		'attributes' => array(
        				'value' => _('Create page'),
        				'id' => 'SubmitButton',
        				'class' => 'btn btn-primary',
        			)
        	));
	}
}
