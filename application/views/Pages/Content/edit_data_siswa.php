<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
            	 <!--Alert kalau berhasil-->
        	<?php if($this->session->flashdata('success')){?>
        		<div class="alert alert-success"><?php echo $this->session->flashdata('success')?></div>
        	<?php }?>
        	<!--Alert kalau gagal-->
        	<?php if($this->session->flashdata('error')){?>
        		<div class="alert alert-danger"><?php echo $this->session->flashdata('error')?></div>
        	<?php }?>
              <div class="card-header ">
                <h5 class="card-title"><center>Edit Infaq</center></h5>
				<div class="form-row">
					<div class="form-group col-md-4">
					</div>
					<div class="form-group col-md-4">
						<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/update_data_siswa/'.$NIS)?>">
				
            <label for="inputEmail4">Nama</label>
            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nomor Induk Siswa" value="<?php echo $data->nama?>" required>
            <label for="inputEmail4">Jenis Kelamin</label>
            <select class="custom-select" name="jenis_kelamin" required>
              <option value="Laki laki">Laki laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
            <label for="inputEmail4">Alamat</label>
            <input type="text" class="form-control" name="alamat"  value="<?php echo $data->alamat?>" placeholder="Masukkan Alamat" required>
            <label for="inputEmail4">Tanggal Masuk</label>
            <input type="date" class="form-control" name="tanggal"  value="<?php echo $data->tgl_masuk?>" required>
            <label for="inputEmail4">Status</label>
            <select class="custom-select" name="status" required>
              <option value="Aktif">Aktif</option>
              <option value="Tidak Aktif">Tidak Aktif</option>
            </select>

						</br>
						<div class="col-md-4 offset-md-8"><button type="submit" class="btn btn-primary">Simpan</button></div>
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
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>