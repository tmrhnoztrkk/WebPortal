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
                $detail = $byakman->player_api2($byakman->userInfo('username'),$byakman->userInfo('password'), 'get_vod_info&vod_id=', $id);
                $detail = json_decode($detail,true);
                
                $type = $detail['movie_data']['container_extension'];
                switch ($type){
                    case 'mkv':
                        $type = '.mkv';
                        break;
                    case 'mp4':
                        $type = '.mp4';
                        break;
                    case 'avi':
                        $type = '.avi';
                        break;

                }
                
                $movie_url = $siteInfo->site_xtream."movie/".$byakman->userInfo('username')."/".$byakman->userInfo('password')."/".$detail["movie_data"]["stream_id"]."".$type;
?>
<div class="main-wrapper">
<? include("app/_header.php"); ?>
<!-- banenr wrapper -->
<div class="banner-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="banner-wrap justify-content-between align-items-center ep-list-min" data-type="<?= $detail["movie_data"]["container_extension"]; ?>" data-id="<?= $detail["movie_data"]["stream_id"]; ?>" data-toggle="modal" data-target="#alert_modal">
                            <div class="left-wrap slide-content">
                                <? if($detail["info"]["rating"] == "") {echo "";} else { ?><span class="rnd"><?= MOVIE_IMDB; ?> <? echo $detail["info"]["rating"]; ?></span><? } ?>
                                <h2 style="font-size:2em;margin-top:10px"><?= $detail["movie_data"]["name"]; ?></h2>
                                <? if($detail["info"]["genre"] == "") {echo "";} else { ?><span class="tag"><b><? echo $detail["info"]["genre"]; ?></b></span><? } ?>
                                <? if($detail["info"]["releasedate"] == "") {echo "";} else { ?><span class="tag"><? $year = explode("-", $detail["info"]["releasedate"]); echo $year[0]; ?></span><? } ?>
                                <? if($detail["info"]["duration"] == "") {echo "";} else { ?><span class="tag"><? echo $detail["info"]["duration"]; ?></span><? } ?>
                                <? if($detail["info"]["plot"] == "") {echo "";} else { ?><p><? echo $byakman->descriptions($detail["info"]["plot"], 40); ?></p><? } ?>
                                <p><a class="btn btn-lg  ep-list-min" data-type="<?= $detail["movie_data"]["container_extension"]; ?>" data-id="<?= $detail["movie_data"]["stream_id"]; ?>" data-toggle="modal" data-target="#alert_modal"><img src="temp/images/play.png" alt="icn"><?= MOVIE_WATCH; ?></a></p>
                               

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

            <!-- slider wrapper -->
            <div class="slide-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-left mb-4 mt-4">
                        <h2><?= MOVIE_LIKE; ?></h2>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <div class="slide-slider-full owl-carousel owl-theme">
                            <?
                            $connect = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), "get_vod_streams", "");
                            $movie_datas = json_decode($connect, true);

                            function compareOrder($a, $b)
                            {
                                return $b['added'] - $a['added'];
                            }
                            usort($movie_datas, 'compareOrder');
                            $i = 1;
                            foreach($movie_datas AS $item) {
                                
                                if (($item["category_id"] == $detail["movie_data"]["category_id"]) AND ($item["stream_id"] != $detail["movie_data"]["stream_id"])) { ?>
                            <div class="owl-items">
                                <a class="slide-one slide-two" href="index.php?page=moviedetail&id=<?= $item["stream_id"]; ?>">
                                    <div class="slide-image" style="background-image: url(<?= $item["stream_icon"]; ?>"></div>
                                    <div class="slide-content">
                                        <h2><?= $item["name"]; ?></h2>
                                        <span class="tag"></span>
                                    </div>
                                </a>
                            </div>
                               <? $i++;  } else {
                                  
                                    
                                } if ($i == 10) break;
                             } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider wrapper -->
         
</div>
        <!-- Modal -->
        <div class="modal fade" id="alert_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $detail["movie_data"]["name"]; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body_text">
            <div class='player-container'>
            <video id="my-video" class="video-js vjs-16-9" controls data-setup="{}" oncontextmenu="return false;">
                                            <source src="<?=$movie_url?>"  type="video/mp4" codecs='"a_ac3, avc"' >
                                            <p class="vjs-no-js">
                                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                            </p>
                                        </video>
            </div>
            </div>
            </div>
        </div>
        </div>
<? } } } } ?>
