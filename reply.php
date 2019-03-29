<?php
//create_cat.php
session_start();
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
    if(!$_SESSION['steamid'])
    {
        echo 'Musisz być zalogowany aby wysyłać odpowiedzi.';
    }
    else
    {

      //sekcja odpowiadająca za walidacje czy użytkownik jest zbanowany, jeżeli tak to nie może postować odpowiedzi
      $id = $_SESSION['user_id'];
      $query = "SELECT banned FROM users WHERE user_id = $id";
      $result = mysqli_query($link,$query);
      if(!$result)
      {
          //something went wrong, display the error
          echo 'Błąd, podczas próby łączenia z bazą danych. Proszę spróbować później.' . mysqli_error($link);
          $sql = "ROLLBACK;";
          $result = mysqli_query($link,$query);
      }
      else{
        if(mysqli_num_rows($result) == 0)
        {
            echo 'Błąd bazy danych.';
        }
        else{
          $row = mysqli_fetch_assoc($result);
          if($row['banned']==1){
            echo 'Jesteś zbanowany, nie możesz utworzyć tematu. Proszę skontaktować się z administracją w celu wyjaśnienia zaistniałej sytuacji';
          }
          else{
        //a real user posted a real reply
        $sql = "INSERT INTO
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by)
                VALUES ('" . $_POST['reply-content'] . "',
                        NOW(),
                        " . mysqli_real_escape_string($link,$_GET['id']) . ",
                        " . $steamprofile['steamid'] . ")";

        $result = mysqli_query($link,$sql);

        if(!$result)
        {
            echo 'Twoja odpowieć nie została zapisana> Proszę spróbować poźniej.';
        }
        else
        {
            echo 'Twoja odopieź została zapisana , sprawdź <a href="topic.php?id=' . htmlentities($_GET['id']) . '">temat</a>.';
            header( "Location: topic.php?id=" . htmlentities($_GET['id']) . "" );
        }
      }
    }
  }
    }
}

include 'partials/footer.php';
?>
