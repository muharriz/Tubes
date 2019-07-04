<!--SideBar-->
	<div class="sidebar" data-color="white" data-active-color="danger">
	      <!--
	        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
	    -->
	      <div class="logo">
	        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
	          <div class="logo-image-small">
	            <img src="<?php echo base_url()?>/assets/img/logo-small.png">
	          </div>
	        </a>
	        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
	          <?php echo $this->session->userdata('nama_depan')?>
	          <br/>
	          <?php echo $this->session->userdata('pegawai_id')?>
	          <!-- <div class="logo-image-big">
	            <img src="../assets/img/logo-big.png">
	          </div> -->
	        </a>
	      </div>
	      <div class="sidebar-wrapper">
	        <ul class="nav">
	          <li class="active ">
	            <a href="./dashboard.html">
				  <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="nc-icon nc-bank"></i>Pemasukan</a>
					<ul class="collapse list-unstyled" id="pageSubmenu">
						<li>
							<a href="<?php echo base_url('index.php/Pegawai_Controller/uang_spp')?>">Uang Spp</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/Pegawai_Controller/uang_pondok')?>">Uang Pondok</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/Pegawai_Controller/uang_buku')?>">Uang Buku</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/Pegawai_Controller/uang_pembangunan')?>">Uang Pembangunan</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/Pegawai_Controller/uang_bimbel')?>">Uang Bimbel</a>
						</li>
						</ul>
				  </a>
	          </li>
	          <li>
	            <a href="./icons.html">
	              <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="nc-icon nc-diamond"></i>Pengeluaran</a>
					<ul class="collapse list-unstyled" id="pageSubmenu2">
						<li>
							<a href="<?php echo base_url('index.php/Pegawai_Controller/input_pengeluaran')?>">Input Pengeluaran</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/Pegawai_Controller/lihat_pengeluaran')?>">Lihat Pengeluaran</a>
						</li>
						</ul>
				  </a>
	            </a>
	          </li>
	        </ul>
	      </div>
	 </div>
<!--/Sidebar-->