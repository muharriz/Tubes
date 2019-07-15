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
                <h5 class="card-title"><center>Tagihan</center></h5>
              <div class="card-body ">
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Nama Tagihan</th>
								<th scope="col">Jumlah</th>
								<th scope="col">Keterangan</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($data as $i){?>
								 <tr>
									<td><?php echo $i->nama_tagihan; ?></td>
									<td><?php echo $i->jumlah; ?></td>
									<td><?php echo $i->keterangan_tagihan; ?></td>
									<td>
										<a class="btn btn-warning" href="<?php echo base_url('index.php/Pegawai_Controller/halaman_edit_uang_buku/').$i->tagihan_id?>">Edit</a>	
										</td>
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
												&nbsp;<a class="btn btn-danger" href="<?php echo base_url()?>index.php/Pegawai_Controller/hapus_uang_buku/<?php echo $i->tagihan_id;?>">Hapus</a>
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