    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/transaction_report.css">
    <style type="text/css">
        button.btn-space {
        margin-left: 1em;
    }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
   
    <div class="col-lg-11 row r1">
                <div class="complete-settle">
                    <div>
                        <h2>
                            Order Report
                        </h2>
                    </div>
                    <div>
                        <!-- <p>
                            priyandhu garg<br>
                            <span>priyanshugarg@gamil.com</span>
                        </p> -->

                    </div>
                </div>
    <table id="example" class="display nowrap" style="width:100%">
        <thead>
        
            <tr>
                <th>S.No.</th>
                <th>Order no</th>
                <th>Order person name</th>
                <th>Billing name</th>
               <!--  <th>Billing address</th> -->
                <th>GST</th>
                <th>Order amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(!empty($transaction_report)){
                foreach ($transaction_report as $key => $value) {
            ?>
            <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $value['order_no'] ?></td>
                <td><?php echo $value['first_name'] ?></td>
                <td><?php echo $value['billing_fname'].' '.$value['billing_lname'] ?></td>
                <!-- <td><?php //echo $value['address'] ?></td> -->
                <td><?php echo $value['tax'] ?></td>
                <td><?php echo $value['total_order_amt']+$value['tax'] ?></td>
            </tr>
           <?php } } ?>
        </tbody>
    </table>      
  </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url('assets/js/loader.js') ?>"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

   <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
   <script type="text/javascript">
       $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    })
   </script>
