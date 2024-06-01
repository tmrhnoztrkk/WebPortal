<?
session_start();
if (($_SESSION["login"] != true) AND ($_SESSION["user_info"] == "")) {
    header("Location: index.php?page=login");
    exit();
} else {
?>
<div class="main-wrapper">
<? include("app/_header.php"); ?>
    <div class="faq-page" style="margin:20px 0 20px 0">
        <div class="container-fluid">
        	<div class="row justify-content-center">
                <div class="hidden-md-up col-sm-12 order-xs-1 order-sm-1">
                    <button type="button" class="btn collapse-bg" style="float:right; margin-bottom: 5px" onclick="open_live_menu();"><?= LIVETV_CHANNEL_LIST; ?></button>

                    <div id="mySidenav" class="sidenav">
                    <div id="fixed_header" style="display:none;">
                    <button type="button" id="close_button" class="btn collapse-bg" style="float:right; margin-bottom: 5px; margin-right:10px" onclick="close_live_menu();"><?= LIVETV_CLOSE; ?></button>
                        <div style="padding:10px">
                        <select class="form-control" name="live_cat2" id="live_cat2">
                        <?php
                            $list_bouqet = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), 'get_live_categories', '');
                            $getCategory = json_decode($list_bouqet, true);
                            foreach($getCategory AS $gc) {
                                echo '<option value="'.$gc["category_id"].'">'.$gc["category_name"].'</option>';
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                        <ul  id="live_box2" style="display:none;padding:10px; overflow-y: scroll; height: 100%" class="list-group mobile"></ul>
                    </div>

                </div>

                
                
        		<div class="hidden-sm-down col-md-6 order-xs-2 order-sm-2">
                    <div class="form-div">
                        <div class="form-group">
                        <select class="form-control" name="live_cat" id="live_cat" style="height:40px">
                            <? $getCategory = json_decode($list_bouqet, true);
                            foreach($getCategory AS $gc) {
                                echo '<option value="'.$gc["category_id"].'">'.$gc["category_name"].'</option>';
                            } ?>
                        </select>
                        </div>
                        <ul class="list-group desktop" id="live_box"></ul>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 order-xs-2 order-sm-2">
                    
                    <div class="row">
                    <div class="form-div">
                        <div class="col-md-12">
                            <div id="myElement"></div>
                            <div id="debug" ></div>
                        </div>
                    </div>
                    <div class="form-div" style="margin-top:10px">
                        <div class="col-md-12" style="padding:0px">
                            <div class="panel panel-default" style="padding:0px">
                                <div class="panel-heading"><?= LIVETV_EPG_LIST; ?></div>
                                <div class="panel-body" id="epg_list"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<? } ?>