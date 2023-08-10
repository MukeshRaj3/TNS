<div class="sidebar col-lg-1">
                <!-- <div class="sidenavbrand">
                    <img src="./images/sidebar/user1.png" alt="">
                </div> -->
                <div class="sidenav-options">
                    <?php if($this->session->userdata('user_type')=='1')
                    {?>
                    <a href="<?php echo base_url('seller/seller/dashboard') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/grid_view.png" alt=""></a>
                    <a href="<?php echo base_url('seller/product') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/grid_view.png" alt=""></a>
                    <a href="<?php echo base_url('seller/subscription') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/grid_view.png" alt=""></a>
                    <!-- <a href="#"><img src="<?php //echo base_url(); ?>assets/images/sidebar/gift.png" alt=""></a> -->
                    <a href="<?php echo base_url('seller/orders') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/upcoming.png" alt=""></a>
                    <a href="<?php echo base_url('seller/seller/transaction_report?type=3'); ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/folder_shared.png" alt=""></a>
                    <a href="<?php echo base_url('seller/profile') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/user2.png" alt=""></a>
                    <a href="#"><img src="<?php echo base_url(); ?>assets/images/sidebar/award.png" alt=""></a>
                <?php }else{?>
                     <a href="<?php echo base_url('seller/seller/dashboard') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/grid_view.png" alt=""></a>
                     <a href="<?php echo base_url('seller/seller/category') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/grid_view.png" alt=""></a>

                     <a href="<?php echo base_url('seller/orders') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/upcoming.png" alt=""></a>
                     <a href="<?php echo base_url('seller/profile') ?>"><img src="<?php echo base_url(); ?>assets/images/sidebar/user2.png" alt=""></a>

                      
                <?php } ?>
                </div>
            </div>