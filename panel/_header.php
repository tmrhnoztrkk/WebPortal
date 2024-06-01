    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link" align="center">
      <span class="brand-text font-weight-light"><?= stripslashes($siteInfo->site_title); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="profile.php" class="d-block"><?= stripslashes($userInfo->username); ?></a>
        </div>
      </div>