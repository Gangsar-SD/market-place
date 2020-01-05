<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $tittle ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= form_error('menu', '<div class="alert alert-success" role="alert">', '</div>') ?>
            <?= $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newMenu">Add New Menu </a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $i = 1;
                    foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $m['menu'] ?></td>
                            <td>
                                <a href="" class="badge badge-success"> edit</a>
                                <a href="<?= base_url('menu/deleteMenu/') . $m['id'] ?>" class="badge badge-danger" onclick="return confirm('yakin?');">delete</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>
</div>


<!-- Modal -->
<div class="modal fade" id="newMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="formGroupExampleInput">New Menu</label>
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name">
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