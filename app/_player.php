<?php
session_start();
if ($_SESSION["login"] != true AND $_SESSION["user_info"] == "") {
    header("Location: index.php");
    exit();
} else {

    if ($_POST) {
        include("../conf/functions.php");
        $type = $byakman->guvenlik($_POST["type"]);
        $item = $byakman->guvenlik($_POST["item"]);
        $file = $byakman->guvenlik($_POST["file"]);
        switch ($tip){
            case 'mkv':
                $tip = '.mkv';
                $mime = 'video/x-matroska';
                break;
            case 'mp4':
                $tip = '.mp4';
                $mime = 'video/mp4';
                break;
            case 'avi':
                $tip = '.avi';
                $mime = 'video/x-msvideo';
                break;

        }
        if ($type == 1) {

            $data = array();
            $data["type"] = $type;
            $data["item"] = $item;
            $data["file"] = $tip;
            $data["mime"] = $mime;
            echo json_encode($data, true);

        echo json_encode($movie_url, true);

        } else if ($type == 2) {

          
            $data = array();
            $data["type"] = $type;
            $data["item"] = $item;
            $data["file"] = $tip;
            $data["mime"] = $mime;
            echo json_encode($data, true);

        }
     
    }

}