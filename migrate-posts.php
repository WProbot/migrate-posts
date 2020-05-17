<?php
/**
 * Plugin Name:       Migrate Posts
 * Plugin URI:
 * Description:       
 * Version:           1
 * Author:            John Dee
 * Author URI:        https://generalchicken.guru/
 * License:           Copyright (C) Jim Karlinski 2020
 */

namespace MigratePosts;

//die("MigratePosts plugin");

require_once (plugin_dir_path(__FILE__). 'src/MigratePosts/autoloader.php');


$SettingsPage = new SettingsPage;
$SettingsPage->enable();

$RemoteSiteAuth = new RemoteSiteAuth;
add_action("init", [$RemoteSiteAuth ,"listenForFormSubmission"]);
add_action("init", [$RemoteSiteAuth ,"showOutputData"]);


add_action ('rest_api_init', [new Action_RemoveItemFromRemotePasswordsComponent, 'doRegisterRoutes']);



if (isset($_GET['testSend'])){
    //die('tesSend!');
    $PostSender = new PostSender;
    $PostSender->sendPostToRemoteUrl(123, "http://ec2-18-217-207-213.us-east-2.compute.amazonaws.com/wp-json/wp/v2/posts/", "admin", "C3geoGdtTYcbMHTMPy3YMQh6");
}

// add_action("init", function(){delete_option('migrate-posts-remote-sites');});
// cd /var/www/html/wp-content/plugins/migrate-posts
// bin/codecept run unit -v ---html
// http://ec2-18-217-207-213.us-east-2.compute.amazonaws.com/wp-content/plugins/migrate-posts/tests/_output/report.html