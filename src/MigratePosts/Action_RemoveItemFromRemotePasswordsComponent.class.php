<?php

namespace MigratePosts;

class Action_RemoveItemFromRemotePasswordsComponent extends Action_Abstract{
    
    public $namespace = "migrate-posts/v1";
    public $actionName = "remove-item-from-remote-passwords-component";
    public $capability = 'activate_plugins';

    public function getActionButtonUiHtml($Url){
        $output = <<<OUTPUT
<a href="javascript:void(0);" onclick="MigratePosts.actionRemoveItemFromPasswordsComponent('$Url')"> [X]</a>
OUTPUT;
    return $output;
    }
    
    public function doAction($data){
        $d = $data['Url'];
        return "KAPLA! - $d from server";
    }

}