<main role="main">
    <div class="row">
        <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion col-2 pr-0 " id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">

                <div class="sidebar-brand-text mx-3">Category</div>
            </a>
            <div class="pl-2">

                <?php foreach ($sidebar as $s) : ?>
                    <?php if ($s['kategori'] == $tittle) : ?>
                        <li class="nav-item active pl-3 bg-gradient-dark">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif ?>
                        <a class="nav-link " href="<?= base_url('Market/kategori/') ?><?= $s['id'] ?>/"><span><?= $s['kategori'] ?></span>
                        </a>
                        </li>
                    <?php endforeach; ?>
                    <hr class="sidebar-divider d-none d-md-block mt-0">
                    <!-- Nav Item - logout -->

            </div>
        </ul>



        <div class="album pt-4 pb-1 bg-light col-10">
            <div class=" container-fluid">
                <?php if ($item == null) {
                    echo $this->session->flashdata('message');
                }; ?>
                <div class="row">
                    <?php foreach ($item as $i) : ?>
                        <div class="col-md-4 col-lg-3 col-sm-6 col-xs-1">
                            <div class="card mb-4 shadow-sm ">
                                <a href="<?= base_url('market/detailItem') ?>?id=<?= $i['id'] ?>" class="stretched-link"></a>
                                <div class="container">

                                    <img src="<?= base_url('assets/img/user_img/') ?><?= $i['image'] ?>" alt="item" class="bd-placeholder-img card-img-top img-fluid" style="object-fit:cover; height:250px; " />
                                </div>

                                <div class=" card-body">
                                    <p class="card-text"><?= $i['item'] ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text"><?= rupiah($i['harga']) ?></p>

                                    </div>
                                    <small class=" .d-block .d-sm-none text-muted"><?= $i['email'] ?></small>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <?= $this->pagination->create_links(); ?>
        </div>

    </div>
</main>