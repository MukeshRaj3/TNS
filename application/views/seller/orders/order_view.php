<div class="col-md-11 col-lg-11 col-sm-11 padd-1">
   <div>
      <h2>Manage Orders</h2>
   </div>
   <div class="row">
      <div class="col-lg-1 col-md-1 col-sm-12 fields-cont">
         <h6>Order ID</h6>
         <input type="text" value="<?php echo $res['id']; ?>">
      </div>
      <div class="col-lg-2 col-md-2 col-sm-12 fields-cont">
         <h6>Customer Name</h6>
         <input type="text" value="<?php echo $res['customer_address']['first_name'].' '.$res['customer_address']['last_name']; ?>">
      </div>
      <div class="col-lg-5 col-md-5 col-sm-12 fields-cont">
         <h6>Shipping Address</h6>
         <input type="text" value="<?php echo $res['customer_address']['first_name'].' '.$res['customer_address']['address']; ?>">
      </div>
      <div class="col-lg-1 col-md-1 col-sm-12 fields-cont">
         <h6>Payment Mode</h6>
         <input type="text" value="<?php echo $res['payment_method']; ?>">
      </div>
      <div class="col-lg-1 col-md-1 col-sm-12 fields-cont">
         <h6>Stock</h6>
         <input style="color: green;" type="text" value="In">
      </div>
   </div>
   <div class="table-responsive">
      <table class="table mt-5 table-striped" id="view-orders">
         <thead class="mb-4">
            <tr>
               <th scope="col" class="table_head">Product ID</th>
               <th scope="col" class="table_head">Product Name</th>
               <th scope="col" class="table_head">Category</th>
               <th scope="col" class="table_head">Sub-Category</th>
               <th scope="col" class="table_head">Product Image</th>
               <th scope="col" class="table_head">Product Video</th>
               <th scope="col" class="table_head">Amount</th>
            </tr>
         </thead>
         <tbody class="table_body font-bold">
            <?php
               $sub_total=0;
             if(!empty($res['order_details'])){ 
               foreach ($res['order_details'] as $key => $value) 
               {
               ?>
            <tr class="table_tr table-wid">
               <td><?php echo $value->id; ?></td>
               <td><?php echo $value->product_name; ?></td>
               <td><?php echo $value->cat_name; ?></td>
               <td><?php echo $value->cat_sub_name; ?></td>
               <td>
                  <button type="button" class="btn  img-btn" data-bs-toggle="modal"
                     data-bs-target="#exampleModal<?php echo $value->id; ?>">
                  View Image
                  </button>
                  <div class="modal fade fade-background" id="exampleModal<?php echo $value->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered  modal-lg">
                        <div class="modal-content bg-transparent border-0">
                           <div class="modal-header" style="border: none;">
                              <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Image</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                              <div class="row">
                                 <?php if(!empty($value->product_image)){ ?>
                                 <div class="col-lg-4 col-md-4 col-sm-6 col-6 model-img">
                                    <img src="<?php echo $value->product_image; ?>" alt="">
                                    <button type="button" class="btn-close"></button>
                                 </div>
                              <?php } ?>
                                 <!-- <div class="col-lg-4 col-md-4 col-sm-6 col-6 model-img">
                                    <img src="images/pro-back-06 1.png" alt="">
                                    <button type="button" class="btn-close"></button>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-6 col-6 model-img">
                                    <img src="images/pro-back-06 1.png" alt="">
                                    <button type="button" class="btn-close"></button>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-6 col-6 model-img">
                                    <img src="images/pro-back-06 1.png" alt="">
                                    <button type="button" class="btn-close"></button>
                                 </div> -->
                              </div>
                           </div>
                          <!--  <div class="modal-footer" style="border: none;">
                              <button type="button" class="btn" style="background-color: #FFD200;">Add Image</button>
                           </div> -->
                        </div>
                     </div>
                  </div>
               </td>
               <td>
                  <button type="button" class="btn  img-btn" data-bs-toggle="modal"
                     data-bs-target="#exampleModalv<?php echo $value->id; ?>">
                  Play Video
                  </button>
                  <div class="modal fade fade-background" id="exampleModalv<?php echo $value->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered  modal-lg">
                        <div class="modal-content bg-transparent border-0">
                           <div class="modal-header" style="border: none;">
                              <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Video</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                              <div class="video-tag">
                                 <video width="320" height="240" controls>
                                    <?php if(isset($value->video)){ ?>
                                    <source src="<?php echo base_url('images/product/'.$value->video); ?>" type="video/mp4">
                                    <?php } ?>
                                    <source src="movie.ogg" type="video/ogg">
                                    Your browser does not support the video tag.
                                 </video>
                              </div>
                           </div>
                          <!--  <div class="modal-footer" style="border: none;">
                              <button type="button" class="btn" style="background-color: #FFD200;">Change Video</button>
                           </div> -->
                        </div>
                     </div>
                  </div>
               </td>
               <td>Rs.<?php $sub_total+=$value->unit_price; 
               echo $value->unit_price; ?></td>
            </tr>
            <?php } } ?>
         </tbody>
      </table>
   </div>
   <div class="row">
      <div class="col-lg-6">
         <div>
            <h3 class="text-bold" style="color: #0500FF;">Order Summary</h3>
         </div>
         <div>
            <div class="total">
               <p class="sub-total">Item(s) SubTotal:</p>
               <p class="text-bold">Rs.<?php echo $sub_total; ?></p>
            </div>
            <div class="total">
               <p class="sub-total">Shipping:</p>
               <p class="text-bold">Rs.<?php echo $res['delivery_charges']; ?></p>
            </div>
            <div class="total">
               <p class="sub-total">Coupon Discount:</p>
               <p class="text-bold">Rs.-</p>
            </div>
            <hr>
            <div class="total">
               <p class="sub-total">Grand Total:</p>
               <p class="text-bold">Rs.<?php echo $sub_total+$res['delivery_charges']; ?></p>
            </div>
         </div>
      </div>
      <div class="col-lg-6 status-btn">
         <button type="button" class="btn btn-warning"><b>Change Status</b></button>
      </div>
   </div>
</div>
<script>
   $(document).ready(function () {
   
       new DataTable('#view-orders', {
           responsive: true
       });
   });
</script>
