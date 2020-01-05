<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-7 col-lg-7 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="POST" action="<?= base_url('autentikasi') ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email') ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class=" form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group pl-4">
                                        <input class="form-check-input" type="checkbox" value="1" id="remember_me" name='remember_me'>
                                        <label class="form-check-label" for="defaultCheck1">
                                            <small>Remember me?</small>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-dark btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small text-dark" href="<?= base_url('autentikasi/forgotpassword') ?>">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small text-dark" href=" <?= base_url('autentikasi/regist') ?>">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>