<?
ob_start();
session_start();
include("conf/functions.php");
$page = $byakman->guvenlik($_GET["page"]);
if (empty($page)) {
    $page = "homepage";
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= stripslashes($siteInfo->site_title); ?></title>
	<!-- description -->
	<meta name="description" content="<?= stripslashes($siteInfo->site_desc); ?>">
    <!-- favicon -->
    
    <link rel="shortcut icon" type="image/x-icon" href="<?= stripslashes($siteInfo->site_fav); ?>">

	<!-- style -->
    <link rel="stylesheet" href="temp/css/themify-icons.css">
    <link rel="stylesheet" href="temp/css/style.css" type="text/css" media="all">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <? if ($page == "login") { ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?= $siteInfo->recaptcha_key; ?>"></script>
    <? } else if ($page == "livetv") { ?>

    <? } else if ($page == "seriesdetail") { ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.min.css">
    <link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet"/>

    <? } else if ($page == "moviedetail") { ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.min.css">
    <link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet"/>
    <link href="temp/css/jquery.mb.YTPlayer.min.css" media="all" rel="stylesheet" type="text/css">
    <? } ?>
    <link href="temp/css/jquery.typeahead.min.css" media="all" rel="stylesheet" type="text/css">
    <style>
.sticky {
  position: fixed;
  top: 0;
  width: 100%
}

/* Add some top padding to the page content to prevent sudden quick movement (as the header gets a new position at the top of the page (position:fixed and top:0) */
.sticky + .content {
  padding-top: 102px;
}
    </style>
</head>
<body class="full-wrap<?if ($siteInfo->color != "") { echo ' '.$siteInfo->color.''; } ?><? if ($siteInfo->dark_mode == 1) { echo ' theme-dark'; } else { } ?>">

	<div class="preloader"></div>
	<div class="backdrop"></div>
   
    <? 
    if (file_exists("pages/".$page.".php")) {
        include("pages/".$page.".php");
    } else {
        include("pages/homepage.php");
    }
    ?>
    
    <script src="temp/js/plugin.js"></script>
    <script src="temp/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="temp/js/scripts.js"></script>
    <? if ($page == "livetv") { ?>
<script src='temp/js/jwplayer.js'></script>
<script>jwplayer.key='YX9ZksAHC0CdTl8cek4jeU3GRXHB9oozb+kGLhITEIV4NEQe5eUmD03Kg+k=';</script>
    <? } else if ($page == "seriesdetail") { ?>

    <script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-flash@2/dist/videojs-flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>
    <script src="temp/js/jquery.mb.YTPlayer.min.js"></script>  
    <? } else if ($page == "moviedetail") { ?>
    <script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-flash@2/dist/videojs-flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>
    <script src="temp/js/jquery.mb.YTPlayer.min.js"></script>  
    <? } else if ($page == "profile") { ?>
	<? } ?>
	<script src="temp/js/jquery.typeahead.js"></script>  
    <?  if (file_exists("pages/".$page.".php")) {
        include("temp/js/pages/".$page.".php");
    } else {
        include("temp/js/pages/homepage.php");
    }
     ?>
    <script>
$.typeahead({
    input: ".fast-search",
    order: "asc",
    maxItem: false,
    group: {
        template: "{{group}}"
    },
    dropdownFilter: "<?= SEARCH_ALL; ?>",
    emptyTemplate: "<?= SEARCH_NOTFOUND; ?>",
    source: {
        "<?= HOME_LIVETV; ?>": {
            display: "name",
            href: "index.php?page=livetv&id={{id|slugify}}",
            ajax: function (query) {
                return {
                    type: "GET",
                    url: "app/_search.php",
                    path: "data.livetv",
                    data: {
                        q: "{{query}}"
                    },
                    callback: {
                        done: function (data) {
                            return data;
                        }
                    }
                }
            }
        },
        "<?= HOME_MOVIES; ?>": {
            display: "name",
            href: "index.php?page=moviedetail&id={{id|slugify}}",
            ajax: function (query) {
                return {
                    type: "GET",
                    url: "app/_search.php",
                    path: "data.movies",
                    data: {
                        q: "{{query}}"
                    },
                    callback: {
                        done: function (data) {
                            return data;
                        }
                    }
                }
            }

        },
        "<?= HOME_SERIES; ?>": {
            display: "name",
            href: "index.php?page=seriesdetail&id={{id|slugify}}",
            ajax: function (query) {
                return {
                    type: "GET",
                    url: "app/_search.php",
                    path: "data.series",
                    data: {
                        q: "{{query}}"
                    },
                    callback: {
                        done: function (data) {
                            return data;
                        }
                    }
                }
            }

        }
    }
});


    </script>
    
	</body>
</html>