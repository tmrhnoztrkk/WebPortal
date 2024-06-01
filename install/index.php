<?php
session_start();
$page = $_GET["page"];
if (empty($page)) { $page = 1; }
if ($_SESSION["lang"] == "") { $_SESSION["lang"] = "en"; }

include("../lang/".$_SESSION["lang"].".php");
if (@filesize('../conf/config.php') > 0  AND $page < 4) {
    echo INSTALL_MESSAGE_1;
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= INSTALL_TITLE; ?></title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/themify-icons/themify-icons.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <div class="container">
            <h2><?= INSTALL_TITLE; ?></h2>
            <form method="POST" id="signup-form" class="signup-form">
					<? if ($page == 1) { ?>
                    <fieldset>
                        <legend>
                            <span class="step-heading"><?= INSTALL_LANG; ?> </span>
                            <span class="step-number"><?= INSTALL_STEP_1_4; ?></span>
                        </legend>
                        <div class="form-group">
                            <label for="first_name" class="form-label required"><?= INSTALL_LANG_TEXT; ?></label>
							<select name="site_lang" id="site_lang" class="form-control">
                                <?php
                                
                                $files = glob("../lang/*.*");
                                $files = str_replace('.php','',$files);
                                $files = str_replace('../lang/','',$files);
                                
                                foreach ($files as $file){
                                    ?>
                                    <option value="<?=$file?>"<? if ($siteInfo->site_lang == $file) { echo ' checked'; } ?>><?=strtoupper($file)?></option>
                                    <?
                                }

                                ?>
                            </select>
                        </div>
						<button type="button" onclick="lang_select();" style="float:right" class="btn btn-danger"><?= INSTALL_NEXT_BUTTON; ?></button>
                    </fieldset>
					<? } else if ($page == 2) { ?>
                    <fieldset>
                        <legend>
                            <span class="step-heading"><?= INSTALL_PANEL; ?> </span>
                            <span class="step-number"><?= INSTALL_STEP_2_4; ?></span>
                        </legend>
                        <div class="form-group">
                            <label for="email" class="form-label required"><?= INSTALL_PANEL_DNS; ?></label>
                            <input type="portal" name="portal" id="portal" />
                        </div>
						<button type="button" onclick="portal_port();" style="float:right" class="btn btn-danger"><?= INSTALL_NEXT_BUTTON; ?></button>

                    </fieldset>
					<? } else if ($page == 3) { ?>
                    <fieldset>
                        <legend>
                            <span class="step-heading"><?= INSTALL_DBS; ?> </span>
                            <span class="step-number"><?= INSTALL_STEP_3_4; ?></span>
                        </legend>
                        <div class="form-group">
                            <label for="employee_id" class="form-label required"><?= INSTALL_DBS_HOST; ?></label>
                            <input type="text" name="db_host" id="db_host" />
                        </div>

                        <div class="form-group">
                            <label for="designation" class="form-label required"><?= INSTALL_DBS_USER; ?></label>
                            <input type="text" name="db_user" id="db_user" />
                        </div>

                        <div class="form-group">
                            <label for="department" class="form-label required"><?= INSTALL_DBS_PASS; ?></label>
                            <input type="text" name="db_pass" id="db_pass" />
                        </div>

                        <div class="form-group">
                            <label for="work_hours" class="form-label required"><?= INSTALL_DBS_DATA; ?></label>
                            <input type="text" name="db_data" id="db_data" />
                        </div>
						<button type="button" onclick="database_connect();" style="float:right" class="btn btn-danger"><?= INSTALL_NEXT_BUTTON; ?></button>
                    </fieldset>
					<? } else if ($page == 4) { ?>
                    <fieldset>
                        <legend>
                            <span class="step-heading"><?= INSTALL_ADMIN;?> </span>
                            <span class="step-number"><?= INSTALL_STEP_4_4; ?></span>
                        </legend>
                        <div class="form-group">
                            <label for="bank_name" class="form-label required"><?= INSTALL_ADMIN_USERNAME; ?></label>
                            <input type="text" name="username" id="username" />
                        </div>

                        <div class="form-group">
                            <label for="holder_name" class="form-label required"><?= INSTALL_ADMIN_PASSWORD; ?></label>
                            <input type="text" name="password" id="password" />
                        </div>
						<button type="button" onclick="user_create();" style="float:right" class="btn btn-danger"><?= INSTALL_NEXT_BUTTON; ?></button>
                    </fieldset>
					<? } else if ($page == 5) { ?>
                        <fieldset>
                        <legend>
                            <span class="step-heading"><?= INSTALL_SUCCESS; ?> </span>
                            <span class="step-number"><?= INSTALL_STEP_5_4; ?></span>
                        </legend>
                        <p><?= INSTALL_SUCCESS_TEXT; ?></p>
                        <button type="hidden" id="success" onclick="install_success();" style="float:right" class="btn btn-danger"><?= INSTALL_NEXT_BUTTON; ?></button>

                    </fieldset>
					<? } ?>
                    
            </form>
        </div>

    </div>
    <div class="footer">
        
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="vendor/minimalist-picker/dobpicker.js"></script>
    <script>

function lang_select() {
	
	var lang = $("#site_lang").val();
	$.ajax({
		url: 'step.php',
		type: 'POST',
		dataType: 'json',
		data: { lang: lang, type: 1},
		success: function (gelenveri) {
			if (gelenveri == 1) {
					window.location.href="index.php?page=2";
			} else {
					window.location.href="index.php?page=1";
			}
        },
        error: function (hata) {

        }
    });

}

function portal_port() {
	var portal = $("#portal").val();
	$.ajax({
		url: 'step.php',
		type: 'POST',
		dataType: 'json',
		data: { portal: portal, type: 2},
		success: function (gelenveri) {
			if (gelenveri == 1) {
					window.location.href="index.php?page=3";
			} else {
					window.location.href="index.php?page=2";
			}
        },
        error: function (hata) {

        }
    });
}

function database_connect() {

	var host = $("#db_host").val();
	var user = $("#db_user").val();
	var pass = $("#db_pass").val();
	var data = $("#db_data").val();
	$.ajax({
		url: 'step.php',
		type: 'POST',
		dataType: 'json',
		data: { db_host: host, db_user: user, db_pass: pass, db_data: data, type: 3},
		success: function (gelenveri) {
			if (gelenveri == 1) {
					window.location.href="index.php?page=4";
			} else if ($gelenveri == 2) {
				alert("<?= INSTALL_DBS_MESSAGE_1; ?>");
			} else if ($gelenveri == 3) {
				alert("<?= INSTALL_DBS_MESSAGE_2; ?>");
			} else if ($gelenveri == 4) {
				alert("<?= INSTALL_DBS_MESSAGE_3; ?>");
			}
        },
        error: function (hata) {

        }
    });

}

function user_create() {

	var username = $("#username").val();
	var password = $("#password").val();
	$.ajax({
		url: 'step.php',
		type: 'POST',
		dataType: 'json',
		data: { username: username, password: password, type: 4},
		success: function (gelenveri) {
			if (gelenveri == 1) {
					window.location.href="index.php?page=5";
			} else if ($gelenveri == 2) {
				alert("<?= INSTALL_ADMIN_MESSAGE_1; ?>");
			} else if ($gelenveri == 3) {
				alert("<?= INSTALL_ADMIN_MESSAGE_2; ?>");
			} else if ($gelenveri == 4) {
				alert("<?= INSTALL_ADMIN_MESSAGE_3; ?>");
			}
        },
        error: function (hata) {

        }
    });

}

function install_success() {

	$.ajax({
		url: 'step.php',
		type: 'POST',
		dataType: 'json',
		data: { type: 5},
		success: function (gelenveri) {
			if (gelenveri == 1) {
				window.location.href="../panel";
			} else if (gelenveri == 2) {
				alert("<?= INSTALL_SUCCESS_ALERT_1; ?>");
				window.location.href="../panel";
			}
        },
        error: function (hata) {

        }
    });

}
</script>
<? if ($page == 5) { ?>
<script>
$("#success").click();
</script>
<? } ?>
</body>
</html>