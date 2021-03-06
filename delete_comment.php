<?php
//create_cat.php
include 'partials/header.php';
include 'partials/connect.php';


if($_SERVER['REQUEST_METHOD'] != 'GET')
{
    //someone is calling the file directly, which we don't want
    echo 'Tego pliku nie można wywołać bezpośrednio.';
}
else
{
    //check for sign in status
    $comment_id = $_GET['id'];


      //sekcja odpowiadająca za walidacje czy użytkownik jest adminem aby usunąć kategorię
      $id = $_SESSION['user_id'];
      $query = "SELECT user_level FROM users WHERE user_id = $id";
      $post_query = "SELECT comment_by FROM comments WHERE comment_id = $comment_id";
      $result = mysqli_query($link,$query);
      $post_result = mysqli_query($link,$post_query);
      if((!$result)||(!$post_result))
      {
          //something went wrong, display the error
          echo 'Błąd, podczas próby łączenia z bazą danych. Proszę spróbować później.' . mysqli_error($link);
          $sql = "ROLLBACK;";
          $result = mysqli_query($link,$query);
          $post_result = mysqli_query($link,$post_query);

      }
      else{
        if((mysqli_num_rows($result) == 0)||(mysqli_num_rows($post_result)==0))
        {
            echo 'Błąd bazy danych.';
        }
        else{
          $row = mysqli_fetch_assoc($result);
          $post_row = mysqli_fetch_assoc($post_result);
        if($post_row['comment_by']!=$_SESSION['steamid'])
        {
          if($row['user_level']!=0){
            $sql = "DELETE FROM posts WHERE post_id = $post_id";

            $result = mysqli_query($link,$sql);

            if(!$result)
            {
                echo 'Post nie zostałą usunięty.';

            }
            else
            {
                echo 'Post Został usunięty <a href="index.php">Home</a>.';
            }
          }
          else{
            echo 'Nie jesteś adminem lub to nie jest twój post, aby mieć uprawinia do tej strony';
          }
          }
          else{
        //a real user posted a real reply
        $sql = "DELETE FROM comments WHERE comment_id = $comment_id";

        $result = mysqli_query($link,$sql);

        if(!$result)
        {
            echo 'Komentarz nie zostałą usunięty.';

        }
        else
        {
            echo 'Komentarz Został usunięty cofnij się o stronę, lub rozpocznij przeszukiwanie forum od początku <a href="index.php">Home</a>.';
        }

    }
  }
    }
}

include 'partials/footer.php';
?>
