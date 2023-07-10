    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/seller-dashboard.css">
    <div class="col-lg-11 row r1">
                <div class="complete-settle">
                    <div>
                        <h2>
                            Dashboard
                        </h2>
                    </div>
                    <div>
                        <!-- <p>
                            priyandhu garg<br>
                            <span>priyanshugarg@gamil.com</span>
                        </p> -->

                    </div>
                </div>
                <h5 class="text-center mt-2">Total Sales</h5>
                        <h2 class="text-center mt-3">Rs. <?php echo $total_sales[0]['total_order_amt']+$total_sales[0]['total_delivery_charges']; ?></h2>
                <div class="col-lg-12 middle-res">
                    
                    <div class="middle-board">
                        <div class="row mt-5 mb-5">
                            <div class="col-md-3 col-sm-6 col-6">
                                <div class="card mb-3 card-border">
                                    <div class="row g-0">
                                        <div class="col-md-4 col-3 text-center">
                                            <img src="<?php echo base_url(); ?>assets/images/icon.png" class="img-fluid rounded-start mt-2" alt="...">
                                        </div>
                                        <div class="col-md-8 col-9">
                                            <div class="card-body">
                                                <h5 class="card-title">Orders Delivered</h5>
                                                <p class="card-text"><?php echo $previous_total_order; ?>/<?php echo $total_order; ?>.</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <div class="card mb-3 card-border">
                                    <div class="row g-0">
                                        <div class="col-md-4 col-3 text-center">
                                            <img src="<?php echo base_url(); ?>assets/images/icon (1).png" class="img-fluid rounded-start mt-2"
                                                alt="...">
                                        </div>
                                        <div class="col-md-8 col-9">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Orders</h5>
                                                <p class="card-text"><?php echo $total_order; ?>.</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <div class="card mb-3 card-border">
                                    <div class="row g-0">
                                        <div class="col-md-4 col-3 text-center">
                                            <img src="<?php echo base_url(); ?>assets/images/icon (2).png" class="img-fluid rounded-start mt-2"
                                                alt="...">
                                        </div>
                                        <div class="col-md-8 col-9">
                                            <div class="card-body">
                                                <h5 class="card-title">Increase in Orders</h5>
                                                <p class="card-text"><?php echo $total_order-$previous_total_order; ?></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6">
                                <div class="card mb-3 card-border">
                                    <div class="row g-0">
                                        <div class="col-md-4 col-3 text-center">
                                            <img src="<?php echo base_url(); ?>assets/images/icon (3).png" class="img-fluid rounded-start mt-2  "
                                                alt="...">
                                        </div>
                                        <div class="col-md-8 col-9">
                                            <div class="card-body">
                                                <h5 class="card-title">Product Views</h5>
                                                <p class="card-text">10%</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12 months">
                        <h4>Month wise data</h4>
    
                        <div class="graph" id="columnchart_material">
    
    
                        </div>
                    </div>

                </div>
                <!-- <div class="col-lg-3 user">
                   
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <img src="..." class="rounded me-2" alt="...">
                            <strong class="me-auto">Bootstrap</strong>
                            <small>11 mins ago</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Hello, world! This is a toast message.
                        </div>
                    </div>

                </div> -->

              
  </div>
   <script type="text/javascript" src="<?php echo base_url('assets/js/loader.js') ?>"></script>
 <script type="text/javascript">
       

   google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Months Wise','Sales'],
          <?php
            foreach ($total_months_wise_sales as $key => $value) {
             echo $value.',';
            }
           ?>
          
        ]);

        var options = {
          chart: {
            title: 'Company Performance',
            //subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          vAxis: {format: 'decimal'},
          
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>