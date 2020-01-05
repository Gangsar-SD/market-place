<?php if (validation_errors()) : ?>
    <div class="alert alert-danger" role="alert">
        <?= validation_errors(); ?>
    </div>
<?php endif; ?>
<?= $this->session->flashdata('message'); ?>
<div class="container-fluid row">


    <?php foreach ($banner as $b) : ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">

                <div class="card-body">
                    <img class="img-thumbnail mb-2" src="<?= base_url('assets/img/slideshow/') . $b['image'] ?>" alt="<?= $b['image'] ?>">
                    <div class="d-flex justify-content-between align-items-center">

                        <a href="<?= base_url('administrator/deletebanner') . '?id=' . $b['id'] ?>" class="btn btn-sm btn-outline-secondary">Delete</a>


                        <small class="text-muted">9 mins</small>
                    </div>
                </div>
            </div>

        </div>
    <?php endforeach; ?>

    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">

            <div class="card-body">

                <a href="" data-toggle="modal" data-target="#newBanner" class="stretched-link"></a>
                <i class="fas fa-plus fa-6x img-thumbnail"></i>

            </div>
        </div>

    </div>



    <div class="modal fade" id="newBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open_multipart('administrator/banner'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="date" class="form-control" id="date" name="date" />
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

</div>