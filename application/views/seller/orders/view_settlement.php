    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/delivered.css" />

            <div class="col-lg-11 col-md-11 col-sm-11 padd1">
                <div class="complete-settle">
                    <div>
                        <h2>
                            Complete Settlement for delivered Orders
                        </h2>

                    </div>
                    <div class="email-section">
                        <p>
                            priyandhu garg<br>
                            <span>priyanshugarg@gamil.com</span>
                        </p>

                    </div>

                </div>

                <div class="middle-content">

                    <div class="row">
    
                        <div class="col-lg-6 col-12">
    
                            <div class="comment-thread">
                                <!-- Comment 1 start -->
                                <details open class="comment" id="comment-1">
                                    <a href="#comment-1" class="comment-border-link">
                                        <span class="sr-only">Jump to comment-1</span>
                                    </a>
                                    <summary>
                                        <div class="comment-heading">
                                            <div class="comment-voting">
                                                <button type="button">
                                                    <img src="<?php echo base_url('assets/'); ?>images/Frame 42900.png" alt="">
                                                </button>
                                                
                                            </div>
                                            <div class="comment-info">
                                                <a href="#" class="comment-author">15/06/2023 9:56  <span>
                                                    order placed
                                                </span></a>
                                    
                                            </div>
                                        </div>
                                
                                    </summary>
                                    <summary>
                                        <div class="comment-heading">
                                            <div class="comment-voting">
                                                <button type="button">
                                                    <img src="<?php echo base_url('assets/'); ?>images/Frame 42900.png" alt="">
                                                </button>
                                                
                                            </div>
                                            <div class="comment-info">
                                                <a href="#" class="comment-author">15/06/2023 9:56  <span>
                                                    order placed
                                                </span></a>
                                    
                                            </div>
                                        </div>
                                
                                    </summary>
                                    <summary>
                                        <div class="comment-heading">
                                            <div class="comment-voting">
                                                <button type="button">
                                                    <img src="<?php echo base_url('assets/'); ?>images/Frame 42900.png" alt="">
                                                </button>
                                                
                                            </div>
                                            <div class="comment-info">
                                                <a href="#" class="comment-author">15/06/2023 9:56  <span>
                                                    order placed
                                                </span></a>
                                    
                                            </div>
                                        </div>
                                
                                    </summary>
                                    <summary>
                                        <div class="comment-heading">
                                            <div class="comment-voting">
                                                <button type="button">
                                                    <img src="<?php echo base_url('assets/'); ?>images/Frame 42900.png" alt="">
                                                </button>
                                                
                                            </div>
                                            <div class="comment-info">
                                                <a href="#" class="comment-author">15/06/2023 9:56  <span>
                                                    order placed
                                                </span></a>
                                    
                                            </div>
                                        </div>
                                
                                    </summary>
                                    <summary>
                                        <div class="comment-heading">
                                            <div class="comment-voting">
                                                <button type="button">
                                                    <img src="<?php echo base_url('assets/'); ?>images/Frame 42900.png" alt="">
                                                </button>
                                                
                                            </div>
                                            <div class="comment-info">
                                                <a href="#" class="comment-author">15/06/2023 9:56  <span>
                                                    order placed
                                                </span></a>
                                    
                                            </div>
                                        </div>
                                
                                    </summary>
                                    <summary>
                                        <div class="comment-heading">
                                            <div class="comment-voting">
                                                <button type="button">
                                                    <img src="<?php echo base_url('assets/'); ?>images/Frame 42900.png" alt="">
                                                </button>
                                                
                                            </div>
                                            <div class="comment-info">
                                                <a href="#" class="comment-author">15/06/2023 9:56  <span>
                                                    order placed
                                                </span></a>
                                    
                                            </div>
                                        </div>
                                
                                    </summary>
                                </details>
                                <!-- Comment 1 end -->
                            </div>
                        </div>
                       
                        <div class="col-lg-6 col-12" >
                            <?php if(!empty($res['order_details'])){
                              foreach ($res['order_details'] as $key => $value) { ?>
                           <p>   
                            <div class="image-section border border-primary">

                                <div>
                                    <img width="100px;" height="100px;" src="<?php echo $value->product_image; ?>" alt="">
                                </div>
                                <div class="image-details">

                                    <h5><?php echo $value->product_name; ?></h5>
                                    <p>Rs.<?php echo $value->unit_price; ?></p>
                                    <p>
                                        <?php echo $value->description; ?>
                                    </p>
                                    <h5>Quantity : <?php echo $value->product_qty; ?></h5>
                                </div>
                            </div>
                         </p>
    
                            <?php } } ?>
                        </div>
                    </div>
                </div>

            </div>
       