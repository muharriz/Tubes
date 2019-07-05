<div class="row">
          <div class="col-lg-12 col-md-4 col-sm-6">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card ">
              <div class="card-header ">
				<center><img src="<?php echo base_url('assets/img/user1.png')?>" width="200px" height="200px">
				<h5 class="card-title">User</h5>
                <p class="card-category">12 User</p></center>
              </div>
            </div>
          </div>
		  <div class="col-md-4">
            <div class="card ">
              <div class="card-header ">
                <center><img src="<?php echo base_url('assets/img/guru.png')?>" width="200px" height="200px">
				<h5 class="card-title">Guru</h5>
                <p class="card-category">57 Guru</p></center>
              </div>
            </div>
          </div>
		  <div class="col-md-4">
            <div class="card ">
              <div class="card-header ">
                <center><img src="<?php echo base_url('assets/img/murid.png')?>" width="200px" height="200px">
				<h5 class="card-title">Murid</h5>
                <p class="card-category">351 Murid</p></center>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Email Statistics</h5>
                <p class="card-category">Last Campaign Performance</p>
              </div>
              <div class="card-body ">
                <canvas id="chartEmail"></canvas>
              </div>
              <div class="card-footer ">
                <div class="legend">
                  <i class="fa fa-circle text-primary"></i> Opened
                  <i class="fa fa-circle text-warning"></i> Read
                  <i class="fa fa-circle text-danger"></i> Deleted
                  <i class="fa fa-circle text-gray"></i> Unopened
                </div>
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar"></i> Number of emails sent
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-title">NASDAQ: AAPL</h5>
                <p class="card-category">Line Chart with Points</p>
              </div>
              <div class="card-body">
                <canvas id="speedChart" width="400" height="100"></canvas>
              </div>
              <div class="card-footer">
                <div class="chart-legend">
                  <i class="fa fa-circle text-info"></i> Tesla Model S
                  <i class="fa fa-circle text-warning"></i> BMW 5 Series
                </div>
                <hr/>
                <div class="card-stats">
                  <i class="fa fa-check"></i> Data information certified
                </div>
              </div>
            </div>
          </div>
        </div>