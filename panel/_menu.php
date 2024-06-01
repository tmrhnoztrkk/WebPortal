 <!-- Sidebar Menu -->
 <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                <?= PANEL_HOMEPAGE; ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="bouquets.php" class="nav-link">
              <i class="nav-icon fas fa-align-justify"></i>
              <p>
              <?= PANEL_BOUQUETS; ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="guides.php" class="nav-link">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
              <?= PANEL_GUIDES; ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admins.php" class="nav-link">
              <i class="nav-icon fas fa-user-secret"></i>
              <p>
              <?= PANEL_ADMINS; ?>
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="themes.php" class="nav-link">
              <i class="nav-icon fas fa-palette"></i>
              <p>
              <?= PANEL_THEMES; ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="settings.php" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
              <?= PANEL_SETTINGS; ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="profile.php" class="nav-link">
              <i class="nav-icon fas fa-user-edit"></i>
              <p>
              <?= PANEL_PROFILE; ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
              <?= PANEL_LOGOUT; ?>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->