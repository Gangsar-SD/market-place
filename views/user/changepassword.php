<!-- Content Wrapper -->


<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-7 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?= $tittle ?></h1>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form action="<?= base_url('user/changepassword') ?>" method="post">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="current_password" placeholder="Current Password">

                                        <?= form_error('password', '<small class="text-danger ">', '</small>') ?>
                                    </div>
                                    <div class="form-group">

                                        <label for="exampleInputEmail1" class="col-sm col-form-label pb-0 pl-0">New Password</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 ">
                                            <input type="password" class="form-control form-control-user" id="password" name="password1" placeholder="Password">
                                            <?= form_error('password1', '<small class="text-danger ">', '</small>') ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" id="password" name="password2" placeholder="Repeat Password">
                                        </div>
                                    </div>

                                    <div class="tex-center">
                                        <button class="btn btn-primary" type="submit">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End of Main Content -->