<main role="main">

    <!-- navbarkategori -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <a class="navbar-brand hidden-lg-down" href="#">Kategori</a>
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <?php foreach ($kategori as $k) : ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('market/kategori') ?>/<?= $k['id'] ?>"><?= $k['kategori'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>

    <section class="jumbotron text-center px-0 py-0 container-fluid bg-dark">
        <div id="myCarousel" class=" carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                $k = 0;
                foreach ($banner as $b) : ?>
                    <li data-target="#myCarousel" <?php if ($k == 0) {
                                                        echo ' class="active" ';
                                                    }; ?>data-slide-to="<?= $k++ ?>"></li>
                <?php endforeach; ?>

            </ol>
            <div class="carousel-inner">

                <?php
                $i = 0;
                foreach ($banner as $b) : ?>
                    <div class="carousel-item<?php if ($i == 0) {
                                                    echo ' active';
                                                }
                                                ?>" id="<?= $i++ ?>">

                        <img src=" <?= base_url('assets/img/slideshow/') . $b['image'] ?>" alt="" style="height :500px;">
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 ">
                <?php foreach ($item as $i) : ?>
                    <div class="col-md-4 h-100">
                        <div class="card mb-4 shadow-sm ">
                            <a href="<?= base_url('market/detailItem') ?>?id=<?= $i['id'] ?>" class="stretched-link"></a>
                            <img src="<?= base_url('assets/img/user_img/') ?><?= $i['image'] ?>" alt="item" class="bd-placeholder-img card-img-top" style=" height:21rem;" />

                            <div class="card-body">
                                <p class="card-text"><?= $i['item'] ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="card-text"><?= rupiah($i['harga'])  ?></p>

                                    <small class=" .d-block .d-sm-none text-muted"><?= $i['email'] ?></small>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>
        <?= $this->pagination->create_links(); ?>
    </div>


</main>