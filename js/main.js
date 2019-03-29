var lastTimeID = 0;

$(document).ready(function() {
  $('#btnSend').click( function() {
    sendChatText();
    $('#chatInput').val("");
  });
  startChat();

});

$(document).keyup(function(event) {
    if (event.keyCode === 13) {
        $("#btnSend").click();
    }
});

function startChat(){
    setInterval( function() { getContent();
    getChatText();}, 2000);


}

function getChatText() {

  $.ajax({
    type: "GET",
    url: "/refresh.php?lastTimeID=" + lastTimeID
  }).done( function( data )
  {

    var jsonData = JSON.parse(data);
    var jsonLength = jsonData.results.length;
    var html = "";

    for (var i = 0; i < jsonLength; i++) {
      var result = jsonData.results[i];
      html += '<div class="form-group border-bottom">(' + result.created + ')<img src="'+result.avatar+'"></img><b>' + result.name+'</b>: ' + result.content + '</div>';
      console.log(result.created);
      lastTimeID = result.id;
      $.playSound("sounds/ding.wav");

    }
    if(html!=""){
    $('#view_ajax').append(html);
    $('#view_ajax').animate({scrollTop: $('#view_ajax').prop("scrollHeight")}, 500);

    }
    else{
      $('#view_ajax').append(html);

    }
  });
}
$(document).on('change','#view_ajax',function(){
  //var height = document.getElementById("#view_ajax").height;
//$('#view_ajax').animate({scrollTop: 10}, 800);

});

function sendChatText(){
  var chatInput = $('#chatInput').val();

  if(chatInput != ""){
    $.ajax({
      type: "GET",
      url: "/submit.php?chattext=" + encodeURIComponent( chatInput )
    });
  }
}




var lastTimeIDD = 0;
var lastTimeIDComment = 0;
function getContent() {

  $.ajax({
    type: "GET",
    url: '/content_watcher_refresch.php?lastTimeID='+ lastTimeIDD
  }).done( function( data )
  {

    var jsonData = JSON.parse(data);
    var jsonLength = jsonData.results.length;
    var html = "";

    for (var i = 0; i < jsonLength; i++) {
      var result = jsonData.results[i];

  html += '<div class="form-group border-bottom"><a href="topic.php?id='+result.topic+'" target="_blank">Zobacz Post </a>(' + result.created + ')<img src="'+result.avatar+'"></img><b>' + result.name+'</b>: ' + result.content + '</div>';

      console.log(result.created);
      lastTimeIDD = result.id;
    }

    if(html!=""){
      //$('#view_content_watcher').html("");
    $('#view_content_watcher').append(html);
    $('#view_content_watcher').animate({scrollTop: $('#view_content_watcher').prop("scrollHeight")}, 500);

    }
    else{

      $('#view_content_watcher').append(html);

    }


  });
}
