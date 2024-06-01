<?
ob_start();
session_start();
if (($_SESSION["admin"]["login"] != true) OR ($_SESSION["admin"]["username"] == "") OR ($_SESSION["admin"]["password"] == "")) {
    header("Location: index.php");
    exit();
} else {
include("../../conf/functions.php");

if ($_POST) {

    $jsonDurum=array("durum"=>2,"adi"=>"","boyut"=>"", "resim"=>"");
        if(isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])){
            $resimDosyaYol="../../dosyalar/mansetler/";
            $veriTurleri=array("jpg"=>"image/jpeg","png"=>"image/png", "jpeg"=>"image/jpeg");
            if(in_array($_FILES["file"]["type"],$veriTurleri)){
                if($_FILES["file"]["error"]==0){
                    $veriBoyut=($_FILES["file"]["size"]/1024);
                    $veriUzanti=array_search($_FILES["file"]["type"],$veriTurleri);
                    if($veriBoyut<3000){
    
                        $resimAdi=strtoupper(uniqid()).".".$veriUzanti;
                        $dosVeriDurum=move_uploaded_file($_FILES["file"]["tmp_name"],$resimDosyaYol.$resimAdi);
                        if($dosVeriDurum){
                            $dosyaAdres = $resimDosyaYol.$resimAdi;
                            $zaman = time();
                        }
                        $jsonDurum=array("durum"=>1,"adi"=>"$resimAdi","boyut"=>"$veriBoyut", "resim"=>"$dosyaAdres", "text"=>"");  
                    }
                   
                } else {
                    $jsonDurum=array("durum"=>2,"adi"=>"","boyut"=>"", "resim"=>"", "text"=>"Yükleme esnasında bir hata oluştu. Tekrar deneyiniz."); 
                }
            } else {
                $jsonDurum=array("durum"=>2,"adi"=>"","boyut"=>"", "resim"=>"", "text"=>"Yükleyebileceğiniz türler: jpg,jpeg,png"); 
            }
    
        } else {
            $jsonDurum=array("durum"=>2,"adi"=>"","boyut"=>"", "resim"=>"", "text"=>"Yükleme esnasında bir hata oluştu. Tekrar deneyiniz."); 
        }

}

}