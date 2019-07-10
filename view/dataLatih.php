<div class="container-dalam">
    <?php
    if(isset($_SESSION['alert'])){
        echo $_SESSION['alert'];
    }
    ?>
    <h2>Data Latih</h2>
    <button type="button" class=" m-b-15 btn btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Data Latih</button>
    <table id="table_dataLatih" class="table table-striped table-bordered">
        <thead>
            <tr style="text-align:center">
                <th>No</th>
                <th>Bulan</th>
                <th>Hasil Penjualan Emas</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $datalatih=$db->getDataLatih();
            for ($i =0; $i<count($datalatih);$i++){?>
            <tr style="text-align:center">
                <td><?php echo($i+1); ?></td>
                <td><?php echo($datalatih[$i]['tgl']); ?></td>
                <td><?php echo($datalatih[$i]['hasil_penjualan']); ?></td>
                <td>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" 
                            data-tgl="<?php echo($datalatih[$i]['tgl']) ?>" 
                            data-penjualan="<?php echo($datalatih[$i]['hasil_penjualan']) ?>"
                            data-id="<?php echo($datalatih[$i]['id']) ?>"
                            data-url="?page=dataLatih&&edit=<?php echo ($datalatih[$i]['id'])?>">
                        <span class="fa fa-pencil" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-danger m-r-5" data-toggle="modal" data-target="#modalHapus"
                            data-url="?page=dataLatih&&delete=<?php echo ($datalatih[$i]['id'])?>"
                            data-id="<?php echo $datalatih[$i]['id'] ?>" >
                            <span class="fa fa-trash" aria-hidden="true"></span>
                    </button>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label for="input_tanggal" class="col-form-label">Tanggal:</label>
                <input type="date" class="form-control" id="input_tanggal" name="input_tgl">
            </div>
            <div class="form-group">
                <label for="input_hasil_penjualan" class="col-form-label">Hasil Penjualan:</label>
                <input type="number" class="form-control" id="input_hasil_penjualan" name="input_hasil_penjualan">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahLabel">Tambah Data Latih</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="?page=dataLatih&&add=new">
        <div class="modal-body">
            <div class="form-group">
                <label for="input_tanggal" class="col-form-label">Tanggal:</label>
                <input required type="date" class="form-control" name="input_tgl" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label for="input_hasil_penjualan" class="col-form-label">Hasil Penjualan:</label>
                <input required type="number" class="form-control" name="input_hasil_penjualan">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalHapus">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalHapusText">Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="#" id="modalHapusLink">Delete</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>