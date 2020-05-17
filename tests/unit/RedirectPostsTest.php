<?php

class RedirectPostsTest extends \Codeception\TestCase\WPTestCase{
    
    /**
     * @test
     * it should be instantiatable
     */
    public function it_should_be_instantiatable(){
        $RedirectPosts = new \MigratePosts\RedirectPosts;
    }
    
    /**
     * @test
     * it should retun bool if post should be redirected
     */
    public function bool_isThisPostSupposedToBeRedirectedTest(){
        /**
         * Given there is a post that should NOT be redirected
         * And there is a boolean static method function to
         *  test if the post should be redirected or not
         */
        $my_post = array(
            'post_title' => 'My post',
            'post_content' => 'This is my post.',
            'post_status' => 'publish',
            'post_author' => 1
        );
        $postID = wp_insert_post( $my_post );
        
        /**
         * When the bool is tried
         */
        $result = \MigratePosts\RedirectPosts::bool_isThisPostSupposedToBeRedirected($postID);
        
        /**
         * Then it should return "false"
         */
        $this->assertFalse($result);
        
        /**
         * Given there is a post that SHOULD be redirected
         */
        $my_post = array(
            'post_title' => 'My post',
            'post_content' => 'This post has moved.',
            'post_status' => 'publish',
            'post_author' => 1
        );
        $postID = wp_insert_post( $my_post );
        
        /**
         * When the bool is tried
         */
        $result = \MigratePosts\RedirectPosts::bool_isThisPostSupposedToBeRedirected($postID);
        
        /**
         * Then it should return "true"
         */
        $this->assertTrue($result);
    }

}