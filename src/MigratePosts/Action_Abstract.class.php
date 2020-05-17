<?php

namespace MigratePosts;

abstract class Action_Abstract{

    public $namespace;
    public $actionName;
    public $capability;

    abstract public function doAction($args);
    abstract public function getActionButtonUiHtml($args);

    public function doRegisterRoutes(){
        register_rest_route(
            $this->namespace,
            $this->actionName,
            array(
                'methods'               => array('POST'),
                'callback'              => function(){
                    return ($this->doAction($_POST));
                },
                'permission_callback'   => function(){
                    $cap = $this->capability; 
                    if(!(current_user_can( $cap))){
                        return FALSE;
                    }
                    return TRUE;
                },
            )
        );
    }
}