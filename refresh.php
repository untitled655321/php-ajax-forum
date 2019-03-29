<?php
  require_once( "partials/config.php" );
  require_once( "chatClass.php" );
  $id = intval( $_GET[ 'lastTimeID' ] );

  $jsonData = chatClass::getRestChatLines( $id );
  print $jsonData;
?>
