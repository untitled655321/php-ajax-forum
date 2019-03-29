    <?php


      require_once( "partials/config.php" );
      require_once( "chatClass.php" );
      $search_user = htmlspecialchars( $_GET['searchuser'] );
      $jsonData = chatClass::searchUser($search_user);
      print $jsonData;

    ?>
