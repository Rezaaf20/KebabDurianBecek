<section class="card">
      <div class="card-header">
        <h4 class="card-title">Edit transaksi</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <form method="post" action="<?php echo base_url().$action ?>" enctype="multipart/form-data">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">id_transaksi</label>
              <div class="col-sm-10">
                <input type="text" name="id_transaksi" class="form-control" placeholder="" value="<?php echo $dataedit->id_transaksi?>" readonly>
              </div>
            </div>
						<div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">id_barang</label>
              <div class="col-sm-10">
                <input type="text" name="id_barang" class="form-control" value="<?php echo $dataedit->id_barang?>">
              </div>
              </div>
						<div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">id_pembeli</label>
              <div class="col-sm-10">
                <input type="text" name="id_pembeli" class="form-control" value="<?php echo $dataedit->id_pembeli?>">
              </div>
              </div>
						<div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">tanggal</label>
              <div class="col-sm-10">
                <input type="text" name="tanggal" class="form-control" value="<?php echo $dataedit->tanggal?>">
              </div>
              </div>
						<div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">keterangan</label>
              <div class="col-sm-10">
                <input type="text" name="keterangan" class="form-control" value="<?php echo $dataedit->keterangan?>">
              </div>
              </div>

        </div>
        <input type="hidden" id="deleteFiles" name="deleteFiles">
        <div class="col-12">
          <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect
           waves-light float-right">Simpan</button>
        </div>
      </form>
      </div>
    </section>
