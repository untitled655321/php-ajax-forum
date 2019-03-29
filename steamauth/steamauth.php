<?php
ob_start();
session_start();

function logoutbutton() {
	echo "<form action='' method='get'><button class='btn btn-primary' name='logout' type='submit'>Wyloguj się</button></form>"; //logout button
}

function loginbutton($buttonstyle = "square") {
	$button['rectangle'] = "01";
	$button['square'] = "02";
	$button = "<a href='?login'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_".$button[$buttonstyle].".png'></a>";

	echo $button;
}

if (isset($_GET['login'])){
	require 'openid.php';
	require 'partials/connect.php';
	try {
		require 'SteamConfig.php';
		$openid = new LightOpenID($steamauth['domainname']);

		if(!$openid->mode) {
			$openid->identity = 'https://steamcommunity.com/openid';
			header('Location: ' . $openid->authUrl());
		} elseif ($openid->mode == 'cancel') {
			echo 'User has canceled authentication!';
		} else {
			if($openid->validate()) {
				$id = $openid->identity;
				$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
				preg_match($ptn, $id, $matches);



	                $url = "https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$matches[1];
	                $json_object= file_get_contents($url);
	                $json_decoded = json_decode($json_object);

	                foreach ($json_decoded->response->players as $player)
	                {
	                   $query = "SELECT * FROM users WHERE steam_id = $player->steamid";
										 $query_id = mysqli_query($link,$query);
										 if(mysqli_num_rows($query_id)==0){
											 $sql_steam = "INSERT INTO users(steam_id,person_name,profile_url,avatar,avatar_medium,avatar_full,real_name) VALUES ('$player->steamid','$player->personaname','$player->profileurl','$player->avatar','$player->avatarmedium','$player->avatarfull','$player->realname')";
											 mysqli_query($link,$sql_steam);
											 mysqli_error($link);

										 }
										 else{
											 $sql = "UPDATE users SET person_name='$player->personaname',profile_url='$player->profileurl',avatar='$player->avatar',avatar_medium='$player->avatarmedium',avatar_full='$player->avatarfull',real_name='$player->realname' WHERE steam_id='$player->steamid'";
											 mysqli_query($link,$sql);
											 mysqli_error($link);
										 }
										 $result = mysqli_query($link,$query);
										 $row = mysqli_fetch_assoc($result);
										 $_SESSION['user_id'] = $row['user_id'];
										 $_SESSION['user_level'] = $row['user_level'];
										 $_SESSION['banned'] = $row['banned'];

	                }
				$_SESSION['steamid'] = $matches[1];
				if (!headers_sent()) {
					header('Location: '.$steamauth['loginpage']);
					exit;
				} else {
					?>
					<script type="text/javascript">
						window.location.href="<?=$steamauth['loginpage']?>";
					</script>
					<noscript>
						<meta http-equiv="refresh" content="0;url=<?=$steamauth['loginpage']?>" />
					</noscript>
					<?php
					exit;
				}
			} else {
				echo "User is not logged in.\n";
			}
		}
	} catch(ErrorException $e) {
		echo $e->getMessage();
	}
}

if (isset($_GET['logout'])){
	require 'SteamConfig.php';
	session_unset();
	session_destroy();
	header('Location: '.$steamauth['logoutpage']);
	exit;
}

if (isset($_GET['update'])){
	unset($_SESSION['steam_uptodate']);
	require 'userInfo.php';
	header('Location: '.$_SERVER['PHP_SELF']);
	exit;
}

// Version 4.0

?>
