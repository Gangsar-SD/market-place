<!-- Content Wrapper -->


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $tittle ?> </h1>
    <div class="row">

        <div class="col-lg-8">
            <?= form_open_multipart('user/editprofil'); ?>



            <div class="form-group row">
                <label for="exampleInputEmail1" class="col-sm-2 col-form-label">Email address</label>
                <div class="col-sm-10">

                    <input type="email" class="form-control-plaintext" id="email" name="email" value="<?= $user['email'] ?>" readonly>
                </div>

            </div>
            <div class="form-group row">
                <label for="exampleInputEmail1" class="col-sm-2 col-form-label">User name</label>
                <div class="col-sm-10">

                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
                    <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                </div>

            </div>

            <div class="form-group row">
                <label for="exampleInputEmail1" class="col-sm-2 col-form-label">User name</label>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/user_img/') . $user['image'] ?>" class="img-thumbnail">

                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <button class="btn btn-primary" type="submit">Edit</button>
            </div>

            </form>
        </div>
    </div>


</div>
</div>
<!-- End of Main Content -->