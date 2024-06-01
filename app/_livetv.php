<?php
session_start();
if ($_SESSION["login"] != true AND $_SESSION["user_info"] == "") {
    header("Location: index.php");
    exit();
} else {

    if ($_POST) {
     
        require_once("../conf/functions.php");
        $type = $byakman->guvenlik($_POST["type"]);
        if ($type == 1) {
        $bouquet_cat = $byakman->guvenlik($_POST["cat"]);
        if (isset($bouquet_cat)) {

            if ($bouquet_cat != "") {

                if (is_numeric($bouquet_cat)) {
                    $get_url = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), "get_live_streams&category_id=", $bouquet_cat);
					$urldata = json_decode($get_url, true);
					$xml = $byakman->player_epg($byakman->userInfo('username'), $byakman->userInfo('password'));
                    $now = time();
                    $data = array();
                    $i = 1;
                    foreach ($urldata as $item) {
                        if ($item['epg_channel_id'] != null OR $item['epg_channel_id'] != "0" OR $item['epg_channel_id'] != "") {
                        $filtered = $xml->xpath('//programme[@channel="'.$item["epg_channel_id"].'"]');
						$array = json_decode(json_encode((array)$filtered), TRUE);
						$epg_data = array();
						$e = 0;
						foreach($array AS $filter) {
							if((strtotime($filter["@attributes"]["start"]) <= $now) AND (strtotime($filter["@attributes"]["stop"]) >= $now)) {
								$epg_data["title"] = $filter["title"];
							}
							$e++;
						}
                        $data[$i]["epg_title"] = $epg_data["title"]; 
                        } else {
                        }
                        $data[$i]["stream_id"] = $item['stream_id'];
                        $data[$i]["stream_icon"] = $item['stream_icon'];
                        $data[$i]["name"] = $item['name'];
                        $i++;
                    }
                    echo json_encode($data, true);

                }

            }

        }
        } else if ($type == 2) {

            $channel = $byakman->guvenlik($_POST["channel"]);

            $channel_url = $siteInfo->site_xtream."live/".$byakman->userInfo("username")."/".$byakman->userInfo("password")."/".$channel.".m3u8";

            echo $channel_url;

        } else if ($type == 3) {

            $channel = $byakman->guvenlik($_POST["channel"]);

            $epg_url =  $byakman->player_api($byakman->userInfo('username'), $byakman->userInfo('password'), "&action=get_simple_data_table&stream_id=".$channel."");

            $cat_get = $byakman->get_curl($epg_url);
            $getCat = json_decode($cat_get, true);
            $data = array();
            $now = time();
            $i = 1;
            foreach ($getCat["epg_listings"] as $item) {
               if (strtotime($item["start"]) >= $now) {
                $cevir_start = strtotime($item["start"]);
                $cevir_end = strtotime($item["end"]);
                $data[$i]["title"] = base64_decode($item["title"]);
                $data[$i]["description"] = base64_decode($item["description"]);
                $data[$i]["start"] = date("H:m", $cevir_start);
                $data[$i]["end"] = date("H:m", $cevir_end);
                if ($i++ == 4) break;
                } else {

                }
               
            }

            echo json_encode($data, true);
        }
    }

}

?>