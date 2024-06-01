<?
session_start();
if (($_SESSION["login"] != true) AND ($byakman->userInfo('username') == "" OR $byakman->userInfo('password') == "")) {
    header("Location: index.php?page=login");
    exit();
} else {
    if ($_GET) {
        $id = $byakman->guvenlik($_GET["id"]);
        if ($id != "") {
            if (is_numeric($id)) {
                $detail = $byakman->player_api2($byakman->userInfo('username'),$byakman->userInfo('password'), 'get_series_info&series_id=', $id);
                $detail = json_decode($detail,true);
?>
<div class="main-wrapper">
<? include("app/_header.php"); ?>
<!-- banenr wrapper -->
<div class="banner-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="banner-wrap justify-content-between align-items-center">
                            <div class="left-wrap">
                                <? if($detail["info"]["rating"] == "") {echo "";} else { ?><span class="rnd"><?= SERIES_IMDB; ?> <? echo $detail["info"]["rating"]; ?></span><? } ?>
                                <h2 style="font-size:2em;margin-top:10px"><?= $detail["info"]["name"]; ?></h2>
                                <? if($detail["info"]["genre"] == "") {echo "";} else { ?><span class="tag"><b><? echo $detail["info"]["genre"]; ?></b></span><? } ?>
                                <? if($detail["info"]["releaseDate"] == "") {echo "";} else { ?><span class="tag"><? $year = explode("-", $detail["info"]["releaseDate"]); echo $year[0]; ?></span><? } ?>
                                <? if(count($detail["seasons"]) < 1) {echo "";} else { ?><span class="tag"><? echo count($detail["seasons"]); ?> Sezon</span><? } ?>
                                <? if($detail["info"]["plot"] == "") {echo "";} else { ?><p><? echo $byakman->descriptions($detail["info"]["plot"], 40); ?></p><? } ?>
                               

                            </div>
                            <div class="right-wrap">
                            <div class="player" id="youtube_fragman" data-property="{videoURL:'http://youtu.be/<?= $detail["info"]["youtube_trailer"]; ?>',containment:'.right-wrap',autoPlay:true, mute:true, startAt:0, opacity:1, controls:0, rel:0, showinfo: 0}"></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- banenr wrapper -->
        <div class="container-fluid mt-5 mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="episode-box form-div">
                        <div class="episode-title"><h6><?= $detail["info"]["name"]; ?> <?= SERIES_SEASONS; ?></h6></div>
                            <div class="top-episode">
                                                    <?  $count = count($detail['episodes']);
                                                   for ($i=0;$i < $count;$i++){
                                                       ?> <a href="#">Sezon <?=$i+1?></a><?
                                                   }
                                                   ?>
                            </div>
                            <div class="episode-list mb-5">
                                <?php
                                    $count = count($detail['episodes']);
                                    for ($i=0;$i < $count; $i++){
                                ?>
                                <div class="tab_episode">
                                    <div class="row">
                                    <?php
                                    $detail['episodes'][1];
                                    foreach ($detail['episodes'][$i+1] as $item){
                                    ?>
                                        <div class="col-md-6">
                                            <a data-type="<?=$item['container_extension']?>" data-id="<?=$item['id']?>" data-toggle="modal" data-target="#alert_modal"  class="ep-list-min"><span class="circle"></span><div class="ep-title"><?=$item['title']?></div>
                                            </a>
                                        </div>
                                    <?
                                    }
                                    ?>
                                    </div>
                                </div>
                                <?
                                }
                                ?>
                            </div>
                        </div>
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
                <h5 class="modal-title"><?= $detail["info"]["name"]; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body_text">
            <div class='player-container'>
            <div id="series_view" data-src="<?= $siteInfo->site_xtream; ?>series/<?= $byakman->userInfo('username'); ?>/<?= $byakman->userInfo('password'); ?>/"></div>
            <div id="player_serie"></div>
            <video id="maat-player" class="video-js vjs-16-9" controls preload="auto"  data-setup="{}" oncontextmenu="return false;">

            </video>
            </div>
            </div>
            </div>
        </div>
        </div>
<? } } } } ?>
