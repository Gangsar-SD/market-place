<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $tittle ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= form_error('menu', '<div class="alert alert-success" role="alert">', '</div>') ?>
            <?= $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newRole">Add New Role </a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($role as $r) : ?>
                        <tr>
                            <th scope="row"> <?= $i ?></th>
                            <td><?= $r['role']; ?></td>
                            <td>
                                <a href="<?= base_url('administrator/roleaccess/') . $r['id'] ?>" class="badge badge-warning"> access</a>

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
<div class="modal fade" id="newRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('administrator/role'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Example label</label>
                        <input type="text" class="form-control" id="role" name="role" placeholder="role name">
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
</div>