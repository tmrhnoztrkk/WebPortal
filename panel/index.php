<?
ob_start();
session_start();
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
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><?= $siteInfo->site_title; ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <p class="login-box-msg"><img width="200" src="../files/<?= $siteInfo->site_logo; ?>"></p>
    <?php
    if ($_POST) {
        $username = $byakman->guvenlik($_POST["username"]);
        $password = $byakman->guvenlik($_POST["pass"]);
        if ($username == "") {
            echo '<div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
            '.PANEL_ALERT_MESAGE_1.'
          </div>';
        } else if ($password == "") {
            echo '<div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
            '.PANEL_ALERT_MESAGE_2.'
          </div>';
        } else {

            $kontrol = $byakman->pdo->prepare("SELECT username, pass FROM admins WHERE username = :username AND pass = :pass");
            $kontrol->bindParam(':username', $username);
            $kontrol->bindParam(':pass', md5($password));
            $kontrol->execute();
            if ($kontrol->rowCount() > 0) {

                $_SESSION["admin"]["login"] = true;
                $_SESSION["admin"]["username"] = $username;
                $_SESSION["admin"]["password"] = md5($password);

                echo '<div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-check"></i>'.PANEL_ALERT_TITLE_2.'</h5>
                '.PANEL_ALERT_MESAGE_3.'
              </div>'; 

              header("Refresh: 2; URL=dashboard.php");
 
            } else {
                echo '<div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> '.PANEL_ALERT_TITLE_1.'</h5>
                '.PANEL_ALERT_MESAGE_4.'
              </div>';  
            }

        }
    }
    ?>
      <form name="login" id="login" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" id="username" class="form-control" placeholder="<?= PANEL_LOGIN_USERNAME; ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="pass" id="pass" class="form-control" placeholder="<?= PANEL_LOGIN_PASS; ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block"><?= PANEL_LOGIN_BUTTON; ?></button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
