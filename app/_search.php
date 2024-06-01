<?php
session_start();
if ($_SESSION["login"] != true AND $_SESSION["user_info"] == "") {
    header("Location: index.php");
    exit();
} else {
    header('Content-Type: application/json');

        include("../conf/functions.php");
        $data = array();
        $query = $_POST["query"];
        $livetv = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), "get_live_streams", "");
        $getLive = json_decode($livetv, true);
        $lv = array();
        $d = 0;
        foreach(@$getLive AS $gl) {
            $lv[$d]["name"] = $gl["name"];
            $lv[$d]["id"] = $gl["stream_id"];
           $d++;
        }

        $movies = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), "get_vod_streams", "");
        $getMovies = json_decode($movies, true);
        $mv = array();
        $m = 0;
        foreach(@$getMovies AS $gm) {
            $mv[$m]["name"] = $gm["name"];
            $mv[$m]["id"] = $gm["stream_id"];
           $m++;
        }

        $series = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'),"get_series", "");
        $getSeries = json_decode($series, true);
        $sr = array();
        $s = 0;
        foreach(@$getSeries AS $gs) {
            $sr[$s]["name"] = $gs["name"];
            $sr[$s]["id"] = $gs["series_id"];
            $s++;
        }

 
echo json_encode(array(
    "status" => true,
    "error"  => null,
    "data"   => array(
        "livetv" => $lv,
        "movies" => $mv,
        "series" => $sr
    )
));
    }