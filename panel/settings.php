<?
ob_start();
session_start();
if (($_SESSION["admin"]["login"] != true) OR ($_SESSION["admin"]["username"] == "") OR ($_SESSION["admin"]["password"] == "")) {
    header("Location: index.php");
    exit();
}
include("../conf/functions.php");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $siteInfo->site_title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

  <? include("_header.php"); ?>
  <? include("_menu.php"); ?>
     
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= PANEL_SETTINGS_TITLE; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php"><?= PANEL_HOMEPAGE; ?></a></li>
              <li class="breadcrumb-item active"><?= PANEL_SETTINGS_TITLE; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
      <div class="col-12">
          <?
          if ($_POST) {
            $site_title = $byakman->guvenlik($_POST["site_title"]);
            $site_desc = $byakman->guvenlik($_POST["site_desc"]);
            $site_xtream = $byakman->guvenlik($_POST["site_xtream"]);
            $site_portal = $byakman->guvenlik($_POST["site_portal"]);
            $site_lang = $byakman->guvenlik($_POST["site_lang"]);
            $mag_login = $byakman->guvenlik($_POST["mag_login"]);
            if(isset($mag_login)) { $mag_login = 1; } else { $mag_login = 0; }
            $cat_edit = $byakman->guvenlik($_POST["cat_edit"]);
            if(isset($cat_edit)) { $cat_edit = 1; } else { $cat_edit = 0; }
            $un_login = $byakman->guvenlik($_POST["un_login"]);
            if(isset($un_login)) { $un_login = 1; } else { $un_login = 0; }
            $pass_change = $byakman->guvenlik($_POST["pass_change"]);
            if(isset($pass_change)) { $pass_change = 1; } else { $pass_change = 0; }						$recaptcha = $byakman->guvenlik($_POST["recaptcha"]);						if(isset($recaptcha)) { $recaptcha = 1; } else { $recaptcha = 0; }
            $iptv_links = $_POST["iptv_links"];
            $recaptcha_key = $byakman->guvenlik($_POST["recaptcha_key"]);
            $recaptcha_secret = $byakman->guvenlik($_POST["recaptcha_secret"]);

            $resimDosyaYol = "../files/";
            if($_FILES['logo']['size'] != 0) {
              $veriTurleri=array("jpg"=>"image/jpeg","png"=>"image/png", "jpeg"=>"image/jpeg");
              if(in_array($_FILES["logo"]["type"],$veriTurleri)){
                if($_FILES["logo"]["error"]==0){
                    $veriBoyut=($_FILES["logo"]["size"]/1024);
                    $veriUzanti=array_search($_FILES["logo"]["type"],$veriTurleri);
                    if($veriBoyut<3000){
    
                        $resimAdi=strtoupper(uniqid()).".".$veriUzanti;
                        $dosVeriDurum=move_uploaded_file($_FILES["logo"]["tmp_name"],$resimDosyaYol.$resimAdi);
                        if($dosVeriDurum){
                            $logo_adresi = $resimAdi;
                        }
                    }  
                  }
                } 
             } else {
               $logo_adresi = $siteInfo->site_logo;
             }


             if($_FILES['fav']['size'] != 0) {
              $veriTurleri=array("jpg"=>"image/jpeg","png"=>"image/png", "jpeg"=>"image/jpeg");
              if(in_array($_FILES["fav"]["type"],$veriTurleri)){
                if($_FILES["fav"]["error"]==0){
                    $veriBoyut=($_FILES["fav"]["size"]/1024);
                    $veriUzanti=array_search($_FILES["fav"]["type"],$veriTurleri);
                    if($veriBoyut<3000){
    
                        $resimAdi=strtoupper(uniqid()).".".$veriUzanti;
                        $dosVeriDurum=move_uploaded_file($_FILES["fav"]["tmp_name"],$resimDosyaYol.$resimAdi);
                        if($dosVeriDurum){
                            $fav_adresi = $resimAdi;
                        }
                    }  
                  }
                } 
             } else {
               $fav_adresi = $siteInfo->site_fav;
             }
           $update = $byakman->pdo->prepare("UPDATE settings SET
           site_title = :site_title,
           site_desc = :site_desc,
           site_xtream = :site_xtream,
           site_portal = :site_portal,
           site_lang = :site_lang,
           iptv_links = :iptv_links,
           site_logo = :site_logo,
           site_fav = :site_fav,
           mag_login = :mag_login,
           bouquet_edit = :bouquet_edit,
           unlimited_login = :unlimited_login,
           password_change = :password_change,		              recaptcha = :recaptcha,
           recaptcha_key = :recaptcha_key,
           recaptcha_secret = :recaptcha_secret WHERE id = '1'");
           $update->bindParam(":site_title", $site_title);
           $update->bindParam(":site_desc", $site_desc);
           $update->bindParam(":site_xtream", $site_xtream);
           $update->bindParam(":site_portal", $site_portal);
           $update->bindParam(":site_lang", $site_lang);
           $update->bindParam(":iptv_links", $iptv_links);
           $update->bindParam(":site_logo", $logo_adresi);
           $update->bindParam(":site_fav", $fav_adresi);
           $update->bindParam(":mag_login", $mag_login);
           $update->bindParam(":bouquet_edit", $cat_edit);
           $update->bindParam(":unlimited_login", $un_login);
           $update->bindParam(":password_change", $pass_change);		              $update->bindParam(":recaptcha", $recaptcha);
           $update->bindParam(":recaptcha_key", $recaptcha_key);
           $update->bindParam(":recaptcha_secret", $recaptcha_secret);
           $update->execute();
           if ($update) {
               $mesaj = '<div class="alert alert-success alert-dismissible">
               <h5><i class="icon fas fa-check"></i> '.PANEL_ALERT_TITLE_2.'</h5>
               '.PANEL_SETTINGS_MESSAGE_1.'
             </div>';
			 header("REFRESH:1; url=settings.php");
           } else {
               $mesaj = '<div class="alert alert-danger alert-dismissible">
               <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
               '.PANEL_SETTINGS_MESSAGE_2.'
             </div>';
           }
          } 
          echo $mesaj;
          ?>
          <form name="settings" id="settings" method="POST" enctype="multipart/form-data">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><?= PANEL_SETTINGS_TAB1; ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><?= PANEL_SETTINGS_TAB2; ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><?= PANEL_SETTINGS_TAB3; ?></a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                  <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_SETTINGS_TITLE; ?></label>
                        <input type="text" class="form-control" name="site_title" id="site_title" value="<?= $siteInfo->site_title; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_SETTINGS_DESC; ?></label>
                        <input type="text" class="form-control" name="site_desc" id="site_desc" value="<?= $siteInfo->site_desc; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_SETTINGS_XTREAM; ?></label>
                        <input type="text" class="form-control" name="site_xtream" id="site_xtream" value="<?= $siteInfo->site_xtream; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_SETTINGS_PORTAL; ?></label>
                        <input type="text" class="form-control" name="site_portal" id="site_portal" value="<?= $siteInfo->site_portal; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_SETTINGS_LANG; ?></label>
                        <select name="site_lang" class="form-control" id="">
                                <?php
                                
                                $files = glob("../lang/*.*");
                                $files = str_replace('.php','',$files);
                                $files = str_replace('../lang/','',$files);
                                
                                foreach ($files as $file){
                                    ?>
                                    <option value="<?=$file?>"<? if ($siteInfo->site_lang == $file) { echo ' selected'; } ?>><?=strtoupper($file)?></option>
                                    <?
                                }

                                ?>
                            </select>
                    </div>
                  
                    <div class="row">
                        <div class="col-md-6">
                    <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                      <label><?= PANEL_SETTINGS_LOGO; ?></label>
                        <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <?= PANEL_SETTINGS_FILE; ?> <input type="file" name="logo" id="logo" style="display: none;" multiple>
                        </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                        </div>
                      <input type="hidden" name="logo_gorsel" id="logo_gorsel" value="<? if ($siteInfo->site_logo != "") { echo ''.stripslashes($siteInfo->site_logo).''; } else { } ?>" />

                      </div>
                      <div class="col-md-6">
                        <div id="sonuc"></div>
                        <? if ($siteInfo->site_logo != "" AND file_exists("../files/".$siteInfo->site_logo."")) {
                        $filesize = filesize("../files/".stripslashes($siteInfo->site_logo).""); ?>
                        <ul id="idbuyuk" class="mailbox-attachments clearfix"><li><span class="mailbox-attachment-icon has-img"><img src="../files/<?= stripslashes($siteInfo->site_logo); ?>" alt="Attachment"></span><div class="mailbox-attachment-info"><a href="#" class="mailbox-attachment-name"><?= stripslashes($siteInfo->site_logo); ?></a><span class="mailbox-attachment-size"><?= $byakman->formatSizeUnits($filesize); ?></span></div></li></ul>
                      <? } ?> 
                      </div>
                      </div>   
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                      <label><?= PANEL_SETTINGS_FAV; ?></label>
                        <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary">
                        <?= PANEL_SETTINGS_FILE; ?> <input type="file" name="fav" id="fav" style="display: none;" multiple>
                        </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                        </div>
                      <input type="hidden" name="favicon_gorsel" id="favicon_gorsel" value="<? if ($siteInfo->site_fav != "") { echo ''.stripslashes($siteInfo->site_fav).''; } else { } ?>" />
                      </div>
                      <div class="col-md-6">
                        <div id="sonuc"></div>
                        <? if ($siteInfo->site_fav != "" AND file_exists("../files/".$siteInfo->site_fav."")) {
                        $filesize = filesize("../files/".stripslashes($siteInfo->site_fav).""); ?>
                        <ul id="idbuyuk" class="mailbox-attachments clearfix"><li><span class="mailbox-attachment-icon has-img"><img src="../files/<?= stripslashes($siteInfo->site_fav); ?>" alt="Attachment"></span><div class="mailbox-attachment-info"><a href="#" class="mailbox-attachment-name"><?= stripslashes($siteInfo->site_fav); ?></a><span class="mailbox-attachment-size"><?= $byakman->formatSizeUnits($filesize); ?><a onclick="resim_sil('<?= stripslashes($siteInfo->site_fav); ?>');" class="btn btn-default btn-xs pull-right"><i class="fa fa-trash"></i></a></span></div></li></ul>
                      <? } ?> 
                      </div>
                      </div>   
                    </div>
                    </div>
                    </div>
                    <div class="form-group">
                    <label><?= PANEL_SETTINGS_OTHER; ?></label>
                       <div class="row">
                           <div class="col-md-3">
                           <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" name="mag_login" class="custom-control-input" id="customSwitch1"<? if ($siteInfo->mag_login == 1) {echo ' checked'; }?>>
                            <label class="custom-control-label" for="customSwitch1"><?= PANEL_SETTINGS_MAG; ?></label>
                          </div>
                            </div>
                            <div class="col-md-3">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" name="cat_edit" class="custom-control-input" id="customSwitch2"<? if ($siteInfo->bouquet_edit == 1) {echo ' checked'; }?>>
                      <label class="custom-control-label" for="customSwitch2"><?= PANEL_SETTINGS_CATEGORY; ?></label>
                    </div>
                            </div>
                            <div class="col-md-3">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" name="un_login" class="custom-control-input" id="customSwitch3"<? if ($siteInfo->unlimited_login == 1) {echo ' checked'; }?>>
                      <label class="custom-control-label" for="customSwitch3"><?= PANEL_SETTINGS_UNLOGIN; ?></label>
                    </div>
                            </div>
                            <div class="col-md-3">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" name="pass_change" class="custom-control-input" id="customSwitch4"<? if ($siteInfo->password_change == 1) {echo ' checked'; }?>>
                      <label class="custom-control-label" for="customSwitch4"><?= PANEL_SETTINGS_CHANGEPASS; ?></label>
                    </div>
                            </div>														<div class="col-md-3">                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">                      <input type="checkbox" name="recaptcha" class="custom-control-input" id="customSwitch5"<? if ($siteInfo->recaptcha == 1) {echo ' checked'; }?>>                      <label class="custom-control-label" for="customSwitch5"><?= PANEL_SETTINGS_RECAPTHCA; ?></label>                    </div>                            </div>
                    </div>
                </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <div class="form-group">
                        <label><?= PANEL_GUIDES_DESC;?></label>
                        <textarea name="iptv_links" id="iptv_links"><?= stripslashes($siteInfo->iptv_links); ?></textarea>
                      <div class="col-md-12 mt-3">
                       <label style="color: #3e3d3d;">
                           <span class="d-block mb-2">{api_url} </span>
                           <span class="d-block mb-2">{username}</span>
                           <span class="d-block mb-2">{password}</span>
                           <span class="d-block mb-2">{mac}</span>
                           <span class="d-block mb-2">{enigma1.6}</span>
                           <span class="d-block mb-2">{enigma2.0}</span>
                           <span class="d-block">{octagon}</span>
                       </label>
                   </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                  <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_SETTINGS_RECAPTCHA_1; ?></label>
                        <input type="text" class="form-control" name="recaptcha_key" id="recaptcha_key" value="<?= $siteInfo->recaptcha_key; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_SETTINGS_RECAPTCHA_2; ?></label>
                        <input type="text" class="form-control" name="recaptcha_secret" id="recaptcha_secret" value="<?= $siteInfo->recaptcha_secret; ?>" />
                    </div> 
                  </div>
                </div>
                <div class="card-footer">
                <input type="submit" name="guide_ayar" id="guide_ayar" class="btn btn-primary" style="float:right" value="<?= PANEL_GUIDES_SAVE;?>" />
                </div>
              </div>
             
              <!-- /.card -->
            </div>
            </form>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<? include("_footer.php"); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="plugins/ckeditor/ckeditor.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<script>

  CKEDITOR.replace( 'iptv_links' );

$('#myTab a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})
// We can attach the `fileselect` event to all file inputs on the page
$(document).on('change', ':file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});
// We can watch for our custom `fileselect` event like this
$(document).ready( function() {
    $(':file').on('fileselect', function(event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }

    });
});
      $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
</body>
</html>
