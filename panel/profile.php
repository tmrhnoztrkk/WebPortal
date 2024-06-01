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
            <h1 class="m-0 text-dark"><?= PANEL_PROFILE_TITLE; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php"><?= PANEL_HOMEPAGE; ?></a></li>
              <li class="breadcrumb-item active"><?= PANEL_PROFILE_TITLE; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?= PANEL_PROFILE_TITLE; ?></h3>
                </div>
                <?php
                if ($_POST) {
                    $username = $byakman->guvenlik($_POST["username"]);
                    $password = $byakman->guvenlik($_POST["pass"]);
                    $e_pass = $byakman->guvenlik($_POST["e_pass"]);
                    if ($password != "" AND md5($password) != $e_pass) {
                        $pass = md5($password);
                    } else {
                        $pass = $e_pass;
                    }
                    $result = $byakman->pdo->prepare("UPDATE admins SET  pass = :pass WHERE id = :id");
                    $result->bindParam(":pass", $pass, PDO::PARAM_STR);
                    $result->bindParam(":id", $userInfo->id, PDO::PARAM_INT);
                    $result->execute();
                        if ($result) {
                            $mesaj = '<div class="alert alert-success alert-dismissible">
                            <h5><i class="icon fas fa-check"></i> '.PANEL_ALERT_TITLE_2.'</h5>
                           '.PANEL_PROFILE_MESSAGE_1.'
                          </div>';
                          header("Refresh: 1; URL=logout.php");
                        } else {
                            $mesaj = '<div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
                            '.PANEL_PROFILE_MESSAGE_2.'
                          </div>';
                        }
                }
                ?>
                <form name="bouquets" id="bouquets" method="POST">
                <div class="card-body">
                    <?= $mesaj ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_PROFILE_USERNAME; ?></label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $userInfo->username; ?>" disabled />
                    </div>
                    <div class="form-group">
                        <label><?= PANEL_PROFILE_PASS; ?></label>
                        <input type="text" class="form-control" name="pass" id="pass" placeholder="<?= PANEL_PROFILE_PASS_MESSAGE; ?>" />
                        <input type="hidden" name="e_pass" value="<?= $userInfo->pass; ?>" />
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" name="bouquet_ayar" id="bouquet_ayar" class="btn btn-primary" style="float:right" value="<?= PANEL_PROFILE_SAVE; ?>" />
                </div>
                </form>
            </div>
            </div>
            
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
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
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
