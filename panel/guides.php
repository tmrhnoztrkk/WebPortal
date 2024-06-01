<?
ob_start();
session_start();
if (($_SESSION["admin"]["login"] != true) OR ($_SESSION["admin"]["username"] == "") OR ($_SESSION["admin"]["password"] == "")) {
    header("Location: index.php");
    exit();
}
include("../conf/functions.php");
$id = $byakman->guvenlik($_GET["id"]);
$bilgiler = $byakman->pdo->prepare("SELECT * FROM guides WHERE id=:id");
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
            <h1 class="m-0 text-dark"><?= PANEL_GUIDES_TITLE; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php"><?= PANEL_HOMEPAGE; ?></a></li>
              <li class="breadcrumb-item active"><?= PANEL_GUIDES_TITLE; ?></li>
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
                    <h3 class="card-title"><?= PANEL_GUIDES_TITLE; ?></h3>
                </div>
                <?php
                if ($_POST) {
                    $guide_name = $byakman->guvenlik($_POST["guide_name"]);
                    $guide_desc = $_POST["guide_desc"];
                    $is_smart = $byakman->guvenlik($_POST["is_smart"]);
                    if (empty($is_smart)) { $is_smart = 0; }
                    $time = time();
                    if ($id > 0) {
                        $result = $byakman->pdo->prepare("UPDATE guides SET guide_name = :guide_name, guide_desc = :guide_desc, is_smart = :is_smart WHERE id = :id");
                        $result->bindParam(":guide_name", $guide_name, PDO::PARAM_STR);
                        $result->bindParam(":guide_desc", $guide_desc);
                        $result->bindParam(":is_smart", $is_smart, PDO::PARAM_INT);
                        $result->bindParam(":id", $id, PDO::PARAM_INT);
                        $result->execute();
                        if ($result) {
                            $mesaj = '<div class="alert alert-success alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_2.'</h5>
                            '.PANEL_GUIDES_MESSAGE_1.'
                          </div>';
                        } else {
                            $mesaj = '<div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
                            '.PANEL_GUIDES_MESSAGE_2.'
                          </div>';
                        }
                    } else {
                        $result = $byakman->pdo->prepare("INSERT INTO guides (guide_name, guide_desc, is_smart, create_time) VALUES (?,?,?,?)");
                        $result->bindParam(1, $guide_name);
                        $result->bindParam(2, $guide_desc);
                        $result->bindParam(3, $is_smart);
                        $result->bindParam(4, $time);
                        $result->execute();
                        if ($result) {
                            $mesaj = '<div class="alert alert-success alert-dismissible">
                            <h5><i class="icon fas fa-check"></i> '.PANEL_ALERT_TITLE_2.'</h5>
                            '.PANEL_GUIDES_MESSAGE_3.'
                          </div>';
						  header("REFRESH:1; url=guides.php");
                        } else {
                            $mesaj = '<div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
                            '.PANEL_GUIDES_MESSAGE_4.'
                          </div>';
                        }
                    }
                }
                ?>
                <form name="guides" id="guides" method="POST">
                <div class="card-body">
                    <?= $mesaj ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_GUIDES_NAME; ?></label>
                        <input type="text" class="form-control" name="guide_name" id="guide_name" <? if ($id > 0) { echo 'value="'.stripslashes($info->guide_name).'"'; } else { echo 'placeholder="'.PANEL_GUIDES_NAME.'"';} ?> />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= PANEL_GUIDES_SMART; ?></label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="is_smart" value="1" id="is_smart"<? if ($id > 0 AND $info->is_smart == 1) { echo ' checked'; } ?>>
                          <label class="form-check-label">SMART IPTV</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="is_smart" value="2" id="is_smart"<? if ($id > 0 AND $info->is_smart == 2) { echo ' checked'; } ?>>
                          <label class="form-check-label">ROYAL IPTV</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= PANEL_GUIDES_DESC;?></label>
                        <textarea name="guide_desc" id="guide_desc"><? if ($id > 0) { echo ''.stripslashes($info->guide_desc).''; } else { echo '';} ?></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" name="guide_ayar" id="guide_ayar" class="btn btn-primary" style="float:right" value="<?= PANEL_GUIDES_SAVE;?>" />
                </div>
                </form>
</div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= PANEL_GUIDES_TITLE2;?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                        $islem = $byakman->guvenlik($_GET["islem"]);
                        switch ($islem) {
                            case 'sil':
                            $sid = $byakman->guvenlik($_GET["sid"]);
                            $result = $byakman->pdo->prepare("UPDATE guides SET status = :st WHERE id = :id");
                            $result->bindParam(":st", $a = 0, PDO::PARAM_INT);
                            $result->bindParam(":id", $sid, PDO::PARAM_INT);
                            $result->execute();
                            if ($result) {
                                echo  '<div class="alert alert-success alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_2.'</h5>
                                '.PANEL_GUIDES_MESSAGE_5.'
                              </div>';
                            } else {
                                echo '<div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
                                '.PANEL_GUIDES_MESSAGE_5.'
                              </div>';
                            }
                            break;
                        }
                        ?>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?= PANEL_GUIDES_NAME;?></th>
                                <th><?= PANEL_GUIDES_ACTIONS;?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        $bouqets = $byakman->pdo->query("SELECT * FROM guides WHERE status = '1' ORDER BY sira ASC")->fetchAll();
                        foreach($bouqets AS $bq) { ?>
                            <tr data-sortable="<?= stripslashes($bq->sira); ?>" data-guid="<?= stripslashes($bq->id); ?>">
                                <td><?= stripslashes($bq->guide_name); ?></td>
                                <td align="center"><a href="guides.php?id=<?= stripslashes($bq->id); ?>"><button class="btn btn-warning"><i class="fas fa-edit"></i></button></a> <a href="guides.php?islem=sil&sid=<?= stripslashes($bq->id); ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a></td>
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
<script src="plugins/ckeditor/ckeditor.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
    
                CKEDITOR.replace( 'guide_desc' );
  $(function () {
    $('#example2').DataTable({
        "fixedHeader": true,
        "responsive": true,
        "paging": true,
        "info": false,
		"ordering": false,
    });
	    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };
 $("#example2 tbody").sortable({
        helper: fixHelper,
        update: function(event, ui) {
            $("#example2 tbody tr").each(function(index){
                $.ajax({
                    url: 'json/reorder.php?type=2',
                    type: 'POST',
                    data: 'sira='+$(this).data('sortable')+'&guid='+$(this).data('guid')+'&position='+(index+1)
                })
                .done(function (response) {
                    console.log(response);
                })
                .fail(function (jqXhr) {
                    console.log(jqXhr);
                });
            });
        }
    }).disableSelection();
  });
</script>
</body>
</html>
