<div class="container-dalam">
    <?php
    if(isset($_SESSION['alert'])){
        echo $_SESSION['alert'];
    }
    ?>
    <h2>Prediksi<br>Triple Exponential Smoothing</h2>
    <div class="m-t-15 m-b-100">
        <form id="formPrediksi" method="post" action="?page=prediksi_triple&&prediksi=triple">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="alpha">Masukkan Nilai Alpha: </label>
                    <input name ="alpha" type="number" step="any" class="form-control" id="alpha" placeholder="Input Alpha" value="<?php if(isset($alpha)){echo $alpha; }else{ echo "0.1"; } ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="beta">Masukkan Nilai Beta: </label>
                    <input name ="beta" type="number" step="any" class="form-control" id="beta" placeholder="Input Beta" value="<?php if(isset($beta)){echo $beta; }else{ echo "0.1"; } ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="gamma">Masukkan Nilai Gamma: </label>
                    <input name ="gamma" type="number" step="any" class="form-control" id="gamma" placeholder="Input Gamma" value="<?php if(isset($gamma)){echo $gamma; }else{ echo "0.1"; } ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="bulan">Masukkan Bulan: </label>
                 <select class="form-control" id="bulan" name="bulan">
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Januari"; } ?>">Januari</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Februari"; } ?>">Februari</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Maret"; } ?>">Maret</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "April"; } ?>">April</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Mei"; } ?>">Mei</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Juni"; } ?>">Juni</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Juli"; } ?>">Juli</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Agustus"; } ?>">Agustus</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "September"; } ?>">September</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Oktober"; } ?>">Oktober</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "November"; } ?>">November</option>
                    <option value="<?php if(isset($bulan)){echo $bulan; }else{ echo "Desember"; } ?>">Desember</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Hitung</button>
        </form>
    </div>
    <?php
    if($result!=NULL){ 

        ?>
        <h6 class="m-b-15" style="text-align:center">Hasil Proses Prediksi Bulan <?php {echo $bulan; }?></h6>
        <table id="tablePrediksi" class="table table-striped table-bordered">
            <thead>
                <tr style="text-align:center">
                    <th>No</th>
                    <th>Data Aktual</th>
                    <th>Hasil Prediksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 0;
                    for ($i =0; $i<count($result['dataUji']);$i++){?>
                    <tr style="text-align:center">
                        <?php
                        if ($result['data'][$i]['bulan'] == $result['bulan']) {
                        ?>
                            <td><?php echo($no+1); ?></td>
                            <td><?php echo($result['dataUji'][$i]['hasilPenjualan']); ?></td>
                            <td><?php echo($result['dataUji'][$i]['hasilPrediksi']); ?></td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                    }
                ?>
            </tbody>
        </table>
    <?php } ?>
</div>