<?php
//create_cat.php
session_start();
include 'partials/header.php';
include 'partials/connect.php';



$sql = 'SELECT
            post_id,post_content
             FROM posts WHERE post_id =' . mysqli_real_escape_string($link,$_GET['id']);

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


        while($row = mysqli_fetch_assoc($result))
        {

          echo '

               <div class="container-fluid">
               <div class="row">
               <div class="col">

                <h2 style="color:black;">Edytuj Post :</h2>
                <script type="text/javascript" src="js/nicEdit.js"></script> <script type="text/javascript">

                    bkLib.onDomLoaded(function() {
                  nicEditors.editors.push(
                  new nicEditor({externalCSS : "style.css"}).panelInstance(
                  document.getElementById("myNicEditor")
                  )
                  );
                  });
                    </script>
                <form method="post" action="edit_post_authentic.php?id='.$row[post_id].'" >
                   <div class="form-group " >
                <div class="bg-black" >
              <textarea  class="form-control" name="reply-content" id="myNicEditor" style="color: white;">'.$row[post_content].'</textarea>
              </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <input class="btn btn-primary" type="submit" value="Edytuj Post" />
              </div>
           </form>

               </div>
               </div>
               </div>
               </div>



         
         ';
        }
    }
}

include 'partials/footer.php';
?>
