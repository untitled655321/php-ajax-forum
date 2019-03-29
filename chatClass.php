<?php

  class chatClass
  {
    public static function getRestChatLines($id)
    {
      $arr = array();
      $jsonData = '{"results":[';
      $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
      $db_connection->query( "SET NAMES 'UTF8'" );
      $statement = $db_connection->prepare( "SELECT shoutbox.id, shoutbox.by_steam_id, shoutbox.content, shoutbox.created, users.steam_id, users.person_name, users.avatar FROM shoutbox LEFT JOIN
      users
      ON
      shoutbox.by_steam_id = users.steam_id WHERE shoutbox.id > ? and shoutbox.created >= DATE_SUB(NOW(), INTERVAL 1 HOUR)");
      $statement->bind_param( 'i', $id);
      $statement->execute();
      $statement->bind_result( $id, $by_steam_id, $content, $created, $steam_id, $name, $avatar);
      $line = new stdClass;
      while ($statement->fetch()) {
        $line->id = $id;
        $line->by_steam_id = $by_steam_id;
        $line->content = $content;
        $line->created = date('H:i:s', strtotime($created));
        $line->steam_id = $steam_id;
        $line->name = $name;
        $line->avatar = $avatar;
        $arr[] = json_encode($line);
      }
      $statement->close();
      $db_connection->close();
      $jsonData .= implode(",", $arr);
      $jsonData .= ']}';
      return $jsonData;
    }
    public static function refreschContentWatcher($id)
    {
      $arr = array();
      $jsonData = '{"results":[';
      $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
      $db_connection->query( "SET NAMES 'UTF8'" );
      $statement = $db_connection->prepare( "SELECT posts.post_id, posts.post_by, posts.post_content, posts.post_date,posts.post_topic,
         users.steam_id, users.person_name, users.avatar
        FROM
        posts
        LEFT JOIN
      users
      ON
      posts.post_by = users.steam_id
      WHERE posts.post_id > ? and posts.post_date >= DATE_SUB(NOW(), INTERVAL 24 HOUR) ");
      $statement->bind_param( 'i', $id);
      $statement->execute();
      $statement->bind_result( $id, $by_steam_id, $content, $created,$topic, $steam_id, $name, $avatar);
      $line = new stdClass;
      while ($statement->fetch()) {
        $line->id = $id;
        $line->by_steam_id = $by_steam_id;
        $line->content = $content;
        $line->created = date('H:i:s', strtotime($created));
          $line->topic = $topic;
        $line->steam_id = $steam_id;
        $line->name = $name;
        $line->avatar = $avatar;
        $arr[] = json_encode($line);
      }
      $statement->close();
      $db_connection->close();
      $jsonData .= implode(",", $arr);
      $jsonData .= ']}';
      return $jsonData;
    }

    public static function setChatLines( $content, $by_steam_id) {
      $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
      $db_connection->query( "SET NAMES 'UTF8'" );
      $statement = $db_connection->prepare( "INSERT INTO shoutbox(by_steam_id,content) VALUES(?,?)");
      $statement->bind_param( 'ss', $by_steam_id, $content);
      $statement->execute();
      $statement->close();
      $db_connection->close();
    }
    public static function searchUser($search_user){
       $arr = array();
       $jsonData = '{"results":[';
       $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
       $db_connection->query( "SET NAMES 'UTF8'" );
       $statement = $db_connection->prepare( "SELECT user_id, steam_id, person_name, avatar FROM users WHERE person_name LIKE '%$search_user%' ");
       //$statement->bind_param( 's', $search_user);
       $statement->execute();
       $statement->bind_result( $user_id,$steam_id, $person_name, $avatar);
       $line = new stdClass;
       while ($statement->fetch()) {
         $line->user_id = $user_id;
         $line->steam_id = $steam_id;
         $line->person_name = $person_name;
         $line->avatar = $avatar;
         $arr[] = json_encode($line);
       }
       $statement->close();
       $db_connection->close();
       $jsonData .= implode(",", $arr);
       $jsonData .= ']}';
       return $jsonData;

     }
     public static function searchComments($search_comments,$user_level,$user_identificator)
      {

        $arr = array();
        $jsonData = '{"results":[';
        $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
        $db_connection->query( "SET NAMES 'UTF8'" );

        $statement = $db_connection->prepare( "SELECT
              comments.comment_id,
              comments.comment_content,
              comments.comment_date,
              comments.comment_post,
              comments.comment_by,
              users.user_id,
              users.steam_id,
              users.person_name,
              users.avatar
                FROM
                comments
                  LEFT JOIN
                  users
                  ON
                  comments.comment_by = users.steam_id
                WHERE
                    comments.comment_post = ? ");
              $statement->bind_param( 'i', $search_comments);
              $statement->execute();
              $statement->bind_result( $comment_id,$comment_content,$comment_date,$comment_post,$comment_by,$user_id,$steam_id, $person_name, $avatar);
              $line = new stdClass;
              while ($statement->fetch()) {
                $line->comment_id = $comment_id;
                $line->comment_content = $comment_content;
                $line->comment_date = date('H:i:s', strtotime($comment_date));
                $line->comment_post = $comment_post;
                $line->comment_by = $comment_by;
                $line->user_id = $user_id;
                $line->steam_id = $steam_id;
                $line->person_name = $person_name;
                $line->avatar = $avatar;
                if($user_id==$user_identificator){
                  $line->delete_comment = 1;
                }
                else{
                  $line->delete_comment = 0;

                }
                $line->user_level = $user_level;
                $arr[] = json_encode($line);
              }

              $statement->close();
              $db_connection->close();
              $jsonData .= implode(",", $arr);
              $jsonData .= ']}';
              return $jsonData;

      }
      public static function addComment( $content, $post_id, $by_steam_id) {
        $db_connection = new mysqli( mysqlServer, mysqlUser, mysqlPass, mysqlDB);
        $db_connection->query( "SET NAMES 'UTF8'" );
        $statement = $db_connection->prepare( "INSERT INTO comments(comment_content,comment_post,comment_by) VALUES(?,?,?)");
        $statement->bind_param( 'sss', $content,$post_id,$by_steam_id);
        $statement->execute();
        $statement->close();
        $db_connection->close();
      }
  }
?>
