<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title"><center>Pengeluaran</center></h5>
				<div class="form-row">
					<div class="form-group col-md-4">
					</div>
					<div class="form-group col-md-4">
					<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/tambah_pengeluaran')?>">
						<label for="inputEmail4">Jumlah</label>
						<input type="number" class="form-control" name="jumlah" placeholder="Masukkan Jumlah">
						<label for="inputEmail4">Tanggal</label>
						<input type="date" class="form-control" name="tgl_dipakai" placeholder="Masukkan Tanggal">
						<label for="inputEmail4">Deksripsi</label>
						<input type="text" class="form-control" name="keterangan" placeholder="Masukkan Deksripsi">
						</br>
						<div class="col-md-4 offset-md-8"><button type="submit" class="btn btn-primary">Submit</button></div>
						</form>
					</div>
					<div class="form-group col-md-4">
					</div>
					</div>
				</div>
              <div class="card-body ">
			  </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-history"></i> Updated 3 minutes ago
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>