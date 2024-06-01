<?

ob_start();
session_start();
if (($_SESSION["admin"]["login"] != true) OR ($_SESSION["admin"]["username"] == "") OR ($_SESSION["admin"]["password"] == "")) {
    header("Location: index.php");
    exit();
}
include("../conf/functions.php");
$id = $byakman->guvenlik($_GET["id"]);
$bilgiler = $byakman->pdo->prepare("SELECT * FROM admins WHERE id=:id");
$bilgiler->execute(['id' => $id]); 
$info = $bilgiler->fetch();
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
            <h1 class="m-0 text-dark"><?= PANEL_ADMINS_TITLE; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php"><?= PANEL_HOMEPAGE; ?></a></li>
              <li class="breadcrumb-item active"><?= PANEL_ADMINS_TITLE; ?></li>
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
            <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?= PANEL_ADMINS_TITLE; ?></h3>
                </div>
                <?php
                if ($_POST) {
                    $username = $byakman->guvenlik($_POST["username"]);
                    $password = $byakman->guvenlik($_POST["password"]);
                    $e_pass = $byakman->guvenlik($_POST["e_pass"]);
                    $time = time();
                    if ($id > 0) {
                        if ($password != "" AND $password != $e_pass) {
                            $pass = md5($password);
                        } else {
                            $pass = $e_pass;
                        }
                        $result = $byakman->pdo->prepare("UPDATE admins SET username = :username, pass = :pass WHERE id = :id");
                        $result->bindParam(":username", $username, PDO::PARAM_STR);
                        $result->bindParam(":pass", $pass, PDO::PARAM_STR);
                        $result->bindParam(":id", $id, PDO::PARAM_INT);
                        $result->execute();
                        if ($result) {
                            $mesaj = '<div class="alert alert-success alert-dismissible">
                            <h5><i class="icon fas fa-check"></i> '.PANEL_ALERT_TITLE_2.'</h5>
                            '.PANEL_ADMINS_MESSAGE_1.'
                          </div>';
						  header("REFRESH:1; url=admins.php");
                        } else {
                            $mesaj = '<div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
                            '.PANEL_ADMINS_MESSAGE_2.'
                          </div>';
                        }
                    } else {
                        $result = $byakman->pdo->prepare("INSERT INTO admins (username, pass, create_time) VALUES (?,?,?)");
                        $result->bindParam(1, $username);
                        $result->bindParam(2, $password);
                        $result->bindParam(3, $time);
                        $result->execute();
                        if ($result) {
                            $mesaj = '<div class="alert alert-success alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_2.'</h5>
                            '.PANEL_ADMINS_MESSAGE_3.'
                          </div>';
                        } else {
                            $mesaj = '<div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
                            '.PANEL_ADMINS_MESSAGE_4.'
                          </div>';
                        }
                    }
                }
                ?>
                <form name="admins" id="admins" method="POST">
                <div class="card-body">
                    <?= $mesaj ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_ADMINS_USERNAME; ?></label>
                        <input type="text" class="form-control" name="username" id="username" <? if ($id > 0) { echo 'value="'.stripslashes($info->username).'"'; } else { echo 'placeholder="'.PANEL_ADMINS_USERNAME.'"';} ?> />
                    </div>
                    <div class="form-group">
                        <label><?= PANEL_ADMINS_PASS; ?></label>
                        <input type="text" class="form-control" name="password" id="password" <? if ($id > 0) { echo ''; } else { echo 'placeholder="'.PANEL_ADMINS_PASS.'"';} ?> />
                        <? if ($id > 0) { echo '<input type="hidden" name="e_pass" value="'.stripslashes($info->pass).'" />'; } ?>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" name="bouquet_ayar" id="bouquet_ayar" class="btn btn-primary" style="float:right" value="<?= PANEL_ADMINS_SAVE; ?>" />
                </div>
                </form>
</div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= PANEL_ADMINS_TITLE2; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                        $islem = $byakman->guvenlik($_GET["islem"]);
                        switch ($islem) {
                            case 'sil':
                            $sid = $byakman->guvenlik($_GET["sid"]);
                            $result = $byakman->pdo->prepare("UPDATE admins SET status = :st WHERE id = :id");
                            $result->bindParam(":st", $a = 0, PDO::PARAM_INT);
                            $result->bindParam(":id", $sid, PDO::PARAM_INT);
                            $result->execute();
                            if ($result) {
                                echo  '<div class="alert alert-success alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_2.'</h5>
                                '.PANEL_ADMINS_MESSAGE_5.'
                              </div>';
                            } else {
                                echo '<div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
                               '.PANEL_ADMINS_MESSAGE_6.'
                              </div>';
                            }
                            break;
                        }
                        ?>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?= PANEL_ADMINS_USERNAME; ?></th>
                                <th><?= PANEL_ADMINS_ACTIONS; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        $bouqets = $byakman->pdo->query("SELECT * FROM admins WHERE status = '1' ORDER BY username ASC")->fetchAll();
                        foreach($bouqets AS $bq) { ?>
                            <tr>
                                <td><?= stripslashes($bq->username); ?></td>
                                <td align="center"><a href="admins.php?id=<?= stripslashes($bq->id); ?>"><button class="btn btn-warning"><i class="fas fa-edit"></i></button></a> <a href="admins.php?islem=sil&sid=<?= stripslashes($bq->id); ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a></td>
                            </tr>
                        <? } ?>
                        </tbody>
                    </table>
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
