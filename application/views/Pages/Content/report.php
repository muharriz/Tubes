<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title"><center>Report Pengeluaran</center></h5>
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
									<!--Pop up hapus-->
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