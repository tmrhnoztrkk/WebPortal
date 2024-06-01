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
            <h1 class="m-0 text-dark"><?= PANEL_THEMES_TITLE; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php"><?= PANEL_HOMEPAGE; ?></a></li>
              <li class="breadcrumb-item active"><?= PANEL_THEMES_TITLE; ?></li>
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
            $dark_mode = $byakman->guvenlik($_POST["dark_mode"]);
            $color = $byakman->guvenlik($_POST["color"]);
           $update = $byakman->pdo->prepare("UPDATE settings SET
           dark_mode = :dark_mode,
           color = :color
           WHERE id = '1'");
           $update->bindParam(":dark_mode", $dark_mode);
           $update->bindParam(":color", $color);
           $update->execute();
           if ($update) {
               $mesaj = '<div class="alert alert-success alert-dismissible">
               <h5><i class="icon fas fa-check"></i> '.PANEL_ALERT_TITLE_2.'</h5>
               '.PANEL_SETTINGS_MESSAGE_1.'
             </div>';
			 header("REFRESH:1; url=themes.php");
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
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><?= PANEL_THEMES_TAB1; ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><?= PANEL_THEMES_TAB2; ?></a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
					<div class="form-group">
					<label><?= PANEL_THEMES_TAB1; ?></label>
					<div class="row">
						<div class="col-md-6" align="center">
							<div class="form-group">
								<div class="custom-control custom-radio">
								  <input class="custom-control-input" type="radio" id="customRadio1" name="dark_mode" value="1"<? if ($siteInfo->dark_mode == 1) { echo ' checked'; } ?>>
								  <label for="customRadio1" class="custom-control-label"><?= PANEL_THEMES_DARK_MODE; ?></label>
								</div>
							</div>
							<img class="img-responsive img-thumbnail" src="dist/img/dark.jpg" >
						</div>
						<div class="col-md-6" align="center">
							<div class="form-group">
								<div class="custom-control custom-radio">
								  <input class="custom-control-input" type="radio" id="customRadio2" name="dark_mode" value="0"<? if ($siteInfo->dark_mode == 0) { echo ' checked'; } ?>>
								  <label for="customRadio2" class="custom-control-label"><?= PANEL_THEMES_LIGHT_MODE; ?></label>
								</div>
							</div>
							<img class="img-responsive img-thumbnail" src="dist/img/light.jpg" >
						</div>
					</div>
                </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
				  <div class="form-group">
					<label><?= PANEL_THEMES_TAB2; ?></label>
					<select class="form-control" name="color" id="color">
					<option value=""><?= PANEL_THEMES_COLOR1; ?></option>
					<option value="color-theme-red"<? if ($siteInfo->color == "color-theme-red") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR2; ?></option>
					<option value="color-theme-green"<? if ($siteInfo->color == "color-theme-green") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR3; ?></option>
					<option value="color-theme-blue"<? if ($siteInfo->color == "color-theme-blue") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR4; ?></option>
					<option value="color-theme-pink"<? if ($siteInfo->color == "color-theme-pink") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR5; ?></option>
					<option value="color-theme-yellow"<? if ($siteInfo->color == "color-theme-yellow") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR6; ?></option>
					<option value="color-theme-orange"<? if ($siteInfo->color == "color-theme-orange") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR7; ?></option>
					<option value="color-theme-gray"<? if ($siteInfo->color == "color-theme-gray") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR8; ?></option>
					<option value="color-theme-brown"<? if ($siteInfo->color == "color-theme-brown") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR9; ?></option>
					<option value="color-theme-darkgreen"<? if ($siteInfo->color == "color-theme-darkgreen") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR10; ?></option>
					<option value="color-theme-deeppink"<? if ($siteInfo->color == "color-theme-deeppink") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR11; ?></option>
					<option value="color-theme-cadetblue"<? if ($siteInfo->color == "color-theme-cadetblue") { echo ' selected'; } ?>><?= PANEL_THEMES_COLOR12; ?></option>
					<option value="color-theme-cadetblue color-theme-darkorchid"><?= PANEL_THEMES_COLOR13; ?></option>
					</select>
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

$('#myTab a').on('click', function (e) {
  e.preventDefault()
  $(this).tab('show')
})

</script>
</body>
</html>
