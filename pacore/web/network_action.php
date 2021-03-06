<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<?php
$login_required = FALSE;
include_once("web/includes/page.php");
//require_once "web/includes/functions/auto_email_notify.php";
require_once "api/Messaging/MessageDispatcher.class.php";
require_once "api/Roles/Roles.php";

if ( $_GET['action'] == 'join' ) {
  $nid = (int) $_GET['nid'];
  // here we check that user is already join or not 
  if ($_SESSION['user']['id'] && Network::member_exists($nid, $_SESSION['user']['id'])) {
     $redirect_url = "http://".PA::$network_info->address.".".PA::$domain_suffix.BASE_URL_REL.PA_ROUTE_HOME_PAGE."/msg=7021";
     header("Location:$redirect_url");
     exit;
  }
  $error = 0;
  if(!$nid) {
    $error = 1;
  }
  if ( $_SESSION['user']['id'] ) {
    try {
        $suc = Network::join( $nid, $_SESSION['user']['id'] );
        if( $suc ) {
          // adding default relation
            if ( $_SESSION['user']['id'] != SUPER_USER_ID ) {
              uihelper_add_default_relation($_SESSION['user']['id']);
            }
          // adding default media as well as album
          uihelper_add_default_media($_SESSION['user']['id']);
          uihelper_add_default_media($_SESSION['user']['id'], '_audio');
          uihelper_add_default_media($_SESSION['user']['id'], '_video');
          uihelper_add_default_blog($_SESSION['user']['id']);
        }
      } catch (PAException $e) {
        $msg = "$e->message";
      }
      $network = new Network;
      $network->set_params(array('network_id'=>$nid));
      $netinfo = $network->get();        
      $netinfo = $netinfo[0];
      
      $requester = new User();
      $requester->load((int)$_SESSION['user']['id']);
      $recipient = type_cast($netinfo, 'Network');           // defined in helper_functions.php
      PANotify::send("network_join", $recipient, $requester, array());

      $redirect_url = "http://".$netinfo->address.".".PA::$domain_suffix.BASE_URL_REL.PA_ROUTE_HOME_PAGE."/msg=7001";
      header("Location:$redirect_url");
      exit;
        // $msg = "You have successfully joined the '".stripslashes($netinfo->name)."' network. Click <a href='http://".$netinfo->address.".".PA::$domain_suffix.BASE_URL_REL."/homepage.php'>here</a> to go to network.";
        
       } else {
         //$msg = "Please login first to join the network.";
         header("Location: ". PA::$url ."/login.php?error=1&return=".urlencode($_SERVER['REQUEST_URI']));
       }
} else if( $_GET['action'] == 'leave' ) {
   try {
     if ( $_SESSION['user']['id'] ) {
       $suc = Network::leave((int)PA::$network_info->network_id, (int)$_SESSION['user']['id']);
       if( $suc ) {
         $_SESSION['user']['action'] = 'leave network';
         $redirect_url = "http://".PA::$network_info->address.".".PA::$domain_suffix.BASE_URL_REL.PA_ROUTE_HOME_PAGE."/msg=7008";
         header("Location:$redirect_url");
         exit;
       }
     }  
   } catch(PAException $e) {
     $msg .= $e->message;
   echo "UNSUCCESS: $msg";
   }
}

?>
