


  var id = 0;

   function get_id_edit_post(clicked_id){
     id = $(clicked_id).attr("id");
     console.log(id);


       var html = $("<div />").append($('#post'+id).clone()).html();
       console.log(html);
       var html_clear="";
       $('#post'+id).html(html_clear);
       var html_edit_post_form = `
       <script type="text/javascript"> bkLib.onDomLoaded(function() { nicEditors.editors.push(new nicEditor({externalCSS : "style.css"}).panelInstance(document.getElementById("myNicEditorEditPost")));});
      $("#myNicEditorEditPost").autogrow(); </script>
       <h2 style="color:black;">Edytuj Post w  `+id+` :</h2>
       <form method="post" action="update_reply.php?id=`+id+`" ><div class="form-group " >
       <div class="bg-black" ><textarea  class="form-control" name="reply-content" id="myNicEditorEditPost" style="color: white;">`+html+`</textarea></div></div>
       <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       <input class="btn btn-primary" type="submit" value="Dodaj odpowiedź" /></div>
       </form>         </div>`
       $('#post'+id).html(html_edit_post_form);

  }
