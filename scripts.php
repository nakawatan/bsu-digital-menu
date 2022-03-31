
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $('.show-my-qr').unbind().on('click',function(){
        $.ajax({
            url: '/api/',
            data: {
                method:"get_merchant_qr",
                id : <?php echo $_SESSION['user']['restaurant_id'] ?>
            },
            method: 'POST',
            dataType:"json",
            success: function(response) {
                $('#my-qr-code-link').attr('src',response.qr);
                $('#qr-modal').modal('show');
            }
        });
    });
</script>