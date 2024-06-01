<?
session_start();
if ($_SESSION["login"] != true AND $_SESSION["user_info"] == "") {
    header("Location: index.php");
    exit();
} else {
include("../conf/functions.php");

	if ($_POST) {
		if ($siteInfo->password_change == 1) {
		$password = $byakman->guvenlik($_POST["password"]);
		$password_c = $byakman->guvenlik($_POST["password_c"]);
			if ($password == "" OR $password_c == "") {
				echo 2;
			} else if ($password != $password_c) {
				echo 3;
			} else {
				
				$post_data = array(
                    'username' => $byakman->userInfo('username'),
                    'password' => $byakman->userInfo('password'),
                    'user_data' => array(
                            'password' => $password));
							
				$opts = array('http' => array(
					'method' => 'POST',
					'header' => 'Content-type: application/x-www-form-urlencoded',
					'content' => http_build_query($post_data)));
					
				$context = stream_context_create($opts);
                $api_re = json_decode(file_get_contents($siteInfo->site_xtream . "api.php?action=user&sub=edit", false, $context), true);
				if ($api_re["result"] == 1) {
						echo 1;
				}
			}
		
		}
	}	
}
?>