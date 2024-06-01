<?php
session_start();
if ($_SESSION["login"] != true AND $_SESSION["user_info"] == "") {
    header("Location: index.php");
    exit();
} else {


    if ($_POST) {
        include("../conf/functions.php");
        $type = $byakman->guvenlik($_POST["type"]);

        if ($type == 1) {

			function SaveSipTv($mac='',$url='',$pin='')
				{
				$data = array(
				'mac' => $mac,
				'sel_countries' => "USSR",
				'sel_logos' => 0,
				'keep' => "on",
				'lang' => "en",
				'url1' => $url,
				'epg1' => "",
				'pin' => $pin,
				'url_count' => 1,
				'file_selected' => 0,
				'plist_order' => 0,
				);

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://siptv.eu/scripts/up_url_only.php');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
				curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
				$headers = array();
				$headers[] = 'Connection: keep-alive';
				$headers[] = 'Pragma: no-cache';
				$headers[] = 'Cache-Control: no-cache';
				$headers[] = 'Accept: */*';
				$headers[] = 'Sec-Fetch-Dest: empty';
				$headers[] = 'X-Requested-With: XMLHttpRequest';
				$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36';
				$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
				$headers[] = 'Origin: https://siptv.eu';
				$headers[] = 'Sec-Fetch-Site: same-origin';
				$headers[] = 'Sec-Fetch-Mode: cors';
				$headers[] = 'Referer: https://siptv.eu/mylist/';
				$headers[] = 'Accept-Language: tr,en;q=0.9';
				$headers[] = 'Cookie: origin=valid; captcha=1';
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$result = curl_exec($ch);
				curl_close($ch);
				return $result;
				}
				$url_create = ''.$siteInfo->site_xtream.'get.php?username='.$byakman->guvenlik($_POST["username"]).'&password='.$byakman->guvenlik($_POST["password"]).'&type=m3u_plus&output=ts';
				$result = SaveSipTv($_POST['mac'],$url_create,$_POST['pin']);
				if ($result == 'MAC address is not found!') {
					echo 0;
				} else if ($result == '1 URL added! Restart the App.') {
					echo 1;
				}

        } else if ($type == 2) {

		function SaveRoyalIpTv($mac='',$url='')
			{
				$data = array(
					'mac' => $mac,
					'url' => $url,
				);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://www.royaliptvapp.com/php/addMac.php');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
				curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
				$headers = array();
				$headers[] = 'Authority: www.royaliptvapp.com';
				$headers[] = 'Pragma: no-cache';
				$headers[] = 'Cache-Control: no-cache';
				$headers[] = 'Accept: */*';
				$headers[] = 'Sec-Fetch-Dest: empty';
				$headers[] = 'X-Requested-With: XMLHttpRequest';
				$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36';
				$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
				$headers[] = 'Origin: https://www.royaliptvapp.com';
				$headers[] = 'Sec-Fetch-Site: same-origin';
				$headers[] = 'Sec-Fetch-Mode: cors';
				$headers[] = 'Referer: https://www.royaliptvapp.com/myList.html';
				$headers[] = 'Accept-Language: tr,en;q=0.9';
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
				}
				curl_close($ch);
				return $result;
			}
			$url_create = ''.$siteInfo->site_xtream.'get.php?username='.$byakman->guvenlik($_POST["username"]).'&password='.$byakman->guvenlik($_POST["password"]).'&type=m3u_plus&output=ts';
			$sonuc = trim(SaveRoyalIpTv($_POST['mac'],$url_create));
			if ($sonuc == mb_strtoupper($_POST['mac'])) {
				echo 1;
			}else{
				echo 0;
			}

        }
    }
}

?>