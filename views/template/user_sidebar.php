        <!-- Sidebar -->
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-fw fa-comment-dollar"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Dollar Sign</div>
            </a>
            <?php
            $role_id = $this->session->userdata('role_id');
            $queryMenu = "SELECT `user_menu`.`id`,`menu`
                    FROM `user_menu` JOIN `user_access_menu`
                      ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                   WHERE `user_access_menu`.`role_id` = $role_id
                ORDER BY `user_access_menu`.`menu_id` ASC";

            $menu = $this->db->query($queryMenu)->result_array();

            foreach ($menu as $m) {
                echo '<div class="sidebar-heading">' .
                    $m['menu']
                    . '</div>';
                echo '<hr class="sidebar-divider d-none d-md-block">';

                $menuid = $m['id'];
                $querySM = "SELECT * FROM `user_sub_menu`
                    WHERE `menu_id`= $menuid
                    AND `user_sub_menu`.`is_active`=1";

                $subMenu = $this->db->query($querySM)->result_array();

                foreach ($subMenu as $sm) {

                    if ($tittle == $sm['tittle']) {
                        echo    '<li class="nav-item active">';
                    } else {
                        echo    '<li class="nav-item">';
                    }

                    echo        '<a class="nav-link" href="' . base_url() . $sm['url'] . '">';
                    echo         '<i class="' . $sm['icon'] . '"></i>';
                    echo            '<span>' . $sm['tittle'] . '</span></a></li>';
                }
            }
            ?>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block mt-0">
            <!-- Nav Item - logout -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('autentikasi/logout  ') ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Log out</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->