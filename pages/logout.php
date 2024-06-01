<?php
session_start();
if (($_SESSION["login"] != true) AND ($byakman->userInfo('username') == "" OR $byakman->userInfo('password') == "")) {
    header("Location: index.php?page=login");
    exit();
} else {
	$user_hash = sha1($byakman->userInfo('username')."-".$byakman->userInfo('password')."-");
	$files = glob("cache/".$user_hash."*");
	foreach($files AS $f) {
		if (file_exists($f)) {
			unlink($f);
		} else {
			
		}
	}
	
	$files = glob("cache/*.*");
	foreach ($files as $plk2) {
			$dosya_zamani = filemtime($plk2);
			$sure = 60*60*5;
			$tamsure = time()-$sure;
			if ($dosya_zamani < $tamsure) {
					if (file_exists($plk2)) {
						unlink($plk2);
					}
			}
    } 
    $_SESSION["login"] = false;
    unset($_SESSION['user_info']);
    unset($_SESSION['mac_address']);
    header("Location: index.php?page=login");
}
?>