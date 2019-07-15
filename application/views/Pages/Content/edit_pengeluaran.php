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
                <h5 class="card-title"><center>Edit Pengeluaran</center></h5>
				<div class="form-row">
					<div class="form-group col-md-4">
					</div>

					<div class="form-group col-md-4">
						<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/update_pengeluaran/'.$id)?>">
						<label for="inputEmail4">Tanggal Dipakai</label>
						<input type="date" class="form-control" name="tanggaldipakai" placeholder="mm-dd-YYYY" value="<?php echo $data->tgl_dipakai?>" required>
						<label for="inputEmail4">Jumlah</label>
						<input type="number" class="form-control" name="jumlah" placeholder="" value="<?php echo $data->jumlah?>" required>
						<label for="inputEmail4">Keterangan</label>
						<input type="text" class="form-control" name="keterangan" placeholder="" value="<?php echo $data->keterangan?>" required>
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