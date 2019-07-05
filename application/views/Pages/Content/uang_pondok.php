<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title"><center>Pembayaran Uang Pondok</center></h5>
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
						<label for="inputEmail4">NISN</label>
						<input type="text" class="form-control" id="tanggal" placeholder="Masukkan Nomor Induk Siswa">
						<label for="inputEmail4">Jumlah</label>
						<input type="text" class="form-control" id="tanggal" placeholder="Masukkan Nama Siswa">
						<label for="inputEmail4">Tanggal</label>
						<input type="date" class="form-control" id="tanggal">
						</br>
					</div>
					<div class="form-group col-md-2">
					</div>
					</div>
									</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary">Save changes</button>
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
								<th scope="col">Tahun</th>
								<th scope="col">Bulan</th>
								<th scope="col">Jumlah Tagihan</th>
								<th scope="col">Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($data as $i){?>
								 <tr>
									<td><?php echo $i->nis; ?></td>
									<td><?php echo $i->nama; ?></td>
									<td><?php echo $i->tahun; ?></td>
									<td><?php echo $i->bulan; ?></td>
									<td><?php echo $i->jumlah; ?></td>
									<td><?php echo $i->status; ?></td>
									<td><span class="btn btn-warning">Edit</span>&nbsp;<span class="btn btn-danger">Hapus</span></td>
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