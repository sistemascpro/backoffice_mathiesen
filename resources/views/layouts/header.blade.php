<!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box"></div>
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item mobile-search-icon"></li>
                            <li class="nav-item dropdown dropdown-large"><div class="dropdown-menu dropdown-menu-end"><div class="row row-cols-3 g-3 p-3"></div></div></li>
                            <li class="nav-item dropdown dropdown-large"><div class="dropdown-menu dropdown-menu-end"><div class="header-notifications-list"></div></div></li>
                            <li class="nav-item dropdown dropdown-large"><div class="dropdown-menu dropdown-menu-end"><div class="header-message-list"></div></div></li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0"><?=session('nombre')?></p>
                                <p class="designattion mb-0"><?=session('rol')?></p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-8">
                            <li><a class="dropdown-item" href="usuarioPerfil"><i class="bx bx-user"></i><span>PERIFL</span></a></li>
                            <li><div class="dropdown-divider mb-0"></div></li>
                            <li><a class="dropdown-item" href="userLogout"><i class='bx bx-log-out-circle'></i><span>SALIR</span></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->
