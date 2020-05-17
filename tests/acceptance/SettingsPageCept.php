<?php
$I = new AcceptanceTester($scenario);
$I->wantTo("See that there is a settings page for the 'migrate-posts' plugin");
$I->loginAsAdmin();
$I->amOnPage("/wp-admin/admin.php?page=migrate-posts");
$I->see("Migrate Posts Between Domains");
$I->fillField("postID", "123");
$I->fillField("URL", "https://generalchicken.guru");
$I->fillField("remoteSitePassword", "123");
$I->click("Submit");

// cd /var/www/html/wp-content/plugins/migrate-posts
// bin/codecept run acceptance -v --html
// http://ec2-18-217-207-213.us-east-2.compute.amazonaws.com/wp-content/plugins/migrate-posts/tests/_output/report.html
// http://ec2-18-217-207-213.us-east-2.compute.amazonaws.com/wp-login.php freelancer1 Rahul123$