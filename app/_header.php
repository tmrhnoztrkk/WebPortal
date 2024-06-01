    <!-- header wrapper -->
    <div class="header-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 navbar p-0">
                    <a href="index.php?page=homepage" class="logo ml-5"><img src="files/<?= $siteInfo->site_logo; ?>" alt="logo" class="light"><img src="files/<?= $siteInfo->site_logo; ?>" alt="logo" class="dark"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <div class="hidden-lg-up mb-5 mt-5">
                                <div class="typeahead__container">
                                    <div class="typeahead__field">
                                        <div class="typeahead__query">
                                            <input class="fast-search col-md-12" id="fast-search" name="country_v1[query]" placeholder="<?= SEARCH_INPUT_TEXT; ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="navbar-nav nav-menu float-none text-center">
                                <li class="nav-item"><a class="nav-link" href="<?= $byakman->route('homepage'); ?>"><?= MENU_HOMEPAGE; ?></a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= $byakman->route('livetv'); ?>"><?= MENU_LIVETV; ?></a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= $byakman->route('movies'); ?>"><?= MENU_MOVIES; ?></a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= $byakman->route('series'); ?>"><?= MENU_SERIES; ?></a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= $byakman->route('guides'); ?>"><?= MENU_GUIDES; ?></a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= $byakman->route('profile'); ?>"><?= MENU_PROFILE; ?></a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= $byakman->route('logout'); ?>"><?= MENU_LOGOUT; ?></a></li>
                            </ul>
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="search-div">
                        <div class="typeahead__container">
                            <div class="typeahead__field">
                                <div class="typeahead__query">
                                    <input class="fast-search col-md-12" id="fast-search" name="country_v1[query]" placeholder="<?= SEARCH_INPUT_TEXT; ?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header wrapper -->