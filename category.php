<?php
//create_cat.php
include 'partials/header.php';
include 'partials/connect.php';


//first select the category based on $_GET['cat_id']
$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
            cat_id = " . mysqli_real_escape_string($link,$_GET['id']);

$result = mysqli_query($link,$sql);

if(!$result)
{
    echo 'The category could not be displayed, please try again later.' . mysqli_error($link);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'This category does not exist.';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            echo '
            <div class="row">
            <div class="col bg-black">
                            <nav aria-label="breadcrumb">
                              <ol class="breadcrumb bg-black  border-bottom">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">' . $row['cat_name'] . '</li>
                              </ol>
                            </nav>
                            </div>
            </div>

            <div class="row"><div class="col bg-black yinyang_div" ><h2>Tematy w  ' . $row['cat_name'] . '</h2></div></div>';
        }

        //do a query for the topics
        $sql = "SELECT
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM
                    topics
                WHERE
                    topic_cat = " . mysqli_real_escape_string($link,$_GET['id']);

        $result = mysqli_query($link,$sql);

        if(!$result)
        {
            echo 'Nie można wyświetlić tematu , proszę spróbować później.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'Nie ma tematów w tej kategorii.';
            }
            else
            {
                //prepare the table

                echo '

                <div class="row border-bottom border-secondary bg-black">';
                    echo '<div class="col-8">';
                        echo '<h3>Temat</h3>' ;
                    echo '</div>';
                    echo '<div class="col-4">';
                                echo 'Utworzony';
                    echo '</div>';
                echo '</div>';

                while($row = mysqli_fetch_assoc($result))
                {
                  echo '<div class="row">
                    <div class="col carbon_div" style="height:25px;"></div></div>';
                    echo '<div class="row border-bottom bg-black result_div">';
                        echo '<div class="col-8">';
                            echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '" class="result_div">' . $row['topic_subject'] . '</a><h3>';
                        echo '</div>';
                        echo '<div class="col-4">';
                        echo date('d-m-Y', strtotime($row['topic_date']));
                          echo '</div>';
                          if($_SESSION['user_level']>=1)
                        {
                          echo '<div class="col">';
                          echo '<a onclick="myfunction'.$row['topic_id'].'()" ><i class="fas fa-minus-circle"></i></a>';
                          echo'<script>
                          function myfunction'.$row['topic_id'].'() {
                          var r = confirm("Czy usunąć kategorię?");
                          if (r == true) {
                          window.location.href = "delete_topic.php?id='.$row['topic_id'].'";
                          } else {

                          }
                          }
                          </script>';
                          echo '</div>';
                      }
                    echo '</div>';
                }
            }
        }
    }
}

include 'partials/footer.php';
?>
