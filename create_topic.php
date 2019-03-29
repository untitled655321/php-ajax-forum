<?php
//create_cat.php
session_start();
include 'partials/header.php';
include 'partials/connect.php';


echo '<h2>Create a topic</h2>';
if($_SESSION['steamid'] == false)
{
    //the user is not signed in
    echo 'Przepraszamy, musisz być Zalogowany aby utworzyć temat.';

}
else if($_SESSION['banned']==1){
  echo 'Jesteś zbanowany, proszę skontakwoać się z adminitracją pod zakładką kontakt';
}
else
{

    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    categories";

        $result = mysqli_query($link,$sql);

        if(!$result)
        {
            //the query failed, uh-oh :-(
            echo 'Błąd podczas łączenia z bazą danych. Proszę spróbować później.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                //there are no categories, so a topic can't be posted
                if($_SESSION['user_level'] == 1)
                {
                    echo 'Nie stworzyłeś Kategorii.';
                }
                else
                {
                    echo 'Przed utworzeniem tematu, musisz poczekać aż admin utworzy kategorie.';
                }
            }
            else
            {

                echo '<form method="post" action="">
                <div class="form-group">
                    Temat: <input class="form-control" type="text" name="topic_subject" />
                    Kategoria:';
                    echo '</div>';
                    echo '<div class="form-group">';
                echo '<select class="form-control" name="topic_cat">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '<option value="'.$row['cat_id'].'">'.$row['cat_name'].'</option>';
                    }
                echo '</select>';
                echo '</div>';
                echo '<div class="form-group"> Wiadomość: <textarea class="form-control" name="post_content" /></textarea>
                    <input type="submit" value="Create topic" />
                 </form></div>';
            }
        }
    }

    else
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysqli_query($link,$query);

        if(!$result)
        {
            //Damn! the query failed, quit
            echo 'Błąd, podczas tworzenia tematu. Proszę spróbowac potem.';
        }
        else
        {

          //sekcja walidacji czy użytkownik jest zbanowany , a wię czy może tworzyć nowe tematy
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

            //jeżeli użytkowni nie jest zbanowany może utworzyć nowy temat
            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
            $sql = "INSERT INTO
                        topics(topic_subject,
                               topic_date,
                               topic_cat,
                               topic_by)
                   VALUES('" . mysqli_real_escape_string($link,$_POST['topic_subject']) . "',
                               NOW(),
                               '" . mysqli_real_escape_string($link,$_POST['topic_cat']) . "',
                               '" . $_SESSION['steamid'] . "'
                               )";

            $result = mysqli_query($link,$sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'Błąd, podczas próby łączenia z bazą danych. Proszę spróbować później.' . mysqli_error($link);
                $sql = "ROLLBACK;";
                $result = mysqli_query($link,$sql);
            }
            else
            {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $topicid = mysqli_insert_id($link);


                $sql = "INSERT INTO
                            posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysqli_real_escape_string($link,$_POST['post_content']) . "',
                                  NOW(),
                                  " . $topicid . ",
                                  " . $_SESSION['steamid'] . "
                            )";
                $result = mysqli_query($link,$sql);

                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'Błąd, podczas łączenia z bazą danych. Porszę spróbować później.' . mysql_error();
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($link,$sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($link,$sql);

                    //after a lot of work, the query succeeded!
                    echo 'Pomyślnie utworzono  <a href="topic.php?id='. $topicid . '">twój nowy temat.</a>.';
                }
            }
          }
          }
          }
        }
    }
}


include 'partials/footer.php';
?>
