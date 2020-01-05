<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $tittle ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <h5>Role : <?= $role['role'] ?></h5>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($menu as $m) {
                        echo    '<tr>
                            <th scope="row">' . $i++ . '</th>
                            <td>' . $m['menu'] . ' </td>
                            <td>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox"' . check_access($role['id'], $m['id']) . ' data-role=' . $role['id'] . ' data-menu =' . $m['id'] . '>
                            </div>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</div>