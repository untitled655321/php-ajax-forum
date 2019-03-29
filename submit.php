<?php
  session_start();
  require_once( "partials/config.php" );
  require_once( "chatClass.php" );
  $chattext = htmlspecialchars( $_GET['chattext'] );
  chatClass::setChatLines( $chattext, $_SESSION['steamid']);
?>
