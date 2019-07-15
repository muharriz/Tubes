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
                <h5 class="card-title"><center>Pembayaran Uang Bimbel</center></h5>
				<div class="form-row">
					<div class="form-group col-md-5">
						<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/cari_bimbel')?>">
						<label for="inputEmail4">Nama</label>
						<input type="text" class="form-control" name="nama" id="inputEmail4" placeholder="Nama Siswa">
					</div>
					<div class="form-group col-md-2">
					</div>
					<div class="form-group col-md-2">
						</br>
						<button type="submit" class="btn btn-primary">Cari</button>
						</form>
					</div>
					</div>
					<!-- Button trigger modal -->
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
							Tambah
						</button>

					<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uang Bimbel</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
										</div>
									<div class="modal-body">
										<div class="form-row">
					<div class="form-group col-md-2">
					</div>
					<div class="form-group col-md-8">
					<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/tambah_uang_bimbel')?>">
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
				</div>
              <div class="card-body ">
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">NIS</th>
								<th scope="col">Nama</th>
								<th scope="col">Tahun Ajaran</th>
								<th scope="col">Semester</th>
								<th scope="col">Jumlah Tagihan</th>
								<th scope="col">Status</th>
								<th scope="col">Sisa Pembayaran</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($data as $i){?>
								 <tr>
									<td><?php echo $i->NIS; ?></td>
									<td><?php echo $i->nama; ?></td>
									<td><?php echo $i->tahun_ajaran; ?></td>
									<td><?php echo $i->semester; ?></td>
									<td><?php echo $i->jumlah; ?></td>
									<td><?php echo $i->status; ?></td>
									<td><?php 
												if(is_null($i->jumlah_terbayar))
													echo $i->jumlah;
												else
													echo ($i->jumlah - $i->jumlah_terbayar);
									?></td>
									<td><a class="btn btn-warning" href="<?php echo base_url('index.php/Pegawai_Controller/halaman_edit_uang_bimbel/').$i->pembayaran_id?>">Edit</a>
										<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?php echo $i->pembayaran_id?>">Hapus</button>
										<?php if($i->status != 'Lunas'){?>
										<a class="btn btn-success" href="<?php echo base_url('index.php/Pegawai_Controller/halaman_bayar_uang_bimbel/').$i->pembayaran_id?>">Bayar</a></td>
									<?php } ?>
								</tr>
								<div class="modal fade" id="exampleModal<?php echo $i->pembayaran_id?>" tabindex="-1" role="dialog" aria-labelledby="ExampleModallTittle" aria=hidden="true">
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
												&nbsp;<a class="btn btn-danger" href="<?php echo base_url()?>index.php/Pegawai_Controller/hapus_uang_bimbel/<?php echo $i->pembayaran_id;?>">Hapus</a>
											</div>
										</div>
									</div>
								</div>
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