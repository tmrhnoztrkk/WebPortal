<?
session_start();
if (($_SESSION["login"] != true) AND ($_SESSION["user_info"] == "")) {
    header("Location: index.php?page=login");
    exit();
} else {
?>
<div class="main-wrapper">
<? include("app/_header.php"); ?>
<div class="container-fluid" style="margin-top: 5vh">
    <div class="row">
        <div class="col-md-4">
            <div class="page-nav">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <div class="search-wrapper"  style="cursor:pointer" onclick="window.location.href='<?=$byakman->route('livetv')?>';">
                                <a href="<?=$byakman->route('livetv')?>">
                                    <i class="ti-desktop" style="font-size: 5em; color: #000"></i>
                                    <p><span class="d-block" style="font-size: 2em; font-weight:bold;margin-top: 10px"><?= HOME_LIVETV; ?></span></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="page-nav">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="search-wrapper"  style="cursor:pointer" onclick="window.location.href='<?=$byakman->route('movies')?>';">
                                    <a href="<?=$byakman->route('movies')?>">
                                        <i class="ti-video-clapper" style="font-size: 5em; color: #000"></i>
                                        <p><span class="d-block" style="font-size: 2em; font-weight:bold;margin-top: 10px"><?= HOME_MOVIES; ?></span></a>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-md-4">
            <div class="page-nav">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="search-wrapper"  style="cursor:pointer" onclick="window.location.href='<?=$byakman->route('series')?>';">
                                    <a href="<?=$byakman->route('series')?>">
                                        <i class="ti-control-forward" style="font-size: 5em; color: #000"></i>
                                        <p><span class="d-block" style="font-size: 2em; font-weight:bold;margin-top: 10px"><?= HOME_SERIES; ?></span></a>
                                    </a>
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