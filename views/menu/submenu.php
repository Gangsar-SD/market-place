<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $tittle ?></h1>
    <div class="row">
        <div class="col-lg">

            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newSubMenu">Add New Sub Menu </a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tittle</th>
                        <th scope="col">Menu</th>
                        <th scope="col">URL</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Active</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>


                    <?php
                                        $i = 1;
                                        foreach ($subMenu as $sm) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $sm['tittle'] ?></td>
                            <td><?= $sm['menu'] ?></td>
                            <td><?= $sm['url'] ?></td>
                            <td><?= $sm['icon'] ?></td>
                            <td><?= $sm['is_active'] ?></td>
                            <td>
                                <a href="" class="badge badge-success" data-toggle="modal" data-target="#editSubMenu<?= $sm['id'] ?>"> edit</a>
                                <a href="<?= base_url('menu/deleteSubMenu/') . $sm['id'] ?>" class="badge badge-danger" onclick="return confirm('yakin?');">delete</a>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </div>

</div>
</div>


<!-- Modal add sub menu -->
<div class="modal fade" id="newSubMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="submenu" name="submenu" placeholder="Sub Menu name">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <!-- nyoba syntax baru     -->
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Sub Menu url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Sub Menu Icon">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Activate
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($subMenu as $sm) : ?>



    <!-- Modal edit menu -->
    <div class="modal fade" id="editSubMenu<?= $sm['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sub Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/submenu'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="submenu" name="submenu" placeholder="Sub Menu name" value="<?= $sm['tittle'] ?>">
                        </div>
                        <div class="form-group">
                            <select name="menu_id" id="menu_id" class="form-control">
                                <!-- nyoba syntax baru     -->
                                <?php foreach ($menu as $m) : ?>x
                                <option value="<?= $m['id'] ?>" <?php if ($sm['menu'] == $m['menu']) {
                                                                                                                                            echo 'selected="selected"';
                                                                                                                                        } ?>>
                                    <?= $m['menu'] ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="url" name="url" placeholder="Sub Menu url" value="<?= $sm['url'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Sub Menu Icon" value="<?= $sm['icon'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $sm['id'] ?>">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    Activate
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('yakin?');">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>