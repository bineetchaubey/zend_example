<?php
/**
* @author Bineet Kumar Chaubey
* @package Zend\Acl
*/
##### This is use for Acl Module ###################
#
# Acl module role Resource, permission define here
# Structure of array userAcl
#
#  array( 
#        
#       'userType ie Role' => array(
#                      'Module-name' => array(
#                            'Controller-name:Actionname',
#                      	)
#                     
#        	    )
#      )
#
#######################################################

return array( 
	  'this_test' => array(
	        'anonymous' => array(

       	            'blog' => array(
       	            	    'hello:index',
                          'hello:world',
                          'hello:ajaxdata',
                          'hello:createregister',
                          'forum:index',
                          'forum:gettestplugin',
       	            ),
       	            'incuser' => array(
                          'hello:index',
                          'hello:login',
                          'hello:login2',
                          'hello:logout',
                          'hello:register',
       	            )
           	 ),
            'user' => array( 
       	            'blog' => array(
       	            	   'hello:getpost',
       	            	   'hello:world',
       	            	   'forum:getuser',
                         'hello:getpost',
                         'forum:getallpost',
                         'forum:getuserwithpost',       
       	            ),
       	            'incuser' => array(
                          'hello:getallpost',
                          'hello:checklogin',
       	            ),
           	),         
            'admin' => array(        	            
       	            'blog' => array(
	   	            	   'hello:add',
	                     'forum:insertuserwithgroup',
	                     'forum:gettestplugin',
                       'forum:getuserwithgroup',

       	            ),
       	            'incuser' => array(
                        	'hello:addgroup',
                          'hello:getcustomcetting',
       	            ),
           	 ),
        )
	);