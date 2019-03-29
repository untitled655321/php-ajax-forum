
 var id = 0;
 var id_add_comment = 0;
  function get_id(clicked_id){
    id = $(clicked_id).attr("id");
    console.log(id);
      getCommentContent();
      $('#comments'+id).toggle(300);
      $('#add_comment'+id).toggle(300);


}



function getCommentContent() {

  $.ajax({
    type: "GET",
    url: "/show_comments.php?topic_id=" + id
  }).done( function( data )
  {
    var jsonData = JSON.parse(data);
    var jsonLength = jsonData.results.length;
    console.log(jsonLength );

    var html = "";
    var html_clear ="";
    for (var i = 0; i < jsonLength; i++) {
      var result = jsonData.results[i];
      if((result.delete_comment==1)||(result.user_level>=1)){
      html += '<div class="form-group border-bottom">(' + result.comment_date + ')<img src="'+result.avatar+'"></img><b>' + result.person_name+'</b>: '+result.comment_content+' <div class="justify-content-end"><a onclick="myfunction'+result.comment_id+'()" style="cursor:pointer; color:red;"><i class="fas fa-minus-circle"></i></a><script> function myfunction'+result.comment_id+'() { var r = confirm("Czy usunąć komentarz?"); if (r == true) { window.location.href = "delete_comment.php?id='+result.comment_id+'"; } else{}}</script></div></div>';
    }
    else{
      html += '<div class="form-group border-bottom">(' + result.comment_date + ')<img src="'+result.avatar+'"></img><b>' + result.person_name+'</b>: '+result.comment_content+'</div>';

    }
    }
    $('#comments'+id).html(html_clear);
    $('#comments'+id).append(html);

  });
}


function get_id_add_comment(clicked_id_add_comment){
  id_add_comment = $(clicked_id_add_comment).attr("id");
  console.log(id_add_comment);
    getCommentContent();
    $('#comments'+id_add_comment).toggle(300);

}



function get_id_add_comment(clicked_id){
  id_add_comment = $(clicked_id).attr("id");
  console.log(id_add_comment);
    insertComment();
    getCommentContent();
}

function insertComment(){
  var chatInput = $('#comment_area'+id_add_comment).val();

  if(chatInput != ""){
    $.ajax({
      type: "GET",
      url: "/submit_comment.php?",
      data: {chattext: chatInput ,
      post_id: id_add_comment}
    });
  }



}
