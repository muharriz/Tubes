<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
            	<?php if($this->session->flashdata('success')){?>
        		<div class="alert alert-success"><?php echo $this->session->flashdata('success')?></div>
        	<?php }?>
        	<!--Alert kalau gagal-->
        	<?php if($this->session->flashdata('error')){?>
        		<div class="alert alert-danger"><?php echo $this->session->flashdata('error')?></div>
        	<?php }?>
              <div class="card-header ">
                <h5 class="card-title"><center>Pengeluaran</center></h5>
				<div class="form-row">
					<div class="form-group col-md-5">
						<label for="inputEmail4">Tanggal</label>
						<input type="date" class="form-control" id="tanggal" placeholder="Nomor Induk Siswa">
					</div>
					<div class="form-group col-md-3">
					</div>
					<div class="form-group col-md-2">
					</div>
					<div class="form-group col-md-2">
						</br>
						<button type="button" class="btn btn-primary">Cari</button>
					</div>
					</div>
				</div>
              <div class="card-body">
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Tanggal</th>
								<th scope="col">Jumlah</th>
								<th scope="col">Keterangan</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($data as $i){?>
								 <tr>
									<td><?php echo $i->tgl_dipakai; ?></td>
									<td>Rp <?php echo $i->jumlah; ?></td>
									<td><?php echo $i->keterangan; ?></td>
									<td>
										<!--Tombol Edit-->
										<a class="btn btn-warning" href="<?php echo base_url('index.php/Pegawai_Controller/halaman_edit_pengeluaran/').$i->pengeluaran_id;?>">Edit</a>
										<!--Tombol Hapus-->
										<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?php echo $i->pengeluaran_id?>">Hapus</button>
									</td>
									<!--Pop up hapus-->
									<div class="modal fade" id="exampleModal<?php echo $i->pengeluaran_id?>" tabindex="-1" role="dialog" aria-labelledby="ExampleModallTittle" aria=hidden="true">
										<div class="modal-dialog modal-dialog centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<center>Apakah anda yakin ingin menghapus?</center>
												</div>
												<div class="modal-footer">
													<button class= "btn btn-default" data-dismiss="modal">Close</button>
													&nbsp;<a class="btn btn-danger" href="<?php echo base_url()?>index.php/Pegawai_Controller/hapus_pengeluaran/<?php echo $i->pengeluaran_id;?>">Hapus</a>
												</div>
											</div>
										</div>
									</div>
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