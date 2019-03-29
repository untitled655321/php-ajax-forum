
$(document).ready(function(){
$( "#searchuser" ).keyup(function() {
  sendUserSearch();
});
sendUserSearch();
});

function sendUserSearch(){
  var chatInput = $('#searchuser').val();
    $.ajax({
      type: "GET",
      url: "/search_user.php?searchuser=" + encodeURIComponent( chatInput )
    }).done( function( data )
    {

      var jsonData = JSON.parse(data);
      var jsonLength = jsonData.results.length;
      var html = "";
      var html_clear ="";
      console.log(jsonLength);
      for (var i = 0; i < jsonLength; i++) {
        var result = jsonData.results[i];
        html += '<div class="form-group border-bottom"><a href="user.php?id='+result.user_id+'"><img src="'+result.avatar+'"></img><b>' + result.person_name+'</b></a></div>';
        //$('#r').animate({scrollTop: document.body.scrollHeight}, 800);
      }
      $('#results').html(html_clear);
      $('#results').append(html);

    });

}
