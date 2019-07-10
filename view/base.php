<!DOCTYPE html>
<html lang="en">
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            Hasil Penjualan Emas
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" >
        <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" >
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/pace-minimal.css">
        <link href="assets/css/custom.css" rel="stylesheet">
        <?php
        if ($page=='home.php'){
            ?>
            <style>
                html{
                    background: url('assets/img/bg.jpg') no-repeat center center fixed; 
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;
                }
            </style>
            <?php
        }
        ?>
        
    </head>
    <body cz-shortcut-listen="true">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="?">Hasil Penjualan Emas</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                        <li class="nav-item <?php if($_SERVER['QUERY_STRING']==''){echo "active";} ?>">
                            <a class="nav-link" href="?">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown <?php if(strpos($_SERVER['QUERY_STRING'], "page=dataLatih")!==false||strpos($_SERVER['QUERY_STRING'], "page=dataUji")!==false){echo "active";} ?>">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Data
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?page=dataLatih">Data Latih</a>
                            <a class="dropdown-item" href="?page=dataUji">Data Uji</a>
                        </li>
                        <li class="nav-item dropdown <?php if(strpos($_SERVER['QUERY_STRING'], "page=prediksi_single")!==false||strpos($_SERVER['QUERY_STRING'], "page=prediksi_double")!==false||strpos($_SERVER['QUERY_STRING'], "page=prediksi_triple")!==false){echo "active";} ?>">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Prediksi
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?page=prediksi_single">Single Smoothing</a>
                            <a class="dropdown-item" href="?page=prediksi_double">Double Smoothing</a>
                            <a class="dropdown-item" href="?page=prediksi_triple">Triple Smoothing</a>
                        </li>
                        <li class="nav-item dropdown <?php if(strpos($_SERVER['QUERY_STRING'], "page=single")!==false||strpos($_SERVER['QUERY_STRING'], "page=double")!==false||strpos($_SERVER['QUERY_STRING'], "page=triple")!==false){echo "active";} ?>">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pengujian
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?page=single">Single Smoothing</a>
                            <a class="dropdown-item" href="?page=double">Double Smoothing</a>
                            <a class="dropdown-item" href="?page=triple">Triple Smoothing</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <?php include $page; ?>
        </div>
        <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js" ></script>
        <script src="assets/js/datatables.min.js" ></script>
        <script src="assets/js/dataTables.bootstrap4.min.js" ></script>
        <script src="assets/js/pace.min.js" ></script>

        <script>
        $(document).ready( function () {
            $('#table_dataLatih').DataTable();
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var tgl = button.data('tgl') // Extract info from data-* attributes
                var hasil_penjualan = button.data('penjualan') // Extract info from data-* attributes
                var url = button.data('url') // Extract info from data-* attributes
                var id = button.data('id') // Extract info from data-* attributes
                var modal = $(this)
                modal.find('form').attr('action',url);
                modal.find('.modal-title').text('Edit data id: ' + id)
                modal.find('.modal-body #input_tanggal').val(tgl)
                modal.find('.modal-body #input_hasil_penjualan').val(hasil_penjualan)
            });
            $('#modalHapus').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var id = button.data('id');
                var modal=$(this);
                modal.find('p#modalHapusText').text('Apakah anda yakin ingin menghapus data dengan id : '+id+'? ');
                modal.find('a#modalHapusLink').attr('href',url);
            });
            $("#myAlert .close").click(function(){
                $("#myAlert").alert("close");
                <?php 
                if (session_status() == PHP_SESSION_ACTIVE){
                    session_destroy();
                }
                ?>
            });
            setTimeout(function() {
                $("#myAlert").alert('close');
                <?php 
                if (session_status() == PHP_SESSION_ACTIVE){
                    session_destroy();
                }
                ?>
            }, 2000);
        });
        </script>
    </body>
    <!-- end::Body -->
</html>
