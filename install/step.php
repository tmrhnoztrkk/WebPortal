<? 
session_start();
if ($_POST) {
	
		$type = $_POST["type"];
		
		if ($type == 1) {
			unset($_SESSION["lang"]);
			$lang = $_POST["lang"];
			$_SESSION["lang"] = $lang;
			echo 1;
			
		} else if ($type == 2) {
			
		$portal = $_POST["portal"];
		
		$portal_adres = explode(":", $portal);
		$portal_port = str_replace("/", "", $portal_adres[2]);
		$_SESSION["portal_url"] = $portal;
		echo 1;
		} else if ($type == 3) {

		$db_host = $_POST["db_host"];
		$db_user = $_POST["db_user"];
		$db_pass = $_POST["db_pass"];
		$db_data = $_POST["db_data"];
		$_SESSION["db_host"] = $db_host;
		$_SESSION["db_user"] = $db_user;
		$_SESSION["db_pass"] = $db_pass;
		$_SESSION["db_data"] = $db_data;

		$dosya_yolu = "../conf/config.php";
		$myfile = fopen($dosya_yolu, "w");
		$connect_data = '<?php
		define("DB_HOST","'.$db_host.'");
		define("DB_USER", "'.$db_user.'");
		define("DB_PASS", "'.$db_pass.'");
		define("DB_DATA", "'.$db_data.'");
		?>';
		$yaz = fwrite($myfile, $connect_data);
		if ($yaz) {

			// Name of the file
			$filename = 'database.sql';
			// MySQL host
			$mysql_host = $db_host;
			// MySQL username
			$mysql_username = $db_user;
			// MySQL password
			$mysql_password = $db_pass;
			// Database name
			$mysql_database = $db_data;

			// Connect to MySQL server
			$con = @new mysqli($mysql_host,$mysql_username,$mysql_password,$mysql_database);

			// Check connection
			if ($con->connect_errno) {
				echo 3;
			}
			$drop = "DROP TABLE `admins`, `bouqet_list`, `guides`, `settings`;";
			$dropable = $con->query($drop);
			// Temporary variable, used to store current query
			$templine = '';
			// Read in entire file
			$lines = file($filename);
			// Loop through each line
			foreach ($lines as $line) {
			// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;

			// Add this line to the current segment
				$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
					// Perform the query
					$con->query($templine) or print('4');
					// Reset temp variable to empty
					$templine = '';
				}
			}
			echo 1;
			$con->close();

		} else {
			echo 2;
		}

		} else if ($type == 4) {

			$con = @new mysqli($_SESSION["db_host"],$_SESSION["db_user"],$_SESSION["db_pass"],$_SESSION["db_data"]);
			if ($con->connect_errno) {
				echo 2;
			} else {
			$dns_adress = $_SESSION["portal_url"];
			$dns_adress_2 = $_SESSION["portal_url"]."c";
			$dns_update = "UPDATE settings SET site_xtream='$dns_adress', site_portal ='$dns_adress_2' WHERE id='1'";
			$site_update = $con->query($dns_update);
				if ($site_update) {

					$username = $_POST["username"];
					$password = $_POST["password"];
					$pass_enc = md5($password);
					$create = time();

					$user_create = "INSERT INTO admins (username, pass, create_time, status) VALUES ('$username', '$pass_enc','$create', '1')";
					$ekle = $con->query($user_create);
					if ($ekle) {
						echo 1;
					} else {
						echo 3;
					}

				} else {
					echo 4;
				}
			
			}
			$con->close();

		} else if ($type == 5) {
			unset($_SESSION["lang"]);
			unset($_SESSION["portal_url"]);
			unset($_SESSION["db_host"]);
			unset($_SESSION["db_user"]);
			unset($_SESSION["db_pass"]);
			unset($_SESSION["db_data"]);
			$sil = array_map('unlink', glob("../install/*.*"));
			if ($sil == 1) {
				echo 1;
			} else {
				echo 2;
			}
		}
}