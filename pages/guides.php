<?
session_start();
if (($_SESSION["login"] != true) AND ($_SESSION["user_info"] == "")) {
    header("Location: index.php?page=login");
    exit();
} else {
?>
<div class="main-wrapper">
<? include("app/_header.php"); ?>
<div class="page-nav" style="padding:20px">
        <div class="container-fluid">
        	<div class="row">
        		<div class="col-sm-12 text-center">
        			<h2 class="mb-1"><?= GUIDES_TITLE; ?></h2>
        			<p><?= GUIDES_DESC; ?></p>
        		</div>
        	</div>
        </div>
    </div>
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-md-4">
            <ul class="nav nav-tabs list-group search-wrapper" style="padding:10px;" id="myTab">
        <?php
                $tab_array = "";
                $quides = $byakman->pdo->query("SELECT * FROM guides WHERE status = '1' ORDER BY sira ASC")->fetchAll();

                foreach($quides AS $qui) {
                    if ($qui->is_smart == 1) {
                        $is_smart = '<form name="ssiptv" id="ssiptv" onsubmit="return false;">
                        <div class="form-group"><label>'.GUIDES_MAC.'</label><input type="text" class="form-control" name="ss_mac" id="ss_mac" placeholder="'.GUIDES_MAC.'"></div>
                        <div class="form-group"><div class="row"><div class="col-md-6"><label>'.LOGIN_USERNAME.'</label><input type="text" class="form-control" name="ss_username" id="ss_username" value="'.$byakman->userInfo('username').'" placeholder="'.$byakman->userInfo('username').'" disabled></div><div class="col-md-6"><label>'.LOGIN_PASSWORD.'</label><input type="text" class="form-control" name="ss_password" id="ss_password" value="'.$byakman->userInfo('password').'" placeholder="'.$byakman->userInfo('password').'" disabled></div></div></div>
                        <div class="form-group"><label>'.GUIDES_PIN.'</label><input type="text" class="form-control" name="ss_pin" id="ss_pin" placeholder="'.GUIDES_PIN.'"></div>
                        <input type="hidden" class="form-control" name="ss_url" id="ss_url" value="'.$siteInfo->site_xtream.'get.php?username='.$byakman->userInfo('username').'&password='.$byakman->userInfo('password').'&type=m3u_plus&output=ts" placeholder="'.GUIDES_URL.' URL" disabled>
                        <div class="form-group"><button onclick="ssiptv_upload();" class="btn btn-block btn-primary">'.GUIDES_SAVE.'</button></div></form>';
                    } else if ($qui->is_smart == 2) {
                        $is_smart = '<form name="royaliptv" id="royaliptv" onsubmit="return false;">
                        <div class="form-group"><label>'.GUIDES_MAC.'</label><input type="text" class="form-control" name="ry_mac" id="ry_mac" placeholder="'.GUIDES_MAC.'"></div>
                        <div class="form-group"><div class="row"><div class="col-md-6"><label>'.LOGIN_USERNAME.'</label><input type="text" class="form-control" name="ry_username" id="ry_username" value="'.$byakman->userInfo('username').'" placeholder="'.$byakman->userInfo('username').'" disabled></div><div class="col-md-6"><label>'.LOGIN_PASSWORD.'</label><input type="text" class="form-control" name="ry_password" id="ry_password" value="'.$byakman->userInfo('password').'" placeholder="'.$byakman->userInfo('password').'" disabled></div></div></div>
                        <input type="hidden" class="form-control" name="ry_url" id="ry_url" value="'.$siteInfo->site_xtream.'get.php?username='.$byakman->userInfo('username').'&password='.$byakman->userInfo('password').'&type=m3u_plus&output=ts" placeholder="'.GUIDES_URL.'" disabled>
                        <div class="form-group"><button onclick="royaliptv_upload();" class="btn btn-block btn-primary">'.GUIDES_SAVE.'</button></div></form>';
                    } else {
                        $is_smart = '';
                    }
                echo'<li class="nav-item">
                    <a href="#tabs'.stripslashes($qui->id).'" class="nav-link list-group-item'.$tag.'" data-toggle="tab">'.stripslashes($qui->guide_name).'</a>
                </li>';
                $tab_array .= '<div class="tab-pane '.$tag2.' fade" id="tabs'.stripslashes($qui->id).'">
                <p>'.$qui->guide_desc.'</p>
                '.$is_smart.'
            </div>';
        }
        ?>
            </ul>
        </div>
        <div class="col-md-8">
        <div class="tab-content search-wrapper" style="padding:10px;">
                <?= $tab_array; ?>
            </div>
    </div>
    </div>
</div>
</div>
     <!-- Modal -->
     <div class="modal fade" id="alert_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= GUIDES_MODAL_TITLE; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body_text" style="overflow-wrap: break-word;">
            </div>
            </div>
        </div>
        </div>
<? } ?>