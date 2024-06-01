<?php
session_start();
if ($_SESSION["login"] != true AND $_SESSION["user_info"] == "") {
    header("Location: index.php");
    exit();
} else {
    if ($_POST) {
     
        require_once("../conf/functions.php");	
		
		$bouquets = $byakman->guvenlik($_POST["bouqet"]);
		$post_data = array(
			'username' => $byakman->userInfo('username'),
			'password' => $byakman->userInfo('password'),
			'user_data' => array(
			'bouquet' => json_encode($bouquets)));

		$api_re = json_decode($byakman->_curl($siteInfo->site_xtream . "api.php?action=user&sub=edit", $post_data), true);

		if ($api_re["result"] == 1) {
			echo 1;
		} else {
			echo 0;
		} 
	}
}
?>