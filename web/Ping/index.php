<?php
  
  require_once dirname(__FILE__)."/../../config.inc";
  require_once "db/Dal/Dal.php";
  require_once "ext/PingServer/PingServer.php";

  $PingServer = new PingServer();
  $PingServer->generate_xml();
  // Current the argument is hardcoded to get the user updates only. Will be changed later on.
  $filename = $PingServer->return_xml (1);
  header('Location:'.$filename);
  exit;
?>