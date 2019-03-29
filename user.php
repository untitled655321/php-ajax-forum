<?php
session_start();
include 'partials/header.php';
include 'partials/connect.php';


$sql = "SELECT
          user_id,
          person_name,
          avatar_full,
          user_level,
          banned
        FROM
            users
        WHERE
            user_id = " . mysqli_real_escape_string($link,$_GET['id']);


$result = mysqli_query($link,$sql);

if(!$result)
{
    echo 'Uzytkownicy nie mogli zostać wyświetleni, proszę spróbować później.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'Podany uzytkownik nie istnieje.';
    }
    else
    {



        while($row = mysqli_fetch_assoc($result))
        {

            echo '<div class="row border bg-black">';
                echo '<div class="col-8">';
                    echo '<h3>'. $row['person_name'] . '</a></h3><img src="' . $row['avatar_full'].'"></img>';
                echo '</div>';
                echo '<div class="col">';
                $banned = 0;
                $user_level = 0;
                if($row['banned']==1)
                  {
                    $banned = " Tak";
                    if($_SESSION['user_level']>=1)
                    {
                      echo 'Odbanuj użytkownika <a href="unban_user.php?user_id='.$row['user_id'].'"><i class="fas fa-check"></i></a>';
                    }
                  }
                    else
                      {
                        $banned = " Nie";
                        if($_SESSION['user_level']>=1)
                        {
                          echo 'Zbanuj użytkownika <a href="ban_user.php?user_id='.$row['user_id'].'"><i class="fas fa-ban"></i></a>';
                        }
                      }
                if($row['user_level']==1){$user_level= " Admin";} else if($row['user_level']==2){$user_level= "Super Admin";}else{$user_level=" Regularny Użytkownik";}
                echo '<h3> Czy użytkownik jest zbanowny? :'. $banned . ' </h3><h3> Uprawnienia użytkownika :'. $user_level .' </h3>';
                echo '</div>';
            echo '</div>';
        }
    }
}


include 'partials/footer.php';
?>
