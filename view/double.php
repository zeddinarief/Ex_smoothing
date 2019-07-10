<div class="container-dalam">
    <?php
    if(isset($_SESSION['alert'])){
        echo $_SESSION['alert'];
    }
    ?>
    <h2>Pengujian<br>Double Exponential Smoothing</h2>
    <div class="m-t-15 m-b-100">
        <form id="formPengujian" method="post" action="?page=double&&pengujian=double">
            <div class="form-group">
                <label for="alpha">Masukkan Nilai Alpha: </label>
                <input name ="alpha" type="number" step="any" class="form-control" id="alpha" placeholder="Input Alpha" value="<?php if(isset($alpha)){echo $alpha; }else{ echo "0.1"; } ?>">
            </div>
            <button type="submit" class="btn btn-primary">Hitung</button>
        </form>
    </div>
    <?php
    if($result!=NULL){ 

        ?>
        <h6 class="m-b-15" style="text-align:center">Hasil Proses Pengujian</h6>
        <table id="tablePengujian" class="table table-striped table-bordered">
            <thead>
                <tr style="text-align:center">
                    <th>Tanggal</th>
                    <th>Data Aktual</th>
                    <th>Hasil Prediksi</th>
                    <th>MAPE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $datauji=$db->getDataUji();
                    for ($i =0; $i<count($result['dataUji']);$i++){?>
                    <tr style="text-align:center">
                        <td><?php echo($i+1); ?></td>
                        <td><?php echo($result['dataUji'][$i]['hasilPenjualan']); ?></td>
                        <td><?php echo($result['dataUji'][$i]['hasilPrediksi']); ?></td>
                        <td><?php echo($result['dataUji'][$i]['mape']); ?></td>
                    </tr>
                    <?php
                    }
                ?>
                <tr>
                    <td colspan="3"><strong>MAPE Total</strong></td>
                    <td style="text-align:center"><strong><?php echo $result['mape'] ?></strong></td>
                </tr>
            </tbody>
        </table>
    <?php } ?>
</div>