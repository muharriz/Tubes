<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title"><center>Daftar Siswa</center></h5>
				<div class="form-row">
					<div class="form-group col-md-4">
					</div>
					<div class="form-group col-md-4">
					<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/tambah_siswa')?>">
						<label for="inputEmail4">NISN</label>
						<input type="number" class="form-control" name="nis" placeholder="Masukkan Nama Siswa">
						<label for="inputEmail4">Nama</label>
						<input type="text" class="form-control" name="nama" placeholder="Masukkan Nomor Induk Siswa">
						<label for="inputEmail4">Jenis Kelamin</label>
						<select class="custom-select" name="jenis_kelamin" required>
							<option value="Laki laki">Laki laki</option>
							<option value="pr">Perempuan</option>
						</select>
						<label for="inputEmail4">Alamat</label>
						<input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat">
						<label for="inputEmail4">Tanggal Masuk</label>
						<input type="date" class="form-control" name="tanggal">
						<label for="inputEmail4">Status</label>
						<select class="custom-select" name="status" required>
							<option value="Aktif">Aktif</option>
							<option value="Tidak Aktif">Tidak Aktif</option>
						</select>
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