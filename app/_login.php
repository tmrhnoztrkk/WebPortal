<?
if ($_POST) {
    session_start();
    include("../conf/functions.php");

    $type = $byakman->guvenlik($_POST["type"]);

    if ($type == 1) {

        $username = $byakman->guvenlik($_POST["username"]);
        $password = $byakman->guvenlik($_POST["password"]);
        $captcha = $_POST["captcha"];
        $remember = isset($_POST['remember']) ? 1 : 0;

        $data_url = $byakman->player_api($username, $password, "");
        $get_data = $byakman->get_http_response_code($data_url);
        if ($get_data !== "200") {
            echo 4;
        } else {
            $connect_url = file_get_contents($data_url);
            $get_url_data = json_decode($connect_url, true);
            $data_auth = $get_url_data["user_info"]["auth"];
            if ($data_auth) {

                $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                $recaptcha_secret = $siteInfo->recaptcha_secret;
                $recaptcha_response =  $captcha;
                $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
                $recaptcha = json_decode($recaptcha);
                if ($recaptcha->score >= 0.5) {
                    echo 2;
                } else {

                    if ($get_url_data["user_info"]["status"] === 'Active') {

                        if ($siteInfo->unlimited_login == 0 AND $get_url_data["user_info"]["exp_date"] == null) {
                            echo 5;
                        } else {

                        $_SESSION["login"] = true;
                        $_SESSION["user_info"] = $get_url_data["user_info"];
                        if ($remember == 1) {

                            setcookie('username',$username, time()+ 31536000);
                            setcookie('password',$password, time()+ 31536000);

                        }
                        echo 1;

                        }

                    } else {

                        echo 3;

                    }

                }
            } else {
                echo 4;
            }
        }

    } else if ($type == 2) {

        $mac = $byakman->guvenlik($_POST["mac"]);
        $captcha = $_POST["captcha"];
        $remember = isset($_POST['remember']) ? 1 : 0;

            $post_data = array( 'mac' => strtoupper($mac) );
            $opts = array( 'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query( $post_data ) ) );

            $context = stream_context_create( $opts );
            $api_result = json_decode( file_get_contents("".$siteInfo->site_xtream . "api.php?action=stb&sub=info", false, $context ), true );
            if ($api_result['result'] == 1) {
            $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_secret = $siteInfo->recaptcha_secret;
            $recaptcha_response =  $captcha;
            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
            $recaptcha = json_decode($recaptcha);
            if ($recaptcha->score >= 0.5) {
                echo 2;
            } else {

                if($api_result["result"] == "1"){
                    if ($siteInfo->unlimited_login == 0 AND $api_result["user_info"]["exp_date"] == null) {
                        echo 5;
                    } else {
                    $_SESSION['login'] = true;
                    $_SESSION['userInfo'] = $api_result['user_info'];
                    $_SESSION['mac_address'] = $mac;
                    if ($remember == 1) {

                        setcookie('username',$api_result['user_info']['username'], time()+ 31536000);
                        setcookie('password',$api_result['user_info']['password'], time()+ 31536000);
                        setcookie('mac', $api_result['mag_device']['mac']);

                    }
                    echo 1;
                    }
                } else {
                    echo 3;
                }
            }
            } else {
                echo 4;
            }


    } else {

    }
}

?>