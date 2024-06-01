<?
session_start();
if (($_SESSION["admin"]["login"] != true) OR ($_SESSION["admin"]["username"] == "") OR ($_SESSION["admin"]["password"] == "")) {
    header("Location: index.php");
    exit();
}else{
include("../../conf/functions.php");

	if ($_POST) {
		$type = $byakman->guvenlik($_GET["type"]);
		if ($type == 1) {
		$bqid = $byakman->guvenlik($_POST["bqid"]);
		$position = $byakman->guvenlik($_POST["position"]);
	
	    $sorgu = $byakman->pdo->query("UPDATE bouqet_list SET sira = '$position' WHERE bouquet_id = '$bqid'");

		} else if ($type == 2) {
		
		$guid = $byakman->guvenlik($_POST["guid"]);
		$position = $byakman->guvenlik($_POST["position"]);
	
	    $sorgu = $byakman->pdo->query("UPDATE guides SET sira = '$position' WHERE id = '$guid'");
	
			
	}

}
}
