<?

session_start();

if (($_SESSION["login"] != true) AND ($_SESSION["user_info"] == "")) {

    header("Location: index.php?page=login");

    exit();

} else {

 $post_data = array('username' => $byakman->userInfo('username'), 'password' => $byakman->userInfo('password'));

 $api_result = json_decode($byakman->_curl($siteInfo->site_xtream . "api.php?action=user&sub=info", $post_data), true);

if ($api_result['result']) {

    $bouqets = $api_result['user_info']['bouquet'];

}

?>

<div class="main-wrapper">

<? include("app/_header.php"); ?>

    <div class="page-nav">

        <div class="container">

        	<div class="row">

        		<div class="col-sm-12 text-center">

        			<h2 class="mb-1"><?= PROFILE_TITLE; ?></h2>

        			<p><?= PROFILE_DESC; ?></p>

        		</div>

        	</div>

        </div>

    </div>



    <div class="faq-page">

        <div class="container-fluid">

            <div class="row justify-content-center">

        		<div class="col-sm-8">

        			<div id="accordion" class="accordion">

			            <div class="card mb-3">

					        <div class="card-header" id="headingOne">

						        <h5 class="mb-0">

						            <button class="btn btn-link small-text collapsed pl-5 text-left" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">

						            <i class="ti-user"></i><?= PROFILE_ACCOUNT; ?> <span><?= PROFILE_ACCOUNT_TEXT; ?></span>

						            </button>

						        </h5>

						    </div>



						    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">

						        <div class="card-body form-div">

						                <div class="row">

                                            <div class="col-sm-4">

                                                <div class="form-group mt-4">

                                                    <label><?= PROFILE_USERNAME; ?></label>

                                                    <input class="form-control" style="color:#000" type="text" value="<?= $byakman->userInfo('username'); ?>" disabled>

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group mt-4">

                                                <label><?= PROFILE_PASS; ?></label>

                                                <input class="form-control" style="color:#000" type="text" value="<?= $byakman->userInfo('password'); ?>" disabled>

                                                </div>

                                            </div>

                                            <div class="col-sm-4">

                                                <div class="form-group mt-4">

                                                <label><?= PROFILE_TIME; ?></label>

                                                <input class="form-control" style="color:#000" type="text" value="<?= date("Y-m-d H:i:s", $byakman->userInfo('exp_date')); ?>" disabled>

                                                </div>

                                            </div>

                                        </div>

                               

                                        <div class="form-group button-block text-center">

                                        <button type="button" class="form-btn" style="color:#fff" data-toggle="modal" data-target="#alert_modal"><?= PROFILE_LINK; ?></button>

                                        </div>

                                </div>

						    </div>

                        </div>

						<? if ($siteInfo->password_change == 1) { ?>

						<div class="card mb-3">

					        <div class="card-header" id="headingTwo">

						        <h5 class="mb-0">

						            <button class="btn btn-link small-text collapsed pl-5 text-left" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseOne">

						            <i class="ti-lock"></i><?= PROFILE_PASS; ?> <span><?= PROFILE_PASS_TEXT; ?></span>

						            </button>

						        </h5>

						    </div>



						    <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">

						        <div class="card-body form-div">

										

										<div class="row">

                                            <div class="col-sm-6">

                                                <div class="form-group mt-4">

                                                    <label><?= PROFILE_PASS_CHANGE; ?></label>

                                                    <input class="form-control" style="color:#000" type="text" name="password_c1" id="password_c1" value="">

                                                </div>

                                            </div>

                                            <div class="col-sm-6">

                                                <div class="form-group mt-4">

                                                <label><?= PROFILE_PASS_CHANGE_2; ?></label>

                                                <input class="form-control" style="color:#000" type="text" name="password_c2" id="password_c2" value="">

                                                </div>

                                            </div>

											<div class="col-sm-12 form-group">

												<span class="colorwhite"><?= PROFILE_PASS_MESSAGE; ?></span>

											</div>

                                            <div class="col-sm-12">

                                                <div class="form-group mt-4">

												<button class="form-btn" style="color:#fff" type="button" id="change_pass" name="change_pass"><?= PROFILE_PASS_CHANGE_BUTTON; ?></button>

                                                </div>

                                            </div>

                                        </div>

                                </div>

						    </div>

                        </div>

						<? } ?>

                        <? if (isset($_SESSION["mac_address"])) { ?>

                        <div class="card mb-3">

					        <div class="card-header" id="headingThree">

						        <h5 class="mb-0">

						            <button class="btn btn-link small-text collapsed pl-5 text-left" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">

						            <i class="ti-desktop"></i><?= PROFILE_PORTAL; ?> <span> <?= PROFILE_PORTAL_DESC; ?></span>

						            </button>

						        </h5>

						    </div>



						    <div id="collapseFour" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">

						        <div class="card-body form-div">

                                    <div class="col-sm-12">

                                        <div class="form-group mt-4">

                                            <label><?= PROFILE_PORTAL; ?></label>

                                            <input class="form-control" style="color:#000" type="text" value="<?= stripslashes($siteInfo->site_portal); ?>" disabled>

                                        </div>

                                    </div>

                                </div>

						    </div>

                        </div>

						<? } ?>

						<? if ($siteInfo->bouquet_edit == 1) { ?>

                        <div class="card mb-3">

					        <div class="card-header" id="headingThree">

						        <h5 class="mb-0">

						            <button class="btn btn-link small-text collapsed pl-5 text-left" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">

						            <i class="ti-settings"></i><?= PROFILE_BOUQUET; ?> <span> <?= PROFILE_BOUQUET_DESC; ?></span>

						            </button>

						        </h5>

						    </div>



						    <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">

						        <div class="card-body form-div" id="bquet">

                                    <div class="row">

						            <?php

									$bouqet_data = $byakman->pdo->query("SELECT * FROM bouqet_list WHERE status = '1' ORDER BY sira ASC")->fetchAll();

									foreach($bouqet_data AS $bq) {

									?>

									<div class="col-md-6"><?= stripslashes($bq->bouquet_name); ?> <label class="switch"><input type="checkbox" name="bq[]" id="bq" <?= in_array($bq->bouquet_id, $bouqets) ? 'checked' : '' ?>   value="<?= $bq->bouquet_id; ?>"><span class="slider round"></span></label></div>

									<? } ?>

                                    <div class="col-md-12 mt-5"><button class="form-btn" style="color:#fff" type="button" id="change_bouquet" name="change_bouquet"><?= PROFILE_BOUQUET_SAVE; ?></button></div>

									</div>

                                </div>

						    </div>

                        </div>

						<? } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>



</div>

     <!-- Modal -->

     <div class="modal fade" id="info_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"><?= PROFILE_MODAL_TITLE; ?></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body" id="modal_info_body" style="overflow-wrap: break-word;">

            </div>

            </div>

        </div>

        </div>

     <!-- Modal -->

     <div class="modal fade" id="alert_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"><?= PROFILE_MODAL_TITLE; ?></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body" id="modal_body_text" style="overflow-wrap: break-word;">

                <?

                $co = htmlspecialchars_decode($siteInfo->iptv_links);

                $siteUrl = $siteInfo->site_xtream;

                $convert = str_replace('{api_url}',$siteUrl, $co);

                $conv = str_replace('{username}',$byakman->userInfo('username'), $convert);

                $convc = str_replace('{password}',$byakman->userInfo('password'), $conv);

                $convx = str_replace('{iptv.sh}','/etc/enigma2/iptv.sh', $convc);

                echo $convx;

                ?>

            </div>

            </div>

        </div>

        </div>

		

<? } ?>