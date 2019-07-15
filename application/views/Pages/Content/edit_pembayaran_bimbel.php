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
                <h5 class="card-title"><center>Edit Pembayaran Bimbel</center></h5>
				<div class="form-row">
					<div class="form-group col-md-4">
					</div>
					<div class="form-group col-md-4">
						<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/update_uang_bimbel/'.$id)?>">
						<label for="inputEmail4">Tahun Ajaran</label>
						<input type="text" class="form-control" name="tahunajaran" placeholder="YYYY/YYYY" value="<?php echo $data->tahun_ajaran?>">
						<label for="inputEmail4">Semester</label>
						<select class="custom-select" name="semester"  selected="<?php echo $data->semester?>" required >
							<option value="Ganjil">Ganjil</option>
							<option value="Genap">Genap</option>
						</select>
						<label for="inputEmail4">Status</label>
						<select class="custom-select" name="status" required">
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
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>