<?

if (!function_exists('curl_init') OR !function_exists('curl_exec') OR !function_exists('curl_setopt'))
die('PHP Curl Library not found');
error_reporting(E_ALL & ~E_NOTICE);

date_default_timezone_set('Europe/Istanbul');
setlocale(LC_TIME, "turkish"); 
session_start();

class ByAkman {

    function __construct () {
		require "config.php";
		try
		{
			$this->pdo = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_DATA.";charset=utf8", "".DB_USER."", "".DB_PASS."");
			$this->pdo->exec("SET NAMES utf8");
			$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
		catch(\PDOException $e)
		{
			echo '<div align="center" style="-webkit-border-radius: 0;border-radius: 0;padding: 10px 15px;background-color: #f2dede;border-color: #eed3d7;color: #b94a48;margin-bottom: 20px;border: 1px solid transparent;">
                                    <strong>Veritabanı Bağlantı Hatası!</strong><p>'.$e->getMessage().'</p>
                </div>';
			die();
		}

		return $this->pdo;
		
	}

	public function guvenlik($post)
	{
		if (is_scalar($post)) {
			return addslashes(htmlspecialchars(strip_tags($post)));
		} else {
			return $post;
		}
	
	}
	public function get_user($a,$b) {
		$query = $this->pdo->prepare("SELECT * FROM admins WHERE username = :username AND pass = :pass");
		$query->execute([
			'username' => "$a",
			'pass' => "$b"
		]);
		$veriler = $query->fetch();
		return $veriler;
	}

	public function site_setting() {
		$query = $this->pdo->prepare("SELECT * FROM settings WHERE id = :id");
		$query->execute([
			'id' => "1"
		]);
		$veriler = $query->fetch();
		return $veriler;
	}
	public function player_api($username, $password, $veri) {
		
		$url = $this->site_setting();
		define("PANEL_ADRES", $url->site_xtream);
		return PANEL_ADRES."player_api.php?username=".$username."&password=".$password."".$veri."";
	
	}
	public function get_curl($url){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
		));
		$resp = curl_exec($curl);
		curl_close($curl);
		return $resp;
	}
	public function player_api2($username, $password, $veri, $id) {
		$url = $this->site_setting();
		$now = time();
		$user_hash = sha1($username."-".$password."-");
		switch($veri) {

			case 'get_live_streams':
			$file_name = "live_streams.json";
			break;
			case 'get_live_categories':
			$file_name = "live_categories.json";
			break;
			case 'get_live_streams&category_id=':
			$file_name = "live_streams_category_$id.json";
			break;
			case 'get_simple_data_table&stream_id=':
			$file_name = "get_simple_data_table_$id.json";
			break;
			case 'get_vod_streams':
			$file_name = "get_vod_streams.json";
			break;
			case 'get_vod_streams&category_id=':
			$file_name = "get_vod_streams_$id.json";
			break;
			case 'get_vod_categories':
			$file_name = "get_vod_categories.json";
			break;
			case 'get_vod_info&vod_id=':
			$file_name = "get_vod_info_$id.json";
			break;
			case 'get_series':
			$file_name = "get_series.json";
			break;
			case 'get_series_info&series_id=':
			$file_name = "get_series_info_$id.json";
			break;
			case 'get_series_categories':
			$file_name = "get_series_categories.json";
			break;
			case 'get_series&category_id=':
			$file_name = "get_series_$id.json";
			break;

			

		}
		$dosya_yolu = "".realpath(realpath(dirname(__FILE__) . '/..'))."/cache/".$user_hash."_".$file_name."";
		if (file_exists($dosya_yolu)) {
			$write = 1;
		} else {
			$create_file = touch($dosya_yolu);
			$write = 0;
		}
			$guncelleme_suresi = 60*60;
			$time = filemtime($dosya_yolu);
			if ($time <= ($now-$guncelleme_suresi) OR $write == 0) {
				$adres = $this->get_curl($url->site_xtream."player_api.php?username=".$username."&password=".$password."&action=".$veri."".$id."");
				$save_file = fopen($dosya_yolu, "w");
				fwrite($save_file, json_encode($adres, true));
				fclose($save_file);
				$datas = file_get_contents($dosya_yolu);
			} else {
				$datas = file_get_contents($dosya_yolu);
			}
			return json_decode($datas, true);
		
	}

	public function player_epg($username, $password) {
		$url = $this->site_setting();
		$now = time();
		$user_hash = sha1($username."-".$password."-");
		$dosya_yolu = "".realpath(realpath(dirname(__FILE__) . '/..'))."/cache/".$user_hash."_epg.xml";
		if (file_exists($dosya_yolu)) {
			$write = 1;
		} else {
			$create_file = touch($dosya_yolu);
			$write = 0;
		}
		$guncelleme_suresi = 60*60;
		$time = filemtime($dosya_yolu);
			if ($time <= ($now-$guncelleme_suresi) OR $write == 0) {
				$adres = $this->get_curl($url->site_xtream."xmltv.php?username=".$username."&password=".$password."");
				file_put_contents($dosya_yolu, $adres);
				$datas = @simplexml_load_file($dosya_yolu);
			} else {
				$datas = @simplexml_load_file($dosya_yolu);
			}
			return $datas;
		
	}
	public function api($mac) {
		$url = $this->site_setting();
		define("PANEL_ADRES", $url->site_xtream);
		return PANEL_ADRES."api.php?action=stb&sub=info&portaluser=".$mac."";
	
	}

	function userInfo($prm){
        return  isset($_SESSION['user_info'])  ?  $_SESSION['user_info'][$prm]  : null;
	}


	public function get_http_response_code($url) {
		$headers = get_headers($url);
		return substr($headers[0], 9, 3);
	}

	public function get_epg_data($url, $channel) {


		$xml = simplexml_load_file($url);
		$now = time();
		$it  = new IteratorIterator($xml->programme);

		foreach ($it as $programm)
		{
		$start = strtotime($programm['start']);
		$end = strtotime($programm['end']);
		if (($channel != $programm["channel"]) AND ($end <= $now AND $start >= $now))
			exit();
		}
		return $programm->title;

	}

	public function descriptions($yazi, $limit) 
	{
		$yazi = strip_tags($yazi, '<p></p><br>');
		$explode = explode(' ',$yazi);
        $string  = '';
        $ucnokta = '...';
        if(count($explode) <= $limit){
            $ucnokta = '';
            }
        for($i=0;$i<$limit;$i++){
            $string .= $explode[$i]." ";
            }
        if ($ucnokta) {
            $string = substr($string, 0, strlen($string));
            }
        return $string.$ucnokta;
		
	}

	public function route($find)
	{
		return "?page=" . $find;
	}
	public function _curl($url, $data){
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_USERAGENT => 'Web Panel',
			CURLOPT_POST => 1,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_TIMEOUT => 3,
			CURLOPT_HTTPHEADER => array('Accept: application/json'),
			CURLOPT_POSTFIELDS => http_build_query($data),
			CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
		));
		$resp = curl_exec($curl);
		curl_close($curl);
		
		return $resp;

	}

	
	public function get_category($page)
	{
		$prm = '';
		switch ($page) {
			case "live":
				$prm= 'get_live_categories';
			break;
			case "movies":
				$prm = 'get_vod_categories';
				break;
			case "series":
				$prm = 'get_series_categories';
				break;
			case "movie_streams":
				$prm = 'get_vod_streams';
				break;
			case "series_streams":
				$prm = 'get_series';
				break;
			case "live_stream":
				$prm = 'get_live_streams';
				break;
		}

		return '&action='.$prm;
	}

	public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

	
	
}

$byakman = new ByAkman();

$siteInfo = $byakman->site_setting();


require_once(dirname(__FILE__).'/../lang/'.$siteInfo->site_lang.'.php');

if (($_SESSION["admin"]["username"] != "") AND ($_SESSION["admin"]["password"] != "")) {
$userInfo = $byakman->get_user($_SESSION["admin"]["username"], $_SESSION["admin"]["password"]);
}

?>