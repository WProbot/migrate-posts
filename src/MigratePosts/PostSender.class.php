<?php

namespace MigratePosts;

class PostSender{
    
    public function sendPostToRemoteUrl($localPostID, $remoteSiteUrl, $remoteSiteUsername, $remoteSitePassword){
        $response = wp_remote_post(
            $remoteSiteUrl, 
            array(
                'body'    => ['title' => 'this is a title!'],
                'headers' => ['Authorization' => 'Basic ' . base64_encode( $remoteSiteUsername . ':' . $remoteSitePassword )],
            )
        );
        var_dump($response);
        die();
    }
    
    public function xxx(){
        return "xxx";
    }
}
///*
//curl --user "admin:C3geoGdtTYcbMHTMPy3YMQh6" -X POST -d "title=This is a new test post" http://ec2-18-217-207-213.us-east-2.compute.amazonaws.com/wp-json/wp/v2/posts/
//