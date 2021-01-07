<!DOCTYPE html>
<html>
<?php include 'head.php';?>

<body style="background-image: url('./mine/bg1.png');background-size: 100%">
    <div class="container">
        <div class="row align-items-center" style="height: 100vh ">
            <div class="col  ">
                <div class="card rounded shadow wow animate__bounceIn " data-wow-duration="2s" data-wow-delay=".1s" style="background: rgb(240, 241, 245)">
                    <?php include 'nav.php';?>
                    <div class="row  overflow-auto" >
                        <div class="col-12 appx">
                            <div class="card-body ">
                                <?php if ($data['link'] != 'Login'): ?>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <?php if (isset($data['induk'])): ?>
                                        <li class="breadcrumb-item"><a href="#">
                                                <?php echo $data['induk']; ?></a></li>
                                        <?php endif;?>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            <div><i class="fa <?php echo $data['icon']; ?>"></i>  <?php echo $data['judul']; ?></div>
                                        </li>
                                    </ol>
                                </nav>
                                <?php endif;?>
                                <?php include $data['path'] . '.php';?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">Copyright © 2020 Tanti.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php';?>
    <script type='text/javascript'>
    $(document).ready(function() {


    app.barang=$('#barang option:selected').data('barang');
        //app.getall();




    });
    </script>
    <script type='text/javascript'>
    var app = new Vue({
        el: '.appx',
        data: {
            kd: null,
            barang: null,
            barang2: null,

        },


    });
    </script>
</body>

</html>