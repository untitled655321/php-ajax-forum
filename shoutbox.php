<?php
session_start();
include 'partials/header.php';

echo "<div class='row'>
<div id='view_ajax' class='bg-black col'> Brak wiadomości w przeciągu godziny (1h). Zaloguj sie i napisz nową wiadomość !!!</div></div>";
if(!isset($_SESSION['steamid']))
{
  echo
  "<div class='row' class='bg-black'>
  Musisz być zalogowany aby korzystać z chatu
  </div>";
}
else{
echo "
    <div class='row bg-black'>

      <div class='col-8'><input type='text' id='chatInput' placeholder='Wiadomość' /></div><div class='col'><input type='button' value='Wyślij' id='btnSend' class='btn btn-success btn-block'/></div>

    </div>";
}
echo '<div class="row bg-black" style="margin-top: 22px;">
<h4> Ostatnia aktywność w przeciągu 24h: </h4>
<div id="view_content_watcher" class="bg-black col"></div>

</div>';

echo "<script src='js/main.js'></script>";
echo "<script src='js/content_watcher.js'></script>";
include 'partials/footer.php';
 ?>
