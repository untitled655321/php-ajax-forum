<?php
//create_cat.php
session_start();
include 'partials/header.php';
include 'partials/connect.php';



$sql = 'SELECT
            cat_id,
            cat_name,
            cat_description FROM categories';

$result = mysqli_query($link,$sql);

if(!$result)
{
    echo 'Kategoria nie mogła zostać wyświetlona, proszę spróbować później.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'Nie zdefiniowano Kategorii.';
    }
    else
    {
      if($_SESSION['user_level']>=1)
      {
      echo '<div class="nav-item">
        <a class="nav-link" href="/create_topic.php">Utwórz temat</a>
      </div>';
    }
      echo '
      <div class="row">
      <div class="col  bg-black">
      <nav aria-label="breadcrumb">
  <ol class="breadcrumb  bg-black border-bottom">
    <li class="breadcrumb-item active" aria-current="page">Home</li>
  </ol>
</nav>
</div>
</div>

      <div class="row border-bottom border-secondary bg-black yinyang_div">';
          echo '<div class="col-8">';
              echo '<h3>Kategoria</h3>' ;
          echo '</div>';

      echo '</div>';


        while($row = mysqli_fetch_assoc($result))
        {
          echo '<div class="row">';
          echo '<div class="col carbon_div" style="height:30px;"></div>';
          echo '</div>';
            echo '<div class="row border-bottom bg-black">';
                echo '<div class="col-8">';
                    echo '<h3><a href="category.php?id='.$row['cat_id'].'" class="result_div">'. $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</div>';
                if($_SESSION['user_level']==2)
                {
                echo '<div class="col-8">';
                echo '<a onclick="myfunction'.$row['cat_id'].'()" ><i class="fas fa-minus-circle"></i></a>';
                echo'<script>
function myfunction'.$row['cat_id'].'() {
  var r = confirm("Czy usunąć kategorię?");
if (r == true) {
    window.location.href = "delete_category.php?id='.$row['cat_id'].'";
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

include 'partials/footer.php';
?>
