<body>
    <header>


        <div class="navbar navbar-dark bg-dark shadow-sm flex-row ">
            <div class="container d-flex justify-content-end-between mx-auto px-0">
                <a href="<?= base_url('market') ?>" class="navbar-brand d-flex align-items-center">
                    <i class="fas fa-fw fa-comment-dollar"></i>
                    <strong>Dollar Sign</strong>
                </a>
                <?php if ($user != null) : ?>
                    <a class="nav-item" href="<?= base_url('autentikasi') ?>">
                        <button class=" btn btn-outline-light" type="button">
                            <?= $user['name']; ?>
                            <img class="rounded-circle" style="height: 1.5rem; width:1.5 rem;" src="<?= base_url('assets/img/user_img/' . $user['image']) ?>" />
                        </button>
                    </a>
                <?php else : ?>
                    <a href="<?= base_url('autentikasi') ?>">
                        <button class="btn btn-outline-light" type="button">
                            <i class="fas fa-sign-in-alt"></i>
                            Login or Register
                        </button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>