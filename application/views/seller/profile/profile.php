   <div class="col-md-11 col-lg-11 col-sm-11 bottom-mar ">
            <div class="heading">
                Profile
            </div>
            <div class="details">

                <div class="user-image">
                    <img src="images/wrap.png" alt="">
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="" class="form-control" id="name"  value="<?php echo $res->seller_name ?>" disabled>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-12 fields">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" value="<?php echo $res->dob ?>" disabled>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="email" value="<?php echo $res->email_id ?>" disabled>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 fields">
                        <div class="mb-3">
                            <label for="number" class="form-label">Phone Number</label>
                            <input type="number" class="form-control" id="number" value="<?php echo $res->mobile_no ?>" disabled>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <label for="document" class="form-label">GSTN No.</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo str_replace("upload/users/seller/gstin/","",$res->gstin)  ?>" aria-label="Recipient's username"
                                aria-describedby="button-addon2" disabled>
                            <a target="_blank" href="<?php echo base_url().$res->gstin ?>" class="btn btn-warning" type="button" id="button-addon2">View</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Farm Name.</label>
                            <input type="text" class="form-control" name="farm_name " id="name" value="<?php echo $res->farm_name  ?>" disabled>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Gumasta MSME</label>
                            <input type="text" class="form-control" name="gumasta_msme" id="name" value="<?php echo $res->gumasta_msme;  ?>" disabled>

                        </div>
                    </div>
                  
                     <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <label for="document" class="form-label">PAN Card</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo str_replace("upload/users/seller/pan/","",$res->pan)  ?>" aria-label="Recipient's username"
                                aria-describedby="button-addon2" disabled>
                            <a target="_blank" href="<?php echo base_url().$res->pan ?>" class="btn btn-warning" type="button" id="button-addon2">View</a>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <label for="document" class="form-label">Seller Document</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo str_replace("uploads/users/seller/id_document/","",$res->id_document)  ?>" aria-label="Recipient's username"
                                aria-describedby="button-addon2" disabled>
                            <a target="_blank" href="<?php echo base_url().$res->id_document ?>" class="btn btn-warning" type="button" id="button-addon2">View</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <label for="id" class="form-label">Personal ID Proof</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo str_replace("uploads/users/seller/id_proof/","",$res->id_proof)  ?>" 
                              aria-label="Recipient's username"
                                aria-describedby="button-addon2" disabled>
                            <a target="_blank" href="<?php echo base_url().$res->id_proof ?>" class="btn btn-warning" type="button" id="button-addon2">View</a>
                        </div>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 fields">

                        <label for="address" class="form-label">Address Proof</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo str_replace("uploads/users/seller/address_proof/","",$res->address_proof)  ?>" 
                              aria-label="Recipient's username"
                                aria-describedby="button-addon2" disabled>
                            <a target="_blank" href="<?php echo base_url().$res->address_proof ?>" class="btn btn-warning" type="button" id="button-addon2">View</a>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12 fields">
                        <div class="mb-3">
                            <label for="address" class="form-label">Personal Address</label>
                            <input type="text" class="form-control" id="address"
                                value="<?php echo $res->address ?>" disabled>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <div class="mb-3">
                            <label for="address" class="form-label">Pin Code</label>
                            <input type="number" class="form-control" id="address" value="<?php echo $res->address_pin_code ?>" disabled>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 fields">
                        <div class="mb-3">
                            <label for="address" class="form-label">Shop Address</label>
                            <input type="text" class="form-control" id="address"
                                value="<?php echo $res->shop_address ?>" disabled>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 fields">
                        <div class="mb-3">
                            <label for="address" class="form-label">Pin Code</label>
                            <input type="number" class="form-control" id="address" value="<?php echo $res->shop_address_pin_code ?>" disabled>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Bank Name</label>
                            <input type="text" class="form-control" name="bank_name" id="name" value="<?php echo $res->bank_name ?>" disabled>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">A/C No.</label>
                            <input type="text" class="form-control" name="account_number " id="name" value="<?php echo $res->account_number  ?>" disabled>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">Branch Name</label>
                            <input type="text" class="form-control" name="branch_name" id="name" value="<?php echo $res->branch_name ?>" disabled>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 fields">
                        <div class="mb-3 ">
                            <label for="name" class="form-label">IFSC Code</label>
                            <input type="text" class="form-control" name="ifsc_code" id="name" value="<?php echo $res->ifsc_code ?>" disabled>

                        </div>
                    </div>
                </div>    
                <a href="<?php echo base_url('seller/profile/edit'); ?>" class="btn btn-warning save-btn">Edit</a>
            </div>


        </div>