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
    if(!$_SESSION['steamid'])
    {
        echo 'Musisz być adminem.';
    }
    else
    {

      //sekcja odpowiadająca za walidacje czy użytkownik jest adminem aby usunąć kategorię
      $id = $_SESSION['user_id'];
      $query = "SELECT user_level FROM users WHERE user_id = $id";
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
        if($row['user_level']==0){
            echo 'Nie jesteś adminem aby mieć uprawinia do tej strony';
          }
          else{
        //a real user posted a real reply
        $id = $_GET['user_id'];
        $sql = "UPDATE users SET banned=1 WHERE user_id = $id";

        $result = mysqli_query($link,$sql);

        if(!$result)
        {
            echo 'Nie zbanowano usera.';

        }
        else
        {
            echo 'Userer został banowany <a href="users.php">Użytkownicy</a>.';
        }
      }
    }
  }
    }
}

include 'partials/footer.php';
?>
