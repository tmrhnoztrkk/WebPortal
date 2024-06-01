<?
session_start();
if (($_SESSION["login"] != true) AND ($byakman->userInfo('username') == "" OR $byakman->userInfo('password') == "")) {
    header("Location: index.php?page=login");
    exit();
} else {
?>
<div class="main-wrapper">
<? include("app/_header.php"); ?>
<!-- banenr wrapper -->
<div class="banner-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="banner-slider owl-carousel owl-theme">
                            <?php
                            $last_movies_url = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), "get_series", "");
                            $movie_datas = json_decode($last_movies_url, true);
                            function compareOrder($a, $b)
                            {
                              return $b['added'] - $a['added'];
                            }
                            usort($movie_datas, 'compareOrder');
                            $i = 1;
                            foreach($movie_datas AS $item) {
                                $detail = $byakman->player_api2($byakman->userInfo('username'),$byakman->userInfo('password'), 'get_series_info&series_id=', $item["series_id"]);
                                $detail = json_decode($detail,true);   
                            ?>
                            <div class="owl-items">
                                <div class="banner-wrap justify-content-between align-items-center" onclick="window.location.href='index.php?page=seriesdetail&id=<?= $item["series_id"]; ?>'">
                                    <div class="left-wrap">
                                        <? if($detail["info"]["rating"] == "" AND $detail["info"]["rating"] != "0" ) {echo "";} else { ?><span class="rnd"><?= SERIES_IMDB; ?> <? echo $detail["info"]["rating"]; ?></span><? } ?>
                                        <h2 style="font-size: 2.4em;"><?= $detail["info"]["name"]; ?></h2>
                                        <? if($detail["info"]["genre"] == "") {echo "";} else { ?><span class="tag"><b><? echo $detail["info"]["genre"]; ?></b></span><? } ?>
                                        <? if($detail["info"]["releasedate"] == "") {echo "";} else { ?><span class="tag"><? $year = explode("-", $detail["info"]["releasedate"]); echo $year[0]; ?></span><? } ?>
                                        <? if(count($detail["seasons"]) == 0) {echo "";} else { ?><span class="tag"><? echo count($detail["seasons"]); ?> Sezon</span><? } ?>
                                        <? if($detail["info"]["plot"] == "") {echo "";} else { ?><p><? echo $byakman->descriptions($detail["info"]["plot"], 40); ?></p><? } ?>
                                        <p><a href="index.php?page=seriesdetail&id=<?= $item["series_id"]; ?>" class="btn btn-lg"><img src="temp/images/play.png" alt="icn"><?= SERIES_WATCH; ?></a></p>
                                    </div>
                                    <div class="right-wrap" style="background-image: url(<?= $detail["info"]["backdrop_path"][rand(0,1)]; ?>);"></div>
                                </div>
                            </div>
                            <?  if ($i++ == 5) break; } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="slide-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-left mb-4 mt-4">
                        <h2><?= SERIES_LAST; ?></h2>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="slide-slider-full owl-carousel owl-theme">
                            <?
                            $c = 1;
                            foreach($movie_datas AS $item) {
                            ?>
                            <div class="owl-items">
                                <a class="slide-one" href="index.php?page=seriesdetail&id=<?= $item["series_id"]; ?>">
                                    <div class="slide-image"><img style="height:30vh" src="<? if ($item["cover"] == "") { echo 'https://via.placeholder.com/400x800.png';} else { echo $item["cover"]; } ?>" alt="image"></div>
                                    <div class="slide-content">
                                    <div class="labelContainer"><span><h2 style="white-space: nowrap;"><?= $item["name"]; ?></h2></span></div>
                                    </div>
                                </a>
                            </div>
                           
                            <? if ($c++ == 10) break; } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider wrapper -->
        <?php
        $get_categories = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), "get_series_categories", "");
        $category_datas = json_decode($get_categories, true);
        ?>
         <!-- slider wrapper -->
         <div class="category-wrapper slide-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-left mb-4 mt-4">
                        <h2><?= SERIES_CAT; ?></h2>
                    </div>
                     
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="category-slider owl-carousel owl-theme">
                        <? foreach($category_datas AS $citem) { ?>
                            <div class="owl-items">
                                <a href="index.php?page=seriescat&id=<?= $citem["category_id"]; ?>" class="category-wrap" style="background-image: url(temp/images/gb<?= rand(1,4); ?>.png);"><span><?= $citem["category_name"]; ?></span></a>
                            </div>
                        <? } ?>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <!-- slider wrapper -->
        <? foreach($category_datas AS $citem) { ?>
        <!-- banenr wrapper -->
        <div class="slide-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-left mb-4 mt-4">
                        <h2><?= $citem["categori_id"]; ?><?= $citem["category_name"]; ?></h2>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="slide-slider-full owl-carousel owl-theme">
                            <?
                            $c = 1;
                            foreach($movie_datas AS $item) { 
                            if ($item["category_id"] != $citem["category_id"]) {

                            } else {
                            ?>
                            <div class="owl-items">
                                <a class="slide-one" href="index.php?page=seriesdetail&id=<?= $item["series_id"]; ?>">
                                    <div class="slide-image"><img style="height:30vh" src="<? if ($item["cover"] == "") { echo 'https://via.placeholder.com/400x800.png';} else { echo $item["cover"]; } ?>" alt="image"></div>
                                    <div class="slide-content">
                                    <div class="labelContainer"><span><h2 style="white-space: nowrap;"><?= $item["name"]; ?></h2></span></div>
                                    </div>
                                </a>
                            </div>
                           
                            <? if ($c++ == 10) break; } } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider wrapper -->
        <? } ?>
</div>


<? } ?>