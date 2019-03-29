<?php
//create_cat.php
include 'partials/header.php';
include 'partials/connect.php';


if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    echo 'Tego pliku nie można wywołać bezpośrednio.';
}
else
{
    //check for sign in status
    $post_id = $_GET['id'];


      //sekcja odpowiadająca za walidacje czy użytkownik jest adminem aby usunąć kategorię
      $id = $_SESSION['user_id'];
      $post_query = "SELECT post_by FROM posts WHERE post_id = $post_id";
      $post_result = mysqli_query($link,$post_query);
      if(!$post_result)
      {
          //something went wrong, display the error
          echo 'Błąd, podczas próby łączenia z bazą danych. Proszę spróbować później.' . mysqli_error($link);
          $sql = "ROLLBACK;";
          $result = mysqli_query($link,$query);
          $post_result = mysqli_query($link,$post_query);

      }
      else{
        if(mysqli_num_rows($post_result)==0)
        {
            echo 'Błąd bazy danych.';
        }
        else{
          $post_row = mysqli_fetch_assoc($post_result);
        if($post_row['post_by']!=$_SESSION['steamid'])
        {

            echo 'Nie jesteś adminem lub to nie jest twój post, aby mieć uprawinia do tej strony';

          }
          else{
        //a real user posted a real reply
        $sql = 'UPDATE
                    posts
                    SET
                    post_content = "'. mysqli_real_escape_string($link,$_POST['reply-content']) .'"
                WHERE
                     post_id = "' . mysqli_real_escape_string($link,$_GET['id']) . '"';

        $result = mysqli_query($link,$sql);

        if(!$result)
        {
            echo 'Post nie zostałą usunięty.';

        }
        else
        {
            echo 'Post Został Edytowny <a href="index.php">Home</a>.';
        }

    }
  }
    }
}

include 'partials/footer.php';
?>
