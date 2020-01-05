<div class="container">

    <div class="row justify-content-center">

        <div class="col-xl-7 col-lg-7 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900">Reset password for</h1>
                                </div>
                                <div class="text-center">
                                    <h5 class="h4 text-gray-900 mb-4"><?= $this->session->userdata('reset_email'); ?></h5>
                                </div>
                                <form class="user" method="POST" action="<?= base_url('autentikasi/changepassword') ?>">

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" id="password" name="password1" placeholder="New password">

                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" id="password" name="password2" placeholder="Repeat Password">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Change Password
                                    </button>
                                </form>
                                <hr>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>