<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url()?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    SISTEM KEUANGAN TERPADU
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/tabulator/dist/css/tabulator.min.css" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url()?>assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <?php  $this->load->view('Pages/Layout/sidebar')?>
    <div class="main-panel">
      <?php  $this->load->view('Pages/Layout/navbar')?>
      <!-- <div class="panel-header panel-header-lg">
  
  <canvas id="bigDashboardChart"></canvas>
  
  
</div> -->
      <div class="content">
          <!--Alert Jika username atau password salah-->
          <?php if($this->session->flashdata('greet')){ ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('greet');?></div>
          <?php } ?>
          <!--/Alert Jika username atau password salah-->
          <?php $this->load->view('Pages/Content/'.$this->session->userdata('halaman')); ?>
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                <li>
                  <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>
                </li>
                <li>
                  <a href="http://blog.creative-tim.com/" target="_blank">Blog</a>
                </li>
                <li>
                  <a href="https://www.creative-tim.com/license" target="_blank">Licenses</a>
                </li>
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                ©
                <script>
                  document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i> by Creative Tim
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?php echo base_url()?>assets/js/core/jquery.min.js"></script>
  <script src="<?php echo base_url()?>assets/js/core/popper.min.js"></script>
  <script src="<?php echo base_url()?>assets/js/core/bootstrap.min.js"></script>
  <script src="<?php echo base_url()?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Tabulator JS -->
  <script src="<?php echo base_url()?>assets/tabulator/dist/js/tabulator.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url()?>assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url()?>assets/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url()?>assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>
</body>

</html>