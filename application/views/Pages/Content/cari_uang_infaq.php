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
        	<div class="alert alert-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Mencari donatur bernama '<?php echo $nama;?>'</div>
              <div class="card-header ">
                <h5 class="card-title"><center>Uang Infaq</center></h5>
				<div class="form-row">
					<div class="form-group col-md-5">
						<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/cari_infaq')?>">
						<label for="inputEmail4">Nama Donatur</label>
						<input type="text" class="form-control" name ="nama" id="inputEmail4" placeholder="Nama Donatur">
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
											<h5 class="modal-title" id="exampleModalLabel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uang Pembangunan</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
										</div>
									<div class="modal-body">
										<div class="form-row">
					<div class="form-group col-md-2">
					</div>
					<div class="form-group col-md-8">
					<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/tambah_uang_infaq')?>">
						<label for="inputEmail4">Nama Lengkap Donatur</label>
							<input type="text" class="form-control" name="namalengkap" placeholder="Nama Lengkap Donatur" required>
						<label for="inputEmail4">Jumlah</label>
							<input type="number" class="form-control" name="jumlah" placeholder="" required>
						<label for="inputEmail4">Tanggal Diterima</label>
							<input type="date" class="form-control" name="tanggalditerima" placeholder="mm-dd-YYYY" required>
						<label for="inputEmail4">Keterangan</label>
							<input type="text" class="form-control" name="keterangan" placeholder="Keterangan Infaq" required>
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
								<th scope="col">Nama Donatur</th>
								<th scope="col">Jumlah</th>
								<th scope="col">Tanggal Diterima</th>
								<th scope="col">Penerima</th>
								<th scope="col">Keterangan</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($data as $i){?>
								 <tr>
									<td><?php echo $i->nama_lengkap; ?></td>
									<td><?php echo $i->jumlah; ?></td>
									<td><?php echo $i->tanggal_diterima; ?></td>
									<td><?php echo $i->nama_pegawai; ?></td>
									<td><?php echo $i->keterangan; ?></td>
									<td>
										<a class="btn btn-warning" href="<?php echo base_url('index.php/Pegawai_Controller/halaman_edit_uang_infaq/').$i->donatur_id?>">Edit</a>	
										
										<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?php echo $i->donatur_id?>">Hapus</button>
			
								</tr>
								<div class="modal fade" id="exampleModal<?php echo $i->donatur_id?>" tabindex="-1" role="dialog" aria-labelledby="ExampleModallTittle" aria-hidden="true">
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
												&nbsp;<a class="btn btn-danger" href="<?php echo base_url()?>index.php/Pegawai_Controller/hapus_uang_infaq/<?php echo $i->donatur_id;?>">Hapus</a>
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
         
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>