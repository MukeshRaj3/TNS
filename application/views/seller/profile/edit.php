    <div class="col-md-11 col-lg-11 col-sm-11 " style="margin-bottom: 4rem;">
            <div class="heading">
                Profile
            </div>
             
            <div class="details">
                <form action="<?php echo base_url('seller/profile/edit'); ?>" method="post" enctype="multipart/form-data">
                     <?php if ($this->session->flashdata('message') !== NULL) { ?>

                <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible">

                <?php echo $this->session->flashdata('message')['1']; ?>


                </div>
                
            <?php } ?>
                    <div class="user-image">
                        <img src="<?php echo base_url('assert/'); ?>images/user_logo.png" alt="">
                        <div class="mb-3 user-image-input">
                            <label for="image" class="form-label">Choose Another</label><br>
                            <input type="file" name="profile_pic" class="image-input" id="image">
                         
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 fields">
                            <div class="mb-3 ">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $res->seller_name ?>">
                                <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                                
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $res->dob ?>">
                                <?php echo form_error('dob', '<div class="error">', '</div>'); ?>

                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email ID</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo $res->email_id ?>">
                                <?php echo form_error('email', '<div class="error">', '</div>'); ?>

                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="number" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" name="mobile_no" id="number" value="<?php echo $res->mobile_no ?>">
                                <?php echo form_error('mobile_no', '<div class="error">', '</div>'); ?>

                            </div>
                        </div>


                    </div>
                    <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <label for="document" class="form-label">GSTN No.</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="gstin"  aria-label="Recipient's username"
                                aria-describedby="button-addon2">
                          
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Farm Name.</label>
                            <input type="text" class="form-control" name="farm_name " id="name" value="<?php echo $res->farm_name  ?>">

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Gumasta MSME</label>
                            <input type="text" class="form-control" name="gumasta_msme" id="name" value="<?php echo $res->gumasta_msme;  ?>">

                        </div>
                    </div>
                  
                     <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <label for="document" class="form-label">PAN Card</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="pan"  aria-label="Recipient's username"
                                aria-describedby="button-addon2">
                            
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="document" class="form-label">Seller Document</label>
                                <input type="file" class="form-control" name="id_document" id="document">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="id" class="form-label">Personal ID Proof</label>
                                <input type="file" class="form-control" name="id_proof" id="id">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address Proof</label>
                                <input type="file" class="form-control" name="address_proof" name="address_proof" id="address" >
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="address" class="form-label">Personal Address</label>
                                <input type="text" class="form-control" name="address" id="address" value="<?php echo $res->address ?>">
                                <?php echo form_error('address', '<div class="error">', '</div>'); ?>

                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="address" class="form-label">Pin Code</label>
                                <input type="number" class="form-control" name="address_pin_code" id="address" value="<?php echo $res->address_pin_code ?>">
                                <?php echo form_error('address_pin_code', '<div class="error">', '</div>'); ?>

                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="address" class="form-label">Shop Address</label>
                                <input type="text" class="form-control" name="shop_address" id="address" value="<?php echo $res->shop_address ?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 fields">
                            <div class="mb-3">
                                <label for="address" class="form-label">Pin Code</label>
                                <input type="number" class="form-control" name="shop_address_pin_code" id="address" value="<?php echo $res->shop_address_pin_code ?>">
                            </div>
                        </div>


                    </div>
                       <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Bank Name</label>
                            <input type="text" class="form-control" name="bank_name" id="name" value="<?php echo $res->bank_name ?>">

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">A/C No.</label>
                            <input type="text" class="form-control" name="account_number " id="name" value="<?php echo $res->account_number  ?>">

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Branch Name</label>
                            <input type="text" class="form-control" name="branch_name" id="name" value="<?php echo $res->branch_name ?>">

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">IFSC Code</label>
                            <input type="text" class="form-control" name="ifsc_code" id="name" value="<?php echo $res->ifsc_code ?>">

                        </div>
                    </div>
                </div>
                    <button type="submit" class="btn btn-warning save-btn">Save</button>
            </div>
            </form>

        </div>