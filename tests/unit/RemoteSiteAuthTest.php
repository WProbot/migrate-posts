<?php

class RemoteSiteAuthTest extends \Codeception\TestCase\WPTestCase{
    
    /**
     * @test
     * it should be instantiatable
     */
    public function it_should_be_instantiatable(){
        $RemoteSiteAuth = new \MigratePosts\RemoteSiteAuth;
    
    }
    
    /**
     * @test
     * it should do form submission
     */
    public function itShouldDoFormSubmission(){
        $RemoteSiteAuth = new \MigratePosts\RemoteSiteAuth;
        $RemoteSiteAuth->doFormSubmission("123", "http://abc.com", "xyz123");
        
        $inDB = get_option("migrate-posts-remote-sites");
        $expectedResult = [ ["http://abc.com" => "xyz123"] ];

        ob_start();
        $stringOfInDB = var_dump($inDB);
        $result = ob_get_clean();

        ob_start();
        $stringOfExpected = var_dump($expectedResult);
        $result = ob_get_clean();


        $this->assertEquals($stringOfExpected, $stringOfInDB);
        
        $RemoteSiteAuth->doFormSubmission("567", "http://xxx.com", "AAAAA");
        
        $inDB = get_option("migrate-posts-remote-sites");
        $expectedResult = [
            ["http://abc.com" => "xyz123"],
            ["http://xxx.com", "AAAAA"]
        ];

        ob_start();
        $stringOfInDB = var_dump($inDB);
        $result = ob_get_clean();

        ob_start();
        $stringOfExpected = var_dump($expectedResult);
        $result = ob_get_clean();
        
        $this->assertEquals($stringOfExpected, $stringOfInDB);
        
    }

    /**
     * @test
     * it should return the html when there is one item
     */
    public function itShouldReturnTheHtml(){        
        $sitesArray = array(
                ["https://abc.com" => "passwordABC"],
            );
        
        $returnedHTML = \MigratePosts\RemoteSiteAuth::returnRemoteSitePasswordsArrayHtml($sitesArray);

        $expectedResult = <<<EXPECTED
<table><thead><th>SiteUrl</th><th>Password</th></thead><tbody><tr><td>https://abc.com</td><td>passwordABC</td></tr></tbody></table>
EXPECTED;
        $this->assertEquals($expectedResult, $returnedHTML);
    }
    
    /**
     * @test
     * it should return the html when there is more than one item
     */
    public function itShouldReturnTheHtmlWhenThereIsMoreThanOneItem(){        
        $sitesArray = array(
                ["https://abc.com" => "passwordABC"],
            );
        
        $returnedHTML = \MigratePosts\RemoteSiteAuth::returnRemoteSitePasswordsArrayHtml($sitesArray);

        $expectedResult = <<<EXPECTED
<table><thead><th>SiteUrl</th><th>Password</th></thead><tbody><tr><td>https://abc.com</td><td>passwordABC</td></tr></tbody></table>
EXPECTED;
        $this->assertEquals($expectedResult, $returnedHTML);
    }    

    /**
     * @test
     * it should return the html when there are no items
     */
    public function itShouldReturnTheHtmlWhenThereAreNoItems(){        
        $returnedHTML = \MigratePosts\RemoteSiteAuth::returnRemoteSitePasswordsArrayHtml([]);

        $expectedResult = <<<EXPECTED
<table><thead><th>SiteUrl</th><th>Password</th></thead>
<tr><td>No remote sites enabled.</td></tr>
</table>
EXPECTED;
        $this->assertEquals($expectedResult, $returnedHTML);
    }
    
    /**
     * @test
     * it should register a new entry
     */
    public function itShouldRegisterANewEntry(){
        /**
         * GIVEN the option starts out empty
         */       
        delete_option("migrate-posts-remote-sites");
        
        
        /**
         * WHEN a data item is added to the database
         */
        \MigratePosts\RemoteSiteAuth::setSitePassword("https://abc.com", "passwordABC");
        
        /**
         * THEN the data should be in an array within an array
         */
        $result = get_option("migrate-posts-remote-sites");
        $expectedResult = array(
            ["https://abc.com" => "passwordABC"],
        );
        
        $this->assertEquals($expectedResult, $result);
    }
    
    /**
     * @test
     * it should overwrite an entry if duplicate Urls
     */
    public function itShouldOverwriteAnEntryIfDuplicateUrls(){
        /**
         * GIVEN the option starts out empty
         */       
        delete_option("migrate-posts-remote-sites");
        
        
        /**
         * WHEN a data item is added to the database twice
         */
        \MigratePosts\RemoteSiteAuth::setSitePassword("https://abc.com", "passwordABC");
        \MigratePosts\RemoteSiteAuth::setSitePassword("https://abc.com", "NEWPASSWORD");
        
        /**
         * THEN the data should be in an array within an array
         */
        $result = get_option("migrate-posts-remote-sites");
        $expectedResult = array(
            ["https://abc.com" => "NEWPASSWORD"],
        );
        
        $this->assertEquals($expectedResult, $result);
        
    }
    
    /**
     * @test
     * it should remove an entry when user deletes entry
     */
    public function itShouldRemoveAnEntry(){
        /**
         * GIVEN the option starts out empty
         */       
        delete_option("migrate-posts-remote-sites");
        
        
        /**
         * WHEN a data item is added to the database then removed
         */
        \MigratePosts\RemoteSiteAuth::setSitePassword("https://xxx.com", "passwordABC");
        \MigratePosts\RemoteSiteAuth::setSitePassword("https://abc.com", "passwordABC");
        \MigratePosts\RemoteSiteAuth::removeSite("https://abc.com");
        
        /**
         * THEN the data should be removed
         */
        $result = get_option("migrate-posts-remote-sites");
        $expectedResult = array(
            ["https://xxx.com" => "passwordABC"],
        );
        
        $this->assertEquals($expectedResult, $result);
    }
    
    /**
     * @test
     * it should remove the entire option if nothing is in it
     */
    public function itShouldRemoveTheEntireOption(){
        /**
         * GIVEN the option starts out empty
         */       
        delete_option("migrate-posts-remote-sites");
        
        
        /**
         * WHEN a data item is added to the database then removed
         */
        \MigratePosts\RemoteSiteAuth::setSitePassword("https://xxx.com", "passwordABC");
        \MigratePosts\RemoteSiteAuth::setSitePassword("https://abc.com", "passwordABC");
        \MigratePosts\RemoteSiteAuth::removeSite("https://abc.com");
        \MigratePosts\RemoteSiteAuth::removeSite("https://xxx.com");
        
        /**
         * THEN the data should be removed
         */
    
        //The option shouldn't even exists
        $this->assertFalse( get_option("migrate-posts-remote-sites") );
    }
    
}