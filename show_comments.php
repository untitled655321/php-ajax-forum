<?php
  session_start();

  require_once( "partials/config.php" );
  require_once( "chatClass.php" );

  $user_level = intval($_SESSION['user_level']);
  $user_identificator = intval($_SESSION['user_id']);
  $search_comments = intval($_GET['topic_id']);
  $jsonData = chatClass::searchComments($search_comments,$user_level,$user_identificator);
  print $jsonData;

?>
