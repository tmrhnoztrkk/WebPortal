<?
session_start();
if (($_SESSION["login"] != true) AND ($byakman->userInfo('username') == "" OR $byakman->userInfo('password') == "")) {
    header("Location: index.php?page=login");
    exit();
} else {
    $id = $byakman->guvenlik($_GET["id"]);
    $get_cat_info = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), "get_vod_categories", "");
    $get_cat = json_decode($get_cat_info, true);
    $key = array_search($id, array_column($get_cat, 'category_id'));

    $get_movies_cat = $byakman->player_api2($byakman->userInfo('username'), $byakman->userInfo('password'), "get_vod_streams&category_id=", $id);
    $get_movies = json_decode($get_movies_cat, true);
?>
<div class="main-wrapper">
<? include("app/_header.php"); ?>
        
        <div class="page-nav p-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="search-wrapper">
                            <h2 style="font-size:1.5em" class="mb-3"><?
                             $text = str_replace("{cat_name}",  $get_cat[$key]["category_name"], MOVIE_CATS_TEXT); $text = str_replace("{count_movie}",  count($get_movies), $text); echo $text; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- slider wrapper -->
         <div class="slide-wrapper search-wrap-slide">
            <div class="container-fluid">
                 
                <div class="row">
                    <?php
                    $i = 0;
                    $all_movies = $get_movies;
                    $page = isset($_GET['p']) ? $_GET['p'] : 1;
                    $count = count($all_movies);
                    $perPage = 30;
                    $numberOfPages = ceil($count / $perPage);
                    $offset = ($page-1) * $perPage;
                    $files = array_slice($all_movies, $offset, $perPage);
                    foreach($files AS $gm) { ?>
                    <div class="col-sm-12 col-md-2 mt-4">
                        <a class="slide-one" href="index.php?page=moviedetail&id=<?= $gm["stream_id"]; ?>">
                            <div class="slide-image"><img style="height:30vh" src="<? if ($gm["stream_icon"] == "") { echo 'https://via.placeholder.com/300x400.png';} else { echo $gm["stream_icon"]; } ?>" alt="image"></div>
                            <div class="slide-content">
                            <div class="labelContainer"><span><h2 style="white-space: nowrap;"><?= $gm["name"]; ?></h2></span></div>
                            </div>
                        </a>
                    </div>
                    <? $i++; } if($count > $perPage){ $x = 2; ?>
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example" style="margin: 30px 0 30px 0">
                            <ul class="pagination justify-content-center">
                                <?php
                                if($page > 1){	//sayfa 1 den küçük ise [Önceki] butonu oluşturulmaya uygundur	
                                    $onceki = $page-1;	//aktif sayfanın bir önceki sayfa bulunur		
                                    echo '<li class="page-item"><a class="page-link" href="index.php?page=moviecat&id='.$id.'&p='.$onceki.'">« '.MOVIE_PAGE_PREV.' </a></li>'; //link içerisine yazdırılıp [Önceki] butonu oluşturulur	  
                                }		 
                                if($page==1){ //sayfalamada 1. sayfada bulunuyorsak
                                    echo '<li class="page-item active"><a class="page-link" href="index.php?page=moviecat&id='.$id.'&p=1">1</a></li>'; //1. sayfayı menüde aktif olarak gösteriyoruz
                                }
                                else{ // bulunmuyorsak
                                    echo '<li class="page-item"><a class="page-link" href="index.php?page=moviecat&id='.$id.'&p=1">1</a></li>'; //normal olarak gözüksün, aktif olmasın	
                                }
                                //menü kısaltma işlemi
                                    //bulunduğumuz sayfa yani $sayfa = 6 olduğu durumda
                                if($page-$x > 2){ //6-2 > 2 değeri true döndürecek
                                    echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>'; //kısaltma etiketi yazdırılacak	
                                    $i = $page-$x; //$i değişkenine 4 değeri atanacak	 
                                }else { 			
                                    $i = 2; 		  
                                }
                                //$sayfa = 6 olduğu durumda = sonuc çıktısı -> 1 ...
                                
                                for($i; $i<=$page+$x; $i++) { //$i yani 4 değeri 8 değerine ulaşasıya kadar döngü çalışsın	> 4  5  6  7  8	
                                    if($i==$page){ //$i değeri bulunduğumuz sayfa ile eşitse
                                        echo '<li class="page-item active"><a class="page-link" href="index.php?page=moviecat&id='.$id.'&p='.$i.'">'.$i.'</a></li>'; // aktif olarak işaretlensin ve yazdırılsın > 4  5  [6]  7  8	
                                    }
                                    else{//değil ise
                                        echo '<li class="page-item"><a class="page-link" href="index.php?page=moviecat&id='.$id.'&p='.$i.'">'.$i.'</a></li>'; //normal olarak yazdırılsın
                                    }
                                    if($i==$numberOfPages) break;  
                                }
                                //$sayfa = 6 olduğu durumda = sonuc çıktısı -> 1 ... 4  5  [6]  7  8	
                                
                                if($page+$x < $numberOfPages-1) { //6+2<11-1 ise	
                                    echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>'; //kısaltma etiketi yazdırılacak		
                                    echo '<li class="page-item"><a class="page-link" href="index.php?page=moviecat&id='.$id.'&p='.$numberOfPages.'">'.$numberOfPages.'</a></li>'; //	son sayfa yazdırılacak	  
                                }elseif($page+$x == $numberOfPages-1) { 			
                                    echo '<li class="page-item"><a class="page-link" href="index.php?page=moviecat&id='.$id.'&p='.$numberOfPages.'">'.$numberOfPages.'</a></li>'; 		 
                                }
                                //$sayfa = 6 olduğu durumda = sonuc çıktısı -> 1 ... 4  5  [6]  7  8 ... 11	
                                //menü kısaltma işlemi
                                
                                if($page < $numberOfPages){	//bulunduğumuz sayfa hala son sayfa değil ise	  
                                    $sonraki = $page+1; //bulundğumuz sayfa değeri 1 arttırılıyor		  
                                    echo '<li class="page-item"><a class="page-link" href="index.php?page=moviecat&id='.$id.'&p='.$sonraki.'"> '.MOVIE_PAGE_NEXT.' » </a></li>'; //ve Sonraki butonu oluşturulup yazdırılıyor 		  
                                }	
                                ?>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <? } ?>
                </div>
            </div>
        </div>
</div>
<? } ?>