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

            <div class="pb-3">

            </div>
            <form action="<?= base_url('user/deletecheckeditem') ?>" method="post">

                <a href="" class="btn btn-dark" data-toggle="modal" data-target="#newItem">Add New Item </a>
                <button id="toggledelete" class="btn btn-dark" type="button">Deletes?</button>


                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="test">Tandai</th>
                            <th scope="col">#</th>
                            <th scope="col">Item</th>
                            <th scope="col">harga</th>
                            <th scope="col">kategori</th>
                            <th scope="col">deskripsi</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>



                        <?php
                        $i = 1;
                        foreach ($inventory as $inv) : ?>
                            <tr>

                                <td class="test">
                                    <input type="checkbox" name="deleted_id[]" id="deleted_id" value="<?= $inv['id'] ?>" class="checkbox">
                                </td>
                                <th scope="row"><?= $i++ ?></th>
                                <td><?= $inv['item'] ?></td>
                                <td><?= rupiah($inv['harga'])  ?></td>
                                <td><?= $inv['kategori'] ?></td>
                                <td><?= $inv['deskripsi'] ?></td>
                                <td>
                                    <a href="" class="badge badge-success" data-toggle="modal" data-target="#editInv<?= $inv['id'] ?>"> edit</a>
                                    <a href="<?= base_url('user/deleteItem?id=') . $inv['id'] ?>" class="badge badge-danger" onclick="return confirm('yakin?');">delete</a>
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


<!-- Modal add item -->
<div class="modal fade" id="newItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('user/inventory'); ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="item" name="item" placeholder="Nama item">
                </div>
                <div class="form-group">
                    <select name="id_kategori" id="id_kategori" class="form-control">
                        <!-- nyoba syntax baru     -->
                        <?php foreach ($kategori as $k) : ?>
                            <option value="<?= $k['id'] ?>"><?= $k['id'] ?><?= $k['kategori'] ?></option>

                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga item" rows="3" />
                </div>

                <div class="form-group">

                    <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="deskripsi" rows="3"></textarea>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <img src="<?= base_url('assets/img/user_img/') ?>default.jpg" class="img-thumbnail">

                    </div>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($inventory as $inv) : ?>



    <!-- Modal edit menu -->
    <div class="modal fade" id="editInv<?= $inv['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sub Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <?= form_open_multipart('user/inventory'); ?>

                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="Nama Item" name="item" placeholder="Sub Menu name" value="<?= $inv['item'] ?>">
                    </div>
                    <div class="form-group">
                        <select name="id_kategori" id="id_kategori" class="form-control">
                            <!-- nyoba syntax baru     -->
                            <?php foreach ($kategori as $k) : ?>x
                            <option value="<?= $k['id'] ?>" <?php if ($inv['kategori'] == $k['kategori']) {
                                                                echo 'selected="selected"';
                                                            } ?>>
                                <?= $k['id'] ?> <?= $k['kategori'] ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="harga" name="harga" placeholder="Sub Menu url" value="<?= $inv['harga'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Sub Menu Icon" value="<?= $inv['deskripsi'] ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?= $inv['id'] ?>">
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/user_img/') ?><?= $inv['image'] ?>" class="img-thumbnail">

                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark" onclick="return confirm('yakin?');">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>

<!-- End of Main Content -->