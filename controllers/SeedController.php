<?php
/**
 * Main controller for all seed imports
 *
 * @author jovani
 */

class SeedController extends Controller
{
  /**
   * Imports into ubs_inventory from a seed sheet
   */
  public function actionUbsItems()
  {
    set_time_limit(0);
    exec('php protected/yiic.php importUbsSeed > /dev/null 2>/dev/null &');

//    $this->redirect(array('seed/showUbsLog'));
    print 'monitor logs here: <a href="' .$this->createUrl('seed/showUbsLog') .'" >'.$this->createUrl('seed/showUbsLog').'</a>';
//    $this->render('ubs-log');
  }

  public function actionShowUbsLog()
  {
    $this->render('ubs-log');
  }
}