<!-- Content Wrapper -->


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
            <form action="<?= base_url('administrator/deletecheckedcat') ?>" method="post">
                <a href="" class="btn btn-dark" data-toggle="modal" data-target="#newKat">Add New Category </a>

                <button id="toggledelete" class="btn btn-dark" type="button">Deletes?</button>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="test">Tandai</th>
                            <th scope="col">#</th>
                            <th scope="col">kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($kategori as $k) : ?>
                            <tr>
                                <td class="test">
                                    <input type="checkbox" name="deleted_id[]" id="deleted_id" value="<?= $k['id'] ?>" class="checkbox">
                                </td>
                                <th scope="row"><?= $i++ ?></th>
                                <td><?= $k['kategori'] ?></td>
                                <td>
                                    <a href="" class="badge badge-success" data-toggle="modal" data-target="#editKat<?= $k['id'] ?>"> edit</a>
                                    <a href="<?= base_url('administrator/deletecat?id=') . $k['id'] ?>" class="badge badge-danger" onclick="return confirm('yakin?');">delete</a>
                            </tr>
                        <?php endforeach; ?>
                        <button type="submit" class="btn btn-dark test" onclick="return confirm('yakin?');">delete</button>
                        <button class="btn btn-dark test" id="checkAll" type="button" onclick="checkallitem()" value="select">CheckAll</button>
                    </tbody>
                </table>
            </form>
        </div>

    </div>

</div>
</div>


<!-- Modal add sub menu -->
<div class="modal fade" id="newKat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('administrator/category'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="New category">
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

<?php foreach ($kategori as $k) : ?>



    <!-- Modal edit menu -->
    <div class="modal fade" id="editKat<?= $k['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sub Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('administrator/category'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Category" value="<?= $k['kategori'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $k['id'] ?>">
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

<!-- End of Main Content -->