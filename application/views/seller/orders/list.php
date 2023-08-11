<div class="col-md-11 col-lg-11 col-sm-11 padd-1">
            <div class="container-fluid">
                <h1 class="main_headng">Manage Orders</h1>
                <ul class="nav mt-5">
                    <li class="nav-item">
                        <a class="nav-link1 " href="<?php echo base_url('seller/orders') ?>" style="background-color:#FFD200;">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link1" href="<?php echo base_url('seller/orders?status=0') ?>">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link1" href="<?php echo base_url('seller/orders?status=3') ?>">Delivered</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link1" href="<?php echo base_url('seller/orders?payment_status=0') ?>">Payment Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link1" href="<?php echo base_url('seller/orders?status=2') ?>">Cancelled</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link1" href="<?php echo base_url('seller/orders?status=1') ?>">Shipped</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link1" href="<?php echo base_url('seller/orders?status=4') ?>">Returned</a>
                    </li>
                </ul>
                <div class="table-responsive">
                <table class="table mt-5 table-striped" id="manage-orders">
                    <thead class="mb-4">
                        <tr>
                            <th scope="col" class="table_head">ID</th>
                            <th scope="col" class="table_head">Name</th>
                            <th scope="col" class="table_head">MRP</th>
                            <th scope="col" class="table_head">Quantity</th>
                            <th scope="col" class="table_head">Order Date</th>
                            <th scope="col" class="table_head">Delivery Expected Date</th>
                            <th scope="col" class="table_head">Order Status</th>
                            <th scope="col" class="table_head">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table_body ">
                        <?php if(!empty($list)){ 
                                foreach ($list as $key => $value) {
                            ?>
                        <tr class="table_tr table-wid">
                            <td><?php echo $value['id'] ?></td>
                            <td><?php echo $value['first_name'].' '.$value['last_name'] ?></td>
                            <td>Rs. <?php echo $value['unit_price'] ?></td>
                            <td><?php echo $value['item_qty'] ?></td>
                            <td><?php echo date('d/m/Y H:i A',strtotime($value['order_datetime'])) ?></td>
                            <td>-</td>
                            <td style="color:<?php if($value['order_track_status']=='' || $value['order_track_status']=='0'){echo "#2400FF"; }else if($value['order_track_status']=='1'){echo "#FFD200"; }else if($value['order_track_status']=='2'){echo "red"; }else if($value['order_track_status']=='3'){echo "green"; } ?>"><b><?php if($value['order_track_status']=='' || $value['order_track_status']=='0'){echo "Pending"; }else if($value['order_track_status']=='1'){echo "Shipped"; }else if($value['order_track_status']=='2'){echo "Cancelled"; }else if($value['order_track_status']=='3'){echo "Delivered"; } ?></b>
                                
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-info" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border:1px;">
                                    Change Status
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php if($this->session->userdata('user_type')=='2') {?>
                                             <li><a class="dropdown-item" href="javascript:void(0);" onclick="change_status('<?php echo $value['id'] ?>','1');">Accept Order</a></li>
                                        <?php } ?> 

                                        <li><a class="dropdown-item" href="<?php echo base_url('seller/orders/view_orders/'.$value['id']); ?>">View Order</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="change_status('<?php echo $value['id'] ?>','1');">Shipped Order</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="change_status('<?php echo $value['id'] ?>','2');">Cancel Order</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="change_status('<?php echo $value['id'] ?>','3');">Delivered Order</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="change_status('<?php echo $value['id'] ?>','4');">Reject Order</a></li>
                                        <li><a class="dropdown-item" href="<?php echo base_url('seller/orders/settlement/'.$value['id']) ?>">View Settlement</a></li>
                                        <li><a class="dropdown-item" href="#">Order Invoice</a></li>
                                      </ul>
                                  </div>
                            
                            
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script>
          
function change_status(id,status)
{
 if(confirm("Are you sure you want to change status ?")){
  var form_data = new FormData(); 
      form_data.append('id',id);
      form_data.append('status',status);
/*------------------------------------------*/

  jQuery.ajax({
        type: "POST",
                    url: "<?php echo base_url('seller/orders/change_status'); ?>",
                     dataType: 'text', 
                      cache: false,
                      contentType: false,
                      processData: false,
                      data: form_data,  
    
        success: function(res){
            var res_data= JSON.parse(res);
            if(res_data.status==1)
            { 
               alert(res_data.message);
               window.location.reload();
            }else{
              alert(res_data.message);
            }         
        },
        error:function(error,message){
            console.log(message);
        }
      });
  }
}
</script>