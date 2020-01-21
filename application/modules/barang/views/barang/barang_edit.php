<section class="card">
      <div class="card-header">
        <h4 class="card-title">Edit barang</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <form method="post" action="<?php echo base_url().$action ?>" enctype="multipart/form-data">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">id_barang</label>
              <div class="col-sm-10">
                <input type="text" name="id_barang" class="form-control" placeholder="" value="<?php echo $dataedit->id_barang?>" readonly>
              </div>
            </div>
						<div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">nama_barang</label>
              <div class="col-sm-10">
                <input type="text" name="nama_barang" class="form-control" value="<?php echo $dataedit->nama_barang?>">
              </div>
              </div>
						<div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">harga</label>
              <div class="col-sm-10">
                <input type="text" name="harga" class="form-control" value="<?php echo $dataedit->harga?>">
              </div>
              </div>
						<div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">stok</label>
              <div class="col-sm-10">
                <input type="text" name="stok" class="form-control" value="<?php echo $dataedit->stok?>">
              </div>
              </div>
						<div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">id_supplier</label>
              <div class="col-sm-10">
                <input type="text" name="id_supplier" class="form-control" value="<?php echo $dataedit->id_supplier?>">
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
