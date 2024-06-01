<?
session_start();
if (($_SESSION["admin"]["login"] != true) OR ($_SESSION["admin"]["username"] == "") OR ($_SESSION["admin"]["password"] == "")) {
    header("Location: index.php");
    exit();
}else{
include("../../conf/functions.php");
	$type = $byakman->guvenlik($_GET["type"]);
	
	if ($type == 1) {
	$bouqets = $byakman->pdo->query("SELECT id, bouquet_name FROM bouqet_list WHERE status = '1' ORDER BY sira ASC")->fetchAll();
    $data = array();  
	$i = 0;
	foreach($bouqets AS $bq) {
	$data[$i] = $bq;
	$i++;
	}
	echo json_encode($data);
	}
}