<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

   /**
    * Define custom actions here
    */

   public function __construct()
   {
       //parent::__construct($scenario);

       //require_once('/var/www/html/wphttps/wp-content/plugins/developer-contest/src/DeveloperContest/autoloader.php');

       require_once('/var/www/html/wp-content/plugins/migrate-posts/src/MigratePosts/autoloader.php');

   }
}
