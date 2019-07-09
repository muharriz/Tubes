<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title"><center>Pembayaran Uang Buku</center></h5>
				<div class="form-row">
					<div class="form-group col-md-5">
						<label for="inputEmail4">NIS</label>
						<input type="email" class="form-control" id="inputEmail4" placeholder="Nomor Induk Siswa">
					</div>
					<div class="form-group col-md-3">
						<label for="inputPassword4">Kelas</label>
						<select class="custom-select" required>
							<option value="">Pilih Kelas</option>
							<option value="1">Tujuh</option>
							<option value="2">Delapan</option>
							<option value="3">Sembilan</option>
						</select>
					</div>
					<div class="form-group col-md-2">
					</div>
					<div class="form-group col-md-2">
						</br>
						<button type="button" class="btn btn-primary">Cari</button>
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
					<form method="post" action="<?php echo base_url('index.php/Pegawai_Controller/tambah_uang_buku')?>">
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
									<td><a class="btn btn-warning">Edit</a>&nbsp;<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModall">Hapus</button>&nbsp;
										<?php if($i->status != 'Lunas'){?>
										<a class="btn btn-success" href="<?php echo base_url('index.php/Pegawai_Controller/halaman_bayar_uang_buku/').$i->pembayaran_id?>">Bayar</a></td>
									<?php } ?>
								</tr>
								<div class="modal fade" id="exampleModall" tabindex="-1" role="dialog" aria-labelledby="ExampleModallTittle" aria=hidden="true">
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
												&nbsp;<a class="btn btn-danger" href="<?php echo base_url()?>index.php/Pegawai_Controller/hapus_uang_buku/<?php echo $i->pembayaran_id;?>">Hapus</a>
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