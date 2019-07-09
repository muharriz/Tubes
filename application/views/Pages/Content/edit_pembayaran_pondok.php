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
                <h5 class="card-title"><center>Daftar Siswa</center></h5>
				<div class="form-row">
					<div class="form-group col-md-4">
					</div>
					<div class="form-group col-md-4">
						<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/update_uang_pondok/'.$id)?>">
						<label for="inputEmail4">Tahun</label>
						<input type="number" class="form-control" name="tahun" placeholder="Masukkan Nama Siswa" value="<?php echo $data->tahun?>">
						<label for="inputEmail4">Bulan</label>
						<select class="custom-select" name="bulan"  selected="<?php echo $data->bulan?>" required >
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
						<label for="inputEmail4">Status</label>
						<select class="custom-select" name="status" required value="<?php echo $data->status?>">
							<option value="Belum Lunas">Belum Lunas</option>
							<option value="Lunas">Lunas</option>
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
                  <i class="fa fa-history"></i> Updated 3 minutes ago
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>