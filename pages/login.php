        <!-- header wrapper -->
        <div class="header-wrapper mt-5" style="padding:0px">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a href="index.php" class="logo float-none"><img src="files/<?= $siteInfo->site_logo; ?>" /></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- header wrapper -->

        <section class="form-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="form-div text-center" id="myGroup">
                            <h2><?= LOGIN_TITLE; ?></h2>
                            <p><?= LOGIN_TEXT; ?></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" style="width:50%">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?= LOGIN_USER; ?></a>
                            </li>
							<? if ($siteInfo->mag_login == 1) { ?>
                            <li class="nav-item" style="width:50%">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?= LOGIN_MAG; ?></a>
                            </li>
							<? } ?>
                            </ul>
                            <? 
                            if ($_POST["login"]) {
                                        $username = $byakman->guvenlik($_POST["username"]);
                                        $sifre = $byakman->guvenlik($_POST["sifre"]);
                                        $mac = $byakman->guvenlik($_POST["mac"]);
                                        $beni_hatirla = $byakman->guvenlik($_POST["beni_hatirla"]);
                                        $recaptcha_secret = $siteInfo->recaptcha_secret;
                                        $recaptcha_response = $_POST['recaptcha_response'];
                                        if (empty($username) || empty($sifre)) {
                                            if (empty($mac)) {
                                                echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
                                                '.LOGIN_ALERT_7.'
                                              </div>';
                                            } else {
												if ($siteInfo->recaptcha == 1) {
												
													// call curl to POST request
													$ch = curl_init();
													curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
													curl_setopt($ch, CURLOPT_POST, 1);
													curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $recaptcha_secret, 'response' => $recaptcha_response)));
													curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
													$response = curl_exec($ch);
													curl_close($ch);
													$arrResponse = json_decode($response, true);
													if ($arrResponse["score"] >= 0.5) {
														$post_data = array( 'mac' => strtoupper($mac) );
														$api_result = json_decode($byakman->_curl($siteInfo->site_xtream . "api.php?action=stb&sub=info", $post_data), true);
														if ($api_result["error"] != "NOT EXISTS") {
														if($api_result["result"] == "1"){
															if ($siteInfo->unlimited_login == 0 AND $api_result["user_info"]["exp_date"] == null) {
															   echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
															   '.LOGIN_ALERT_8.'
															 </div>';
															} else {
															$_SESSION['login'] = true;
															$_SESSION['user_info'] = $api_result['user_info'];
															$_SESSION['mac_address'] = $mac;
															if ($remember == 1) {
										
																setcookie('username',$api_result['user_info']['username'], time()+ 31536000);
																setcookie('password',$api_result['user_info']['password'], time()+ 31536000);
																setcookie('mac', $api_result['mag_device']['mac']);
										
															}
															echo '<div style="margin-top: 10px" class="alert alert-success" role="alert">
															'.LOGIN_ALERT_3.'
														  </div>';
														  header("Refresh: 2; URL=index.php?page=homepage");
															}
														} else {
															echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
															'.LOGIN_ALERT_5.'
														  </div>';
														}
														} else {
															echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
															'.LOGIN_ALERT_6.'
														  </div>';
														}
													} else {
														echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
															'.LOGIN_ALERT_4.'
														  </div>';
													}
												
												} else {
													
													$post_data = array( 'mac' => strtoupper($mac) );
													$api_result = json_decode($byakman->_curl($siteInfo->site_xtream . "api.php?action=stb&sub=info", $post_data), true);
													if ($api_result["error"] != "NOT EXISTS") {
													if($api_result["result"] == "1"){
														if ($siteInfo->unlimited_login == 0 AND $api_result["user_info"]["exp_date"] == null) {
														   echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
														   '.LOGIN_ALERT_8.'
														 </div>';
														} else {
														$_SESSION['login'] = true;
														$_SESSION['user_info'] = $api_result['user_info'];
														$_SESSION['mac_address'] = $mac;
														if ($remember == 1) {
										
																setcookie('username',$api_result['user_info']['username'], time()+ 31536000);
																setcookie('password',$api_result['user_info']['password'], time()+ 31536000);
																setcookie('mac', $api_result['mag_device']['mac']);
										
														}
														echo '<div style="margin-top: 10px" class="alert alert-success" role="alert">
														'.LOGIN_ALERT_3.'
														</div>';
														header("Refresh: 2; URL=index.php?page=homepage");
														}
													} else {
														echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
														'.LOGIN_ALERT_5.'
														</div>';
													}
													} else {
														echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
														'.LOGIN_ALERT_6.'
														  </div>';
													}
													
												}
                                            
                                            }

                                        } else {
                                            if ($username == "") {
                                                echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
                                                '.LOGIN_ALERT_1.'
                                              </div>';
                                            } else if ($sifre == "") {
                                                echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
                                                '.LOGIN_ALERT_2.'
                                              </div>';
                                            } else {
												
												if ($siteInfo->recaptcha == 1) {
												
													 // call curl to POST request
													 $ch = curl_init();
													 curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
													 curl_setopt($ch, CURLOPT_POST, 1);
													 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $recaptcha_secret, 'response' => $recaptcha_response)));
													 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
													 $response = curl_exec($ch);
													 curl_close($ch);
													 $arrResponse = json_decode($response, true);
													 if ($arrResponse["score"] >= 0.5) {

														$post_data = array( 'username' => $username, 'password' => $sifre );
														$api_result = json_decode($byakman->get_curl($siteInfo->site_xtream . "player_api.php?username=".$username."&password=".$sifre.""), true);
														
															if ($api_result["user_info"]["status"] === 'Active') {

																if ($siteInfo->unlimited_login == 0 AND $api_result["user_info"]["exp_date"] == null) {
																	echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
																	'.LOGIN_ALERT_8.'
																  </div>';
																} else {

																	$_SESSION["login"] = true;
																	$_SESSION["user_info"] = $api_result["user_info"];
																	if ($remember == 1) {
											
																		setcookie('username',$username, time()+ 31536000);
																		setcookie('password',$password, time()+ 31536000);
											
																	}
																	echo '<div style="margin-top: 10px" class="alert alert-success" role="alert">
																	'.LOGIN_ALERT_3.'
																  </div>';
																  header("Refresh: 2; URL=index.php?page=homepage");
																}
														} else {
															echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
																'.LOGIN_ALERT_6.'
															  </div>';
														}
														} else {
															echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
															'.LOGIN_ALERT_4.'
														  </div>';
														}
												
												} else {
													
														$post_data = array( 'username' => $username, 'password' => $sifre );
														$api_result = json_decode($byakman->get_curl($siteInfo->site_xtream . "player_api.php?username=".$username."&password=".$sifre.""),true);
														if ($api_result["user_info"]["status"] === 'Active') {

																if ($siteInfo->unlimited_login == 0 AND $api_result["user_info"]["exp_date"] == null) {
																	echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
																	'.LOGIN_ALERT_8.'
																  </div>';
																} else {

																	$_SESSION["login"] = true;
																	$_SESSION["user_info"] = $api_result["user_info"];
																	if ($remember == 1) {
											
																		setcookie('username',$username, time()+ 31536000);
																		setcookie('password',$password, time()+ 31536000);
											
																	}
																	echo '<div style="margin-top: 10px" class="alert alert-success" role="alert">
																	'.LOGIN_ALERT_3.'
																  </div>';
																  header("Refresh: 2; URL=index.php?page=homepage");
																}
														} else {
															echo '<div style="margin-top: 10px" class="alert alert-danger" role="alert">
																'.LOGIN_ALERT_6.'
															  </div>';
														}
													
												}
												
                                            
                                            }

                                        }
                                        // Login Mac

                                    }
                                    ?>
                            <form name="login_form" id="login_form" method="POST">
                           
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                   
                                        <div class="form-group mt-4">
                                            <input class="form-control" type="text" style="color:#000" placeholder="<?= LOGIN_USERNAME; ?>" name="username" id="username">
                                            <input class="form-control" type="password" style="color:#000"  placeholder="<?= LOGIN_PASSWORD; ?>" name="sifre" id="sifre">
                                        </div>
                                </div>
								<? if ($siteInfo->mag_login == 1) { ?>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="form-group mt-4">
                                            <input class="form-control" type="text" style="color:#000"  placeholder="<?= LOGIN_MAG_ADRESS; ?>" name="mac" id="mac">
                                        </div>
                                </div>
								<? } ?>
                                
                                <div class="form-group form-check-label">
                                            <input type="checkbox" id="beni_hatirla" name="beni_hatirla" checked=""> <?= LOGIN_REMEMBER; ?>
                                        </div>
                                        
                                <div class="form-group button-block text-center">
                                            <input type="hidden" name="recaptcha_response" id="recaptcha_response" value="">
                                            <input type="submit" class="form-btn" id="login" name="login" value="<?= LOGIN_BUTTON; ?>" />
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="alert_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= LOGIN_MODAL_TITLE; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body_text">
                ...
            </div>
            </div>
        </div>
        </div>