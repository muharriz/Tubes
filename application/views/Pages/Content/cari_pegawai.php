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
        	<?php echo validation_errors();?>
              <div class="card-header ">
                <h5 class="card-title"><center>Lihat Pegawai</center></h5>
				<div class="form-row">
					<div class="form-group col-md-5">
						<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/cari_pegawai')?>">
						<label for="inputEmail4">Nama Pegawai</label>
						<input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Siswa">
					</div>
					<div class="form-group col-md-3">
					</div>
					<div class="form-group col-md-2">
					</div>
					<div class="form-group col-md-2">
						<br/>
						<button type="submit" class="btn btn-primary">Cari</button>
						</form>
					</div>
					</div>
				
					<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uang Pondok</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
										</div>
									<div class="modal-body">
										<div class="form-row">
					<div class="form-group col-md-2">
					</div>
					<div class="form-group col-md-8">
					<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/tambah_uang_pondok')?>">
						<label for="inputEmail4">NIS</label>
						<input type="number" class="form-control" name="nis" placeholder="Input Nomor Induk Siswa">
						<label for="inputEmail4">Bulan</label>
					<select class="form-control" name="bulan">
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
						<label for="inputEmail4">Tahun</label>
						<input type="number" class="form-control" name="tahun" placeholder="Input Tahun">
						</br>
					</div>
					<div class="form-group col-md-2">
					</div>
					</div>
									</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
								</form>
							</div>
									</div>
								</div>
							</div>
						</form>
				</div>
              <div class="card-body ">
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Pegawai ID</th>
								<th scope="col">Nama</th>
								<th scope="col">No Handphone</th>
								<th scope="col">Alamat</th>
								<th scope="col">Level</th>
								<th scope="col">Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($data as $i){?>
								 <tr>
									<td><?php echo $i->pegawai_id; ?></td>
									<td><?php echo $i->nama; ?></td>
									<td><?php echo $i->no_handphone; ?></td>
									<td><?php echo $i->alamat; ?></td>
									<td><?php echo $i->level; ?></td>
									<td><?php echo $i->status; ?></td>
									<td>
										<a class="btn btn-warning"  href="<?php echo base_url('index.php/Pegawai_Controller/halaman_edit_pegawai/').$i->NIS?>">Edit</a>
										<?php if($i->status == 'Aktif'){?>
										<a class="btn btn-warning" href="<?php echo base_url('index.php/Pegawai_Controller/nonaktifkan_pegawai/').$i->NIS?>">Nonaktif</a>
										<?php } ?>
										<?php if($i->status == 'Tidak Aktif'){?>
										<a class="btn btn-success" href="<?php echo base_url('index.php/Pegawai_Controller/aktifkan_pegawai/').$i->NIS?>">Aktifkan</a>
										<?php } ?>
									</td>
								</tr>
								
							<?php } ?>
							
						</tbody>
					</table>
					<center>
					<?php if(isset($pagination)){
						echo $pagination;
					}
						?>
					</center>
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

       