<?php

namespace MigratePosts;

class SettingsPage{

    public function enable(){
        add_action( 'admin_menu', array($this, 'addMenuPage' ));
        add_action("admin_enqueue_scripts", [$this, "enqueueAdminScript"]);
    }
    
    public function enqueueAdminScript(){
        wp_register_script(
            'migrate-posts-settings-page',
            plugin_dir_url(__FILE__) . 'settings-page.js', // here is the JS file
            ['jquery', 'wp-api'],
            '1.0',
            true
        );
        wp_enqueue_script('migrate-posts-settings-page');
    }

    public function addMenuPage() {
        $user = wp_get_current_user();
        if ( (in_array( 'administrator', (array) $user->roles ) ) ) {
            add_menu_page( "migrate-posts", "Migrate Posts", "edit_posts","migrate-posts", array($this, "renderMigratePostsAdminSettingsPage"));
            //die("27");
        }
    }

    public function renderMigratePostsAdminSettingsPage(){
    $RemoteSiteAuth = new RemoteSiteAuth;
    $data = [];
    if(get_option("migrate-posts-remote-sites")){
            $data = get_option('migrate-posts-remote-sites');
    }
    
    $remoteSitePasswords = $RemoteSiteAuth->returnRemoteSitePasswordsArrayHtml($data);
    
    $output = <<<OUTPUT
<div id = "wpbody" role = "main">
   <div id = "wpbody-content">
      <div class = "wrap">
         <h1>
            Migrate Posts Between Domains<br />
         </h1>
         <div class="body">
            <form method="post">
                <p class="form-group"><label>Post ID</label>
                <input name="postID" type="text" value=""></p>
                
                <p class="form-group"><label>Receiving Url</label>
                <input name="xxx" type="text" value=""></p> < -- not working 
                
                
                <input type ="submit" /> < - - these are really seperate things  --V
                <hr />
                
                 <p class="form-group"><label>Website Url</label>
                <input name="URL" type="text" value=""></p>
                
                 <p class="form-group"><label>Application Password</label>
                <input name="remoteSitePassword" type="text" value=""></p>
                
                 <p class="form-group">
                <input type="submit" name="Submit" value="SEND"></p>
                
            $remoteSitePasswords
            
            </form>
            
            <br />
         
         </div>
      </div>
      <!-- END: #wrap -->
   </div>
   <!-- END: #wpbody-content -->
</div>
<!-- END: #wpbody -->
OUTPUT;
        echo $output;
        
    }

  

 

}