<?php

namespace MigratePosts;

class RedirectPosts{
    
    public function enable(){
        add_action($this, "isPostRedirected");
    }
    
    public function isPostRedirected(){
        if(is_singular()){
            if($this->bool_isThisPostSupposedToBeRedirected(get_the_ID())){
                $this->doRedirctPost();
            }
        }
    }
    
    public static function bool_isThisPostSupposedToBeRedirected($postID){
        $post_content = get_post($postID);
        $content = $post_content->post_content;
        if($content == "This post has moved."){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function doRedirctPost(){}
    
}