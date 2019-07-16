<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title"><center>Daftar Pegawai</center></h5>
				<div class="form-row">
					<div class="form-group col-md-4">
					</div>
					<div class="form-group col-md-4">
					<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/tambah_pegawai')?>">
						<label for="inputEmail4">Nama Depan</label>
						<input type="text" class="form-control" name="nama_depan" placeholder="Masukkan Nama Depan">
						<label for="inputEmail4">Nama Belakang</label>
						<input type="text" class="form-control" name="nama_belakang" placeholder="Masukkan Nama Belakang">
						<label for="inputEmail4">Nomor Handphone</label>
						<input type="text" class="form-control" name="no_handphone" placeholder="Masukkan Nomor Handphone">
						<label for="inputEmail4">Alamat</label>
						<input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat">
						<label for="inputEmail4">Level</label>
						<select class="custom-select" name="level" required>
							<option value="Bendahara">Bendahara</option>
							<option value="Staff">Staff</option>
						</select>
						<label for="inputEmail4">Status</label>
						<select class="custom-select" name="status" required>
							<option value="Aktif">Aktif</option>
							<option value="Tidak Aktif">Tidak Aktif</option>
						</select>
						<label for="inputEmail4">Password</label>
						<input type="password" class="form-control" name="pegawai_password" placeholder="Masukkan Password">
						</br>
						<div class="col-md-4 offset-md-8"><button type="submit" class="btn btn-primary">Daftar</button></div>
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