</div>
</div>
</div>
<!-- Footer -->
<footer class="sticky-footer bg-gradient-light">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; GNXR <?= date('Y') ?> </span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('autentikasi/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('administrator/changeaccess') ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('administrator/roleaccess/'); ?>" + roleId;
            }
        });
    });

    $('.test').css('display', 'none');

    $('#toggledelete').on('click', function() {

        $('.test').toggle();
    });

    function checkallitem() {
        var cb = document.getElementsByName('deleted_id[]');
        var button = document.getElementById('checkAll');

        if (button.value == 'select') {
            for (var i in cb) {
                cb[i].checked = 'false';
            }
            button.value = 'deselect';

        } else {
            for (var i in cb) {
                cb[i].checked = '';
            }
            button.value = 'select';
        }
    }
</script>

</body>

</html>