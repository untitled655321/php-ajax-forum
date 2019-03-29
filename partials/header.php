<?php
require 'steamauth/steamauth.php';

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="YinYang CS Forum" />
    <meta name="keywords" content="put, keywords, here" />
    <title>Sieć Serwerów Counter-Strike YinYang-CS.pl</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <script
  			  src="https://code.jquery.com/jquery-2.2.4.min.js"
  			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  			  crossorigin="anonymous"></script>

</head>
<body background="image/background.jpg" class="img-fluid">
<script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>

      <nav class="navbar navbar-expand-lg navbar-dark bg-dark carbon_div ">
  <a class="navbar-brand" href="/index.php">YinYang-CS Forum</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/index.php"><i class="fas fa-home"></i>Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
       <a class="nav-link" href="/users.php"><i class="fas fa-users"></i> Użytkownicy</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/shoutbox.php"><i class="fas fa-comments"></i>Chat Online</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/serwery.php"><i class="fas fa-server"></i> Serwery</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/contact.php"><i class="fas fa-envelope"></i> Kontakt</a>
      </li>
    </ul>

<ul class="navbar-nav">
  <?php
  if(!isset($_SESSION['steamid'])) {

      echo "Witaj Gosciu! Prosze sie zalogowac <br><br>";
      loginbutton("rectangle"); //login button

  }  else {
      include ('steamauth/userInfo.php');

      //Protected content
      echo "<div class='row'> <div class='col'>Witaj ponownie! " . $steamprofile['personaname'] . "</div></br>";
      echo "<div class='col'>Twoj awatar:  </br>" . '<img src="'.$steamprofile['avatarmedium'].'" title="" alt="" /></div><br></div>'; // Display their avatar!

      logoutbutton();
  }
/*if(isset($_SESSION['signed_in']))
{
  echo 'Hello ' . $_SESSION['user_name'] . '. Not you? <a href="/signout.php">Sign out</a>';
}
else
{
  echo '<li class="nav-item"> <a class="nav-link" href="/signin.php">Sign in</a></li> <li class="nav-item"> <a class="nav-link" href="/signup.php">Create account</a></li>';
}*/
?>
</ul>
  </div>
</nav>

        <div class="container">
