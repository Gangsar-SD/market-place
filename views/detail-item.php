<main role="main">


    <div class="album pt-4 pb-1 bg-light col-lg">



        <div class="card mb-3 px-4 py-4">
            <h5 class="card-title mb-0"><?= $item['item'] ?></h5>
            <p class="card-text "><small class="text-muted"><?= $item['kategori'] ?></small></p>
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?= base_url('assets/img/user_img/') ?><?= $item['image'] ?>" class="card-img block__pic" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body py-0">
                        <p class="card-text"><?= $item['deskripsi'] ?></p>
                        <p class="card-text"><?= rupiah($item['harga'])  ?></p>
                        <p class="card-text"><small class="text-muted"><?= $item['email'] ?></small></p>
                    </div>
                </div>
            </div>



        </div>
    </div>