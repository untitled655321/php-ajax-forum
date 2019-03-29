<?php
 echo '
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
      <div class="row">
      <div class="col">
  <script type="text/javascript" src="js/nicEdit.js"></script> <script type="text/javascript">

      bkLib.onDomLoaded(function() {
    nicEditors.editors.push(
    new nicEditor({externalCSS : "style.css"}).panelInstance(
    document.getElementById("myNicEditor")
    
    )
    );
    });

  $(".form-control").width("1000px");
      </script>
       <h2 style="color:black;">Napisz Post w  '. $row[topic_subject] . ' :</h2>

       <form method="post" action="reply.php?id='.$row[topic_id].'" >
          <div class="form-group " >
       <div class="bg-black" >
     <textarea  class="form-control" name="reply-content" id="myNicEditor" style="color: white;"></textarea>
     </div>

     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<input class="btn btn-primary" type="submit" value="Dodaj odpowiedź" />
     </div>
  </form>

      </div>
      </div>
      </div>
      </div>


    </div>
  </div>

</div>
<script type="text/javascript">
var dupa = $(".container").width()/2*1.3;
$(".form-control").width(dupa);
$(".form-control").height(200);


console.log(dupa);

</script>
';


?>
