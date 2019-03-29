<?php
session_start();
include 'partials/header.php';
/*include 'partials/connect.php';

$sql = 'SELECT
            user_id,
            person_name,
            avatar
            FROM users';

$result = mysqli_query($link,$sql);

if(!$result)
{
    echo 'Uzytkownicy nie mogli zostać wyświetleni, proszę spróbować później.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'Nie zdefiniowano Uzytkownika.';
    }
    else
    {*/
      echo '<div class="row border border-secondary bg-black">';
      echo '<div class="col"> Szukaj Użytkownika';
      echo '<input type="text" placeholder="Szukaj użytkownika" id="searchuser"/><div id="result"></div></div>';
          echo '<div class="col-8">';
              echo '<h3>Użytkownik</h3>' ;
          echo '</div>';
          echo '<div class="col-4">';
                      echo ' ';
          echo '</div>';
          echo '<div id="results"></div>';
      echo '</div>';



/*
        while($row = mysqli_fetch_assoc($result))
        {

            echo '<div class="row border bg-black">';
                echo '<div class="col-8">';
                    echo '<h3><a href="user.php?id='.$row['user_id'].'">'. $row['person_name'] . '</a></h3><img src="' . $row['avatar'].'"></img>';
                echo '</div>';

            echo '</div>';
        }
    }
}*/
echo '<script src="js/search_user.js"></script>';
include 'partials/footer.php';
?>
