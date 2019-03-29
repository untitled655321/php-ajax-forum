<?php
  session_start();
  require_once( "partials/config.php" );
  require_once( "chatClass.php" );
  $chattext = htmlspecialchars( $_GET['chattext'] );
  $post_id = htmlspecialchars( $_GET['post_id']);
  chatClass::addComment( $chattext, $post_id, $_SESSION['steamid']);
?>
