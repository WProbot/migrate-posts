<?php

namespace MigratePosts;

class RemoteSiteAuth{
    
    public function __construct(){
        //die("REmoteSiteAuth!");
    }
    
    public function getSitePassword($siteUrl){
        return $password;
    }
    
    public function setSitePassword($Url, $password){
        $tempArray = [$Url => $password];
        $dataArray = array();
        if(get_option("migrate-posts-remote-sites")){
            $dataArray = get_option('migrate-posts-remote-sites');
            $check = 0;
            foreach($dataArray as $key => $value)
            {
                $keys = array_keys($value);
                if($keys[0] ==  $Url)
                {
                    $dataArray[$key][$Url] = $password;
                    $check = 1; 
                    
                }
               
            }
            if($check == 0)
            {
                array_push($dataArray, $tempArray);
            }
            
            update_option('migrate-posts-remote-sites', $dataArray);
        }else{
            array_push($dataArray, $tempArray);
            update_option('migrate-posts-remote-sites', $dataArray);
        }
    }
    
    public function removeSite($siteUrl){
        //if empty remove the option in the DB
        $dataArray = array();
        if(get_option("migrate-posts-remote-sites")){
            $dataArray = get_option('migrate-posts-remote-sites');
            foreach($dataArray as $key => $value)
            {
                $keys = array_keys($value);
                if($keys[0] ==  $siteUrl)
                {
                    unset($dataArray[$key]);
                    
                }
               
            }
            
            if(!empty($dataArray))
            {
                update_option('migrate-posts-remote-sites', $dataArray);
            }
            else
            {
                delete_option('migrate-posts-remote-sites');
            }
            
        }
    }
    
    public function showOutputData(){
        if(isset($_GET['outputMigrateData'])){
            $this->outputData();
        }
    }
    
    public function listenForFormSubmission(){
        if(isset($_POST['Submit'])){
            $postID = $_POST['postID'];
            $Url = $_POST['URL'];
            $remoteSitePassword = $_POST['remoteSitePassword'];
            $this->setSitePassword($Url, $remoteSitePassword);
        }
    }
        
    public function outputData(){
        if(isset($_GET['outputMigrateData'])){
       $output =  get_option('migrate-posts-remote-sites');
       var_dump($output);
       die();
        }
    }
    
    public static function returnRemoteSitePasswordsArrayHtml($sitesArray){
        
        //This function takes an empty array, but it must be an array
        //of sites and passwords pairs
        if(!(is_array($sitesArray))){
            throw new \Exception('ERROR: returnRemoteSitePasswordsArrayHtml: An array should be given here.');
        }
        
    if(empty($sitesArray)){
            $html = <<<EXPECTED
<table><thead><th>SiteUrl</th><th>Password</th></thead>
<tr><td>No remote sites enabled.</td></tr>
</table>
EXPECTED;
        return $html;
        }
        //delete_option('migrate-posts-remote-sites');die();
        //this should retrun an HTML table that displays the site urls and passwords
        $html = "<table><thead><th>SiteUrl</th><th>Password</th></thead><tbody>";
        foreach($sitesArray as $site){
            $keys = array_keys($site);
            //var_dump($keys);die();
            ////var_dump($site);die();
            //var_dump($keys[1]);die();
            $Xbutton = new Action_RemoveItemFromRemotePasswordsComponent;
            $XbuttonHtml = $Xbutton->getActionButtonUiHtml($keys[0]);
            $html .= "<tr><td>$XbuttonHtml". $keys[0] . "</td><td>" . $site[$keys[0]] . "</td></tr>"; 
          
        }
       
        
        $html .= "</tbody></table>";
        return $html;
    }
}
//exasmple site option "migrate-posts-remote-sites"
//array = ["https://generalchicken.gure" => "asdfasdf", "http://abc.com" => "asdfasdf"];