<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<main>
    <?php echo form_open(base_url('enquiry/create'), array('id' => 'enquiry_form', 'class' => 'validate-form', 'enctype' => 'multipart/form-data')); ?>
    <fieldset>

        <div class="home_section2">
            <div class="container">
                <h2>Inquiry Generation</h2>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number number-active"><span>1</span></div>
                            <h3>Basic Details</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number"><span>2</span></div>
                            <h3>Technical Details</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number border-not"><span>3</span></div>
                            <h3>Commercial Details</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="basic-contact-form">
            <div class="container">
                <h2>Basic Details</h2>
                <div class="row">
                    <div class="col-md-6">
                        <label>Requirement Type :</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Product" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Inquiry Type :</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="RFQ" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Industry</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Pulp & Paper" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Category</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Machinery" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Sub Category</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Transmission Equipments" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Product/Service</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Transmission Equipments" /><span class="Gearbox"> </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-button">
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>

        <div class="home_section2">
            <div class="container">
            <h2>Inquiry Generation</h2>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number"><span>1</span></div>
                            <h3>Basic Details</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number number-active"><span>2</span></div>
                            <h3>Technical Details</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number border-not"><span>3</span></div>
                            <h3>Commercial Details</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="basic-contact-form">
            <div class="container">
                <h2>Technical Details</h2>
                <div class="row">
                    <div class="col-md-6">
                        <label>Requirement Type :</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Product" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Inquiry Type :</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="RFQ" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Industry</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Pulp & Paper" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Category</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Machinery" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Sub Category</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Transmission Equipments" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Product/Service</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Transmission Equipments" /><span class="Gearbox"> </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-button">
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>

        <div class="home_section2">
            <div class="container">
            <h2>Inquiry Generation</h2>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number"><span>1</span></div>
                            <h3>Commercial Details</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number"><span>2</span></div>
                            <h3>Technical Details</h3>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div class="home_section2_content">
                            <div class="number number-active border-not"><span>3</span></div>
                            <h3>Commercial Details</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="basic-contact-form">
            <div class="container">
                <h2>Commercial Details</h2>
                <div class="row">
                    <div class="col-md-6">
                        <label>Shipping Address:</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Acceptable Country of Origin</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="" />
                    </div>
                </div>
                <h5>For Domestic Suppliers</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label>Proposed Incoterm</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Proposed Delivery Period</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Warranty Terms & Conditions</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Compliance</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Proposed Payment Term</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <h5>For Domestic Suppliers</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label>Proposed Incoterm</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Proposed Delivery Period</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Warranty Terms & Conditions</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Compliance</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Proposed Payment Term</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" placeholder="" />
                    </div>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <input type="checkbox" id="Negotiable" name="Negotiable" value="Negotiable">
                                <label for="negotiable">Negotiable </label>
                            </li>
                            <li>
                                <input type="checkbox" id="vehicle2" name="Non -negotiable" value="Non -negotiable">
                                <label for="Non -negotiable"> Non -negotiable </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea cols="5" rows="5"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Upload the Documents</label>
                    </div>
                    <div class="col-md-6">
                        <input type="file" placeholder="Drag or choose from device" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Deadline for Commercial Offer</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-button">
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="submit" class="btn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <?php echo form_close(); ?>
</main>