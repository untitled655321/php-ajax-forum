<?php
//create_cat.php
session_start();
include 'partials/header.php';
include 'partials/connect.php';

$page=1;
if(isset($_GET['page'])){
  $page = $_GET['page'];
}

$resultsPerPage = 10;
$startFrom = ($page-1)*$resultsPerPage;

//first select the category based on $_GET['cat_id']
$sql = "SELECT
            topics.topic_id,
            topics.topic_subject,
            topics.topic_cat,
            categories.cat_id,
            categories.cat_name
        FROM
            topics
            LEFT JOIN
            categories
            ON
            topics.topic_cat = categories.cat_id
        WHERE
            topics.topic_id = " . mysqli_real_escape_string($link,$_GET['id']);

$result = mysqli_query($link,$sql);

if(!$result)
{
    echo 'Kategornia nie może zostać wyświetlona , proszę spróbować później.' . mysqli_error($link);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'Podana kategoria nie istnieje.';
    }
    else
    {
        //złap dane z posta w temacie
        while($row = mysqli_fetch_assoc($result))
        {

          //guzik za odpalenie modala który wyświetla NicEdit do utworenia nowego posta
          echo'
          <div class="row">
          <div class="col bg-black">

<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-black border-bottom">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item"><a href="category.php?id='.$row['cat_id'].'">'.$row['cat_name'].'</a></li>
    <li class="breadcrumb-item active" aria-current="page"> '.$row['topic_subject'].'</li>
  </ol>
</nav>
          </div>
          </div>
          <div class="row  bg-black">
              <div class="col border-bottom yinyang_div">
                  <div><h3>Temat w podkategorii: '.$row['topic_subject'].'</h3></div>
              </div></div>';



          //ciało modala z NicEdit do utworzenia nowego posta
            include 'partials/add_reply_module.php';
        }

        //do a query for the topics
        $sql = "SELECT
        posts.post_id,
              posts.post_topic,
              posts.post_content,
              posts.post_date,
              posts.post_by,
              posts.closed,
              users.steam_id,
              users.person_name,
              users.avatar_medium
                FROM
                posts
                  LEFT JOIN
                  users
                  ON
                  posts.post_by = users.steam_id
                WHERE
                    posts.post_topic = '".mysqli_real_escape_string($link,$_GET['id'])."'
                    LIMIT  ".$startFrom.",".$resultsPerPage."
                    ";

                    $query = "SELECT
                    post_id
                    FROM
                    posts
                    WHERE
                    post_topic = ".mysqli_real_escape_string($link,$_GET['id']);

        $result = mysqli_query($link,$sql);
        $result_number = mysqli_query($link,$query);
        if(!$result)
        {
          echo mysqli_error($link);
            echo 'Temat nie może zostać wyświetlonym prośzę spróbować później.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'Brak tematów w tej kategroii.';
            }
            else
            {
              while($row = mysqli_fetch_assoc($result))
              {
                //prepare the table
if($row['closed']==0){
        echo '
        <div class="row"><div class="col border-bottom bg-black " style="padding:5px;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Dodaj Post
        </button></div></div>

        <div class="row bg-black">';
        echo '<div class="col">';
}
else{
  echo '
  <div class="row"><div class="col border-bottom bg-black " style="padding:5px;"><h3 style="color:red;"> Temat zamknięty, nie można dodawać postów </h3></div></div>

  <div class="row bg-black">';
  echo '<div class="col">';

}
  echo   ' <ul class="list-unstyled">';

                  echo '<li class="media border-bottom bg-black">';
                  echo '<button class="btn-primary" onClick="zwin_rozwin_post'.$row['post_id'].'()">Zwiń/Rozwiń </button>';
                  echo '<script> function zwin_rozwin_post'.$row['post_id'].'() {
                    $("#post'.$row['post_id'].'").toggle(300);
                  }
                  </script>
                  </li>';

echo '<li class="media border-bottom bg-black" id="post'.$row['post_id'].'">';
  echo ' <div class="align-self-star mr-3 col-4 caption"><img src="'.$row['avatar_medium'].'"></img> Skomentowane przez:'.$row['person_name'].'</br>'.$row['post_date'].'</div>';


    echo '<div class="media-body caption col-8">';
      echo '<h5 class="mt-0 mb-1">Komentarz</h5>';
      echo  '<div >'.$row['post_content'].'</div>';
  echo   '</div>';
  if($_SESSION['steamid']==$row['post_by'])
  {

    echo '<div >';
    echo '<button type="button" class="btn btn-primary" onclick="editPost'.$row['post_id'].'()"> Edytuj Post </button> ';
    echo'<script>
    function editPost'.$row['post_id'].'() {
    var r = confirm("Czy edytować post?");
    if (r == true) {
    window.location.href = "edit_reply.php?id='.$row['post_id'].'";
    } else {

    }
    }
    </script>';
    echo '</div>';

  }
  if(($_SESSION['user_level']>=1)||($_SESSION['steamid']==$row['post_by']))
  {
    echo '<div >';
    echo '<a onclick="myfunction'.$row['post_id'].'()" style="cursor:pointer; color:red;" ><i class="fas fa-minus-circle"></i></a>';
    echo'<script>
    function myfunction'.$row['post_id'].'() {
    var r = confirm("Czy usunąć post?");
    if (r == true) {
    window.location.href = "delete_reply.php?id='.$row['post_id'].'";
    } else {

    }
    }
    </script>';
    echo '</div>';
}

echo  '</li>';
echo '<li class="media border-bottom bg-black ">';
echo '<div class="col">
<ul class="list-unstyled border-bottom ">

<input type="button" value="Zobacz Komentarze" id="'.$row['post_id'].'" onClick="get_id(this)" class="btn-primary"></input>

</ul>
      <ul class="list-unstyled">

    ';
echo '<li class="media">';
echo '

    <div class="col-8 caption" id="comments'.$row['post_id'].'" style="display: none;">
    </div>
    </li>';

echo '
<li class="media">
<div class="col" id="add_comment'.$row['post_id'].'" style="display: none;"  >
<div class="form-group">
   <label for="exampleFormControlTextarea1">Napisz Komentarz</label>
   <textarea class="form-control" id="comment_area'.$row['post_id'].'" rows="3" placeholder="Twój Komentarz"></textarea>
   <input type="button" value="Dodaj Komentarz" id="'.$row['post_id'].'" onClick="get_id_add_comment(this)" class="btn btn-primary"></input>

 </div>

</div>
</li>';

echo '</ul>
      </div>';
echo '</li>';
                }

                echo '</ul>';
                echo '</div>';
                echo '</div>
<div id="pages"class="row"></div>
                <script type="text/javascript">
                $(document).ready(function() {
                  var html = "";

                for(var i=Math.floor('.mysqli_num_rows($result_number)/$resultsPerPage.')+1;i>0;i--){
                  html = `&nbsp;&nbsp;&nbsp;<div><a href="topic.php?id=' . $_GET['id'] . '&page=`+i+`">`+i+`</a></div>`;
                  $("#pages").append(html);
                }
                });
                </script>



                <script type="text/javascript" src="js/nicEdit.js"></script> <script type="text/javascript">

                    bkLib.onDomLoaded(function() {
                  nicEditors.editors.push(
                  new nicEditor({externalCSS : "style.css"}).panelInstance(
                  document.getElementById("myNicEditor")
                  )
                  );
                  });
                    </script>';
            }
        }
    }
}
echo '<script src="js/comment.js"></script>';
echo '<script src="js/edytujPost.js"></script>';


include 'partials/footer.php';
?>
