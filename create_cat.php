<?php
//create_cat.php
session_start();
include 'partials/header.php';
include 'partials/connect.php';

if($_SESSION['user_level']>=1){
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo '<form method="post" action="">
        Nazwa Kategorii: <input type="text" name="cat_name" />
        Opis Kategorii: <textarea name="cat_description" /></textarea>
        <input type="submit" value="Add category" />
     </form>';
}
else
{
    //the form has been posted, so save it
    $sql = "INSERT INTO categories(cat_name, cat_description)
       VALUES('".mysqli_real_escape_string($link,$_POST["cat_name"])."',
              '".mysqli_real_escape_string($link,$_POST["cat_description"])."')";
    $result = mysqli_query($link,$sql);
    if(!$result)
    {
        //something went wrong, display the error
        echo 'Error' . mysqli_error($link);
    }
    else
    {
        echo 'Dodano nową kategorię.';
    }
}
}
else{
  echo 'Nie masz uprawnień do tej podstrony';
}
?>
