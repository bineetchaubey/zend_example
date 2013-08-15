<?php
return array(
    'navigation' => array(
        'default' =>  array(
            array(
                'label'      => 'Blog',
                'route'      => 'blog',
                'class'      => 'dropdown-toggle',
                 'pages' => array(
                     array(
                         'label' => 'World',
                         'action' => 'world',
                         'controller' => 'hello',
                         'route' => 'blog'
                     ),
                     array(
                         'label' => 'Get Post',
                         'action' => 'getpost',
                         'controller' => 'hello',
                         'route' => 'blog'
                     ),
                     array(
                         'label' => 'Add Post',
                         'action' => 'add',
                         'controller' => 'hello',
                         'route' => 'blog'
                     ),
                     array(
                         'label' => 'pagination Example',
                         'action' => 'paginationdoctrine',
                         'controller' => 'hello',
                         'route' => 'blog'
                     ),
                     array(
                         'label' => 'Tableget way Example',
                         'action' => 'testtablegetway',
                         'controller' => 'hello',
                         'route' => 'blog'
                     ),

                     array(
                         'label' => 'sql class join Example',
                         'action' => 'jointest',
                         'controller' => 'hello',
                         'route' => 'blog'
                     ),
                 )
             ),
            array(
                'label'      => 'Forum',
                'route'      => 'forum',
                'class'      => 'dropdown-toggle',
                'pages'      =>  array(
                     array(                
                         'label' => 'Forum Home',
                         'action' => 'index',
                         'controller' => 'forum',
                         'route' => 'forum'      
                     ),
                     array(                
                         'label' => 'Get User ',
                         'action' => 'getuser',
                         'controller' => 'forum',
                         'route' => 'forum'      
                     ),
                     array(                
                         'label' => 'Get User With Post',
                         'action' => 'getuserwithpost',
                         'controller' => 'forum',
                         'route' => 'forum'      
                     ),
                     array(                
                         'label' => 'Get all Post',
                         'action' => 'getallpost',
                         'controller' => 'forum',
                         'route' => 'forum'      
                     ),
                     array(                
                         'label' => 'Get user with group',
                         'action' => 'getuserwithgroup',
                         'controller' => 'forum',
                         'route' => 'forum'      
                     ),      
                )
            ),
            array(
                'label'      => 'User',
                'route'      => 'incuser',
                'class'      => 'dropdown-toggle',
                'pages'      =>  array(
                     array(                
                         'label' => 'User home',
                         'action' => 'index',
                         'controller' => 'hello',
                         'route' => 'incuser'      
                     ),
                     array(                
                         'label' => 'Login',
                         'action' => 'login',
                         'controller' => 'hello',
                         'route' => 'incuser'      
                     ),
                     array(                
                         'label' => 'Logout',
                         'action' => 'logout',
                         'controller' => 'hello',
                         'route' => 'incuser'     
                     ),
                     array(                
                         'label' => 'add group',
                         'action' => 'addgroup',
                         'controller' => 'hello',
                         'route' => 'incuser'  
                     ),
                     array(                
                         'label' => 'get all post',
                         'action' => 'getallpost',
                         'controller' => 'hello',
                         'route' => 'incuser'  
                     ),
                      array(                
                         'label' => 'Get setting',
                         'action' => 'getcustomcetting',
                         'controller' => 'hello',
                         'route' => 'incuser'  
                     ),
                )
            ),
         ),
        )
    );
