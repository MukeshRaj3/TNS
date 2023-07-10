<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">

                        </div>
                        <h4 class="page-title"><?php echo $pagetitle; ?></h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <?php if ($this->session->flashdata('message') !== NULL) { ?>
                <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible">
                <?php echo $this->session->flashdata('message')['1']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12">
                    <?php echo form_open(base_url('seller/home/profile'), array('id' => 'update_profile', 'class' => 'validate-form','enctype' => 'multipart/form-data' )); ?>
                    <div class="card">
						<div class="card-header bg-white"><h2>Company</h2> </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="change_image">Company Logo</label>
											<input type="file" name="image" accept="image/*" class="form-control-file" id="change_image">
											<div id="error" class="text-danger"><?php if (!empty($custom_error)) {echo $custom_error;}  ?></div>
										</div>
                                        <?php if (!empty($profile->image)) { ?>
                                            <img src="<?php echo base_url($profile->image) ?>" width="80" height="80" alt="">
                                        <?php } ?>

									</div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="emailaddress" class="form-label">Company Type*</label>
                                        <select name="company_type" id="company_type" class="form-control" >
                                            <option value="">Select Company Type</option>
                                            <?php foreach ($company_types as $type):
                                                if ($type->id == $profile->company_type) { ?>
                                                    <option value="<?php echo $type->id ?>" selected><?php echo $type->name ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
                                                <?php }
                                                ?>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="error"><?php echo form_error('company_type'); ?></div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="company_type" class="form-label">Company Name</label>
                                            <input name="full_name" value="<?php echo $profile->full_name; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Company Name">
                                            <div id="error" class="text-danger"><?php echo form_error('full_name'); ?></div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Address" class="form-label">Address</label>
                                        <div class="map-search-box">
                                            <input name="address" id="Address" value="<?php echo $profile->address; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Address">
                                            <div id="error" class="text-danger"><?php echo form_error('address'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="City" class="form-label">City</label>
                                        <div class="map-search-box">
                                            <input name="city" id="City" value="<?php echo $profile->city; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter City">
                                            <div id="error" class="text-danger"><?php echo form_error('city'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="district" class="form-label">District</label>
                                        <div class="map-search-box">
                                            <input name="district" id="district" value="<?php echo $profile->district; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter district">
                                            <div id="error" class="text-danger"><?php echo form_error('district'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="state" class="form-label">State</label>
                                        <div class="map-search-box">
                                            <input name="state" id="state" value="<?php echo $profile->state; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter State">
                                            <div id="error" class="text-danger"><?php echo form_error('state'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Country" class="form-label">Country</label>
                                        <div class="map-search-box">
                                            <input name="country" id="Country" value="<?php echo $profile->country; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Country">
                                            <div id="error" class="text-danger"><?php echo form_error('country'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Pincode" class="form-label">Pincode</label>
                                        <div class="map-search-box">
                                            <input name="pincode" id="Pincode" value="<?php echo $profile->pincode; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Pincode">
                                            <div id="error" class="text-danger"><?php echo form_error('pincode'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
						<div class="card-header bg-white"><h2>Company Details</h2> </div>
                        <div class="card-body">
                            <div class="row">
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Mobile</label>
                                        <div class="map-search-box">
                                            <input name="phone" value="<?php echo $profile->phone; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Phone Number">
                                            <div id="error" class="text-danger"><?php echo form_error('phone'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email*</label>
                                        <div class="map-search-box">
                                            <input name="email" readonly id="email" value="<?php echo $profile->email; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter email">
                                            <div id="error" class="text-danger"><?php echo form_error('email'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="telephone" class="form-label">Tele Phone</label>
                                        <div class="map-search-box">
                                            <input name="telephone" id="telephone" value="<?php echo $profile->telephone; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter telephone">
                                            <div id="error" class="text-danger"><?php echo form_error('telephone'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="fax_number" class="form-label">Fax Number*</label>
                                        <div class="map-search-box">
                                            <input name="fax_number" id="fax_number" value="<?php echo $profile->fax_number; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter fax_number">
                                            <div id="error" class="text-danger"><?php echo form_error('fax_number'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="contact_person" class="form-label">Contact Person</label>
                                        <div class="map-search-box">
                                            <input name="contact_person" id="contact_person" value="<?php echo $profile->contact_person; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Contact Person">
                                            <div id="error" class="text-danger"><?php echo form_error('contact_person'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="designation" class="form-label">Designation</label>
                                        <div class="map-search-box">
                                            <input name="designation" id="designation" value="<?php echo $profile->designation; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Designation">
                                            <div id="error" class="text-danger"><?php echo form_error('designation'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="card">
						<div class="card-header bg-white"><h2>Tax Details</h2> </div>
                        <div class="card-body">
                            <div class="row">
                            <div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="gstin" class="form-label">GSTIN</label>
                                        <div class="map-search-box">
                                            <input name="gstin" value="<?php echo $tax_details->gstin; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter GSTIN No">
                                            <div id="error" class="text-danger"><?php echo form_error('gstin'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="gstin_image">Upload Doc</label>
											<input type="file" name="gstin_doc" class="form-control-file" id="gstin_image">
											<div id="error" class="text-danger"><?php if (!empty($gstin_error)) {echo $gstin_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($tax_details->gstin_doc) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="pan" class="form-label">PAN</label>
                                        <div class="map-search-box">
                                            <input name="pan" id="pan" value="<?php echo $tax_details->pan; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter PAN">
                                            <div id="error" class="text-danger"><?php echo form_error('pan'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="pan_image">Upload Doc</label>
											<input type="file" name="pan_doc" class="form-control-file" id="pan_image">
											<div id="error" class="text-danger"><?php if (!empty($pan_error)) {echo $pan_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($tax_details->pan_doc) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="tan" class="form-label">TAN</label>
                                        <div class="map-search-box">
                                            <input name="tan" id="tan" value="<?php echo $tax_details->tan; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter TAN No">
                                            <div id="error" class="text-danger"><?php echo form_error('tan'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="tan_image">Upload Doc</label>
											<input type="file" name="tan_doc" class="form-control-file" id="tan_image">
											<div id="error" class="text-danger"><?php if (!empty($tan_error)) {echo $tan_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($tax_details->tan_doc) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="tds" class="form-label">TDS</label>
                                        <div class="map-search-box">
                                            <input name="tds" id="tds" value="<?php echo $tax_details->tds; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter TDS No">
                                            <div id="error" class="text-danger"><?php echo form_error('tds'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="tds_image">Upload Doc</label>
											<input type="file" name="tds_doc" class="form-control-file" id="tds_image">
											<div id="error" class="text-danger"><?php if (!empty($tds_error)) {echo $tds_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($tax_details->tds_doc) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="msme" class="form-label">MSME</label>
                                        <div class="map-search-box">
                                            <input name="msme" id="msme" value="<?php echo $tax_details->msme; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter MSME No">
                                            <div id="error" class="text-danger"><?php echo form_error('msme'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="msme_image">Upload Doc</label>
											<input type="file" name="msme_doc" class="form-control-file" id="msme_image">
											<div id="error" class="text-danger"><?php if (!empty($msme_error)) {echo $msme_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($tax_details->msme_doc) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="card">
						<div class="card-header bg-white"><h2>Turn Over</h2> </div>
                        <div class="card-body">
                            <div class="row">
								<div class="filedContent col-12 animated zoomUp">
                                    <div class="form-group">
                                        <label for="emailaddress" class="form-label">Company Type*</label>
                                        <select name="business_type" id="business_type" class="form-control" >
                                            <option value="">Select Company Type</option>
                                            <?php foreach ($company_types as $type):
                                                if ($type->id == $profile->company_type) { ?>
                                                    <option value="<?php echo $type->id ?>" selected><?php echo $type->name ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
                                                <?php }
                                                ?>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="error"><?php echo form_error('business_type'); ?></div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="company_type" class="form-label">Company Name*</label>
                                        <div class="map-search-box">
                                            <input name="full_name" value="<?php echo $profile->full_name; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Company Name">
                                            <div id="error" class="text-danger"><?php echo form_error('full_name'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="change_image">Change City Image</label>
											<input type="file" name="image" class="form-control-file" id="change_image">
											<div id="error" class="text-danger"><?php if (!empty($custom_error)) {echo $custom_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($profile->image) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Address" class="form-label">Address*</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="Address" value="<?php echo $profile->address; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Address">
                                            <div id="error" class="text-danger"><?php echo form_error('full_name'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="change_image">Change City Image</label>
											<input type="file" name="image" class="form-control-file" id="change_image">
											<div id="error" class="text-danger"><?php if (!empty($custom_error)) {echo $custom_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($profile->image) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="City" class="form-label">City</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="City" value="<?php echo $profile->city; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter City">
                                            <div id="error" class="text-danger"><?php echo form_error('city'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="change_image">Change City Image</label>
											<input type="file" name="image" class="form-control-file" id="change_image">
											<div id="error" class="text-danger"><?php if (!empty($custom_error)) {echo $custom_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($profile->image) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="card">
						<div class="card-header bg-white"><h2>Bank Details</h2> </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="filedContent col-6 animated zoomUp">
									<div class="row">
										<div class="form-group col-6">
											<label for="change_image">Change City Image</label>
											<input type="file" name="image" class="form-control-file" id="change_image">
											<div id="error" class="text-danger"><?php if (!empty($custom_error)) {echo $custom_error;}  ?></div>
										</div>
										<div class="col-6">
											<img src="<?php echo base_url($profile->image) ?>" width="80" height="80" alt="">
										</div>

									</div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="emailaddress" class="form-label">Company Type*</label>
                                        <select name="business_type" id="business_type" class="form-control" >
                                            <option value="">Select Company Type</option>
                                            <?php foreach ($company_types as $type):
                                                if ($type->id == $profile->company_type) { ?>
                                                    <option value="<?php echo $type->id ?>" selected><?php echo $type->name ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
                                                <?php }
                                                ?>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="error"><?php echo form_error('business_type'); ?></div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="company_type" class="form-label">Company Name*</label>
                                        <div class="map-search-box">
                                            <input name="full_name" value="<?php echo $profile->full_name; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Company Name">
                                            <div id="error" class="text-danger"><?php echo form_error('full_name'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Address" class="form-label">Address*</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="Address" value="<?php echo $profile->address; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Address">
                                            <div id="error" class="text-danger"><?php echo form_error('full_name'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Address" class="form-label">Address*</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="Address" value="<?php echo $profile->address; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Address">
                                            <div id="error" class="text-danger"><?php echo form_error('full_name'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Address" class="form-label">Address*</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="Address" value="<?php echo $profile->address; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Address">
                                            <div id="error" class="text-danger"><?php echo form_error('full_name'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="City" class="form-label">City</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="City" value="<?php echo $profile->city; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter City">
                                            <div id="error" class="text-danger"><?php echo form_error('city'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="state" class="form-label">State</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="state" value="<?php echo $profile->state; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter State">
                                            <div id="error" class="text-danger"><?php echo form_error('state'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Country" class="form-label">Country</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="Country" value="<?php echo $profile->country; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Country">
                                            <div id="error" class="text-danger"><?php echo form_error('country'); ?></div>
                                        </div>
                                    </div>
                                </div>
								<div class="filedContent col-6 animated zoomUp">
                                    <div class="form-group">
                                        <label for="Pincode" class="form-label">Pincode</label>
                                        <div class="map-search-box">
                                            <input name="full_name" id="Pincode" value="<?php echo $profile->pincode; ?>" onkeydown="return event.key != 'Enter';" class="form-control" type="text" placeholder="Enter Country">
                                            <div id="error" class="text-danger"><?php echo form_error('pincode'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="col-lg-12 m-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <!-- end col -->
            </div>
            <!-- end row-->
        </div> <!-- container -->
    </div> <!-- content -->
</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->
