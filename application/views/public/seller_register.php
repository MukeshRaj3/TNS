 <style type="text/css">
     body {
    font-family: 'Poppins', sans-serif;
}

.sign_up-div-1 {
    box-shadow: 0px 4px 40px 0px rgba(0, 0, 0, 0.25);
    border-radius: 15px;
    text-align: center;
    margin: 2rem auto;
    padding: 2rem;
}

.sign_up-div-1 h1 {
    font-weight: 700;
    margin: 1rem 0;
}

.sign_up-div-1 h4 {
    font-size: 1.2rem;
    color: #9B9B9B;
}

.register-input {
    text-align: start;
    width: 49%;
    margin: 1rem 0;
}

.register-input label {
    font-weight: 600;
    margin-bottom: .5rem;
}

.register-input input:focus {
    border: 1px solid #FFD200 !important;
    box-shadow: none !important;

}

.register-input select:focus {
    border: 1px solid #FFD200 !important;
    box-shadow: none !important;

}

.input-span {
    color: #9B9B9B;
    font-weight: 400;
}

.input-group-text {
    background-color: white !important;
    border-right: none;
    border: 1px solid #909090;
}

.input-grp {
    border-left: none !important;
}

.input-grp2 {
    border-right: none !important;
    border-left: none !important;
}

.input-btn {
    border-radius: 0 3px 3px 0!important;
    background-color: #FFD200 !important;
    color: black !important;
    font-weight: 600 !important;
    border: none !important;
}

.register-input2 {
    width: 100%;
    text-align: start;
    margin-bottom: 2rem; 
}

.register-input2 label {
    font-weight: 600;
    margin-bottom: .5rem;
}

.register-input2 input:focus {
    border: 1px solid #FFD200 !important;
    box-shadow: none !important;

}

.input-btn2 {
    margin: 2rem 0;
    border-radius: 3px !important;
    background-color: #FFD200 !important;
    color: black !important;
    font-weight: 700 !important;
    border: none !important;
    padding: 0.5rem 8rem !important;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}

.register-para p {
    font-weight: 600;
}

.register-para a {
    text-decoration: none !important;
    font-weight: 600;
}

@media (min-width: 350px) and (max-width: 520px) {
    .sign_up-div-1 {
        box-shadow: none;
    }

   .sign_up-div-1 h5 {
        font-size: 1rem;
    }

    .sign_up-div-1 h1 {
        font-size: 1.2rem;
        margin: 0;
    }

    .sign_up-div-1 h4 {
        font-size: .8rem;
    }

    .register-input {
        width: 100%;
    }

    .register-input label {
        font-size: .8rem;
    }

    .register-input input {
        font-size: 1rem;
    }

    .input-btn {
        width: 30%;
        font-size: .8rem !important;
    }

    .input-btn2 {
        padding: 0.5rem 6rem !important;
    }
}
/*---------error-------------*/
 .error{
    color:red;
 }

 </style>
 <section class="container">
        <div class="sign_up-div-1">
            <h5>REGISTER</h5>
            <h1>Please fill in the details</h1>
            <h4>(All fields are required)</h4>
            <?php if ($this->session->flashdata('message') !== NULL) { ?>

                <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible">

                <?php echo $this->session->flashdata('message')['1']; ?>

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                </div>

            <?php } ?>
            <form action="<?php echo base_url('account/seller_register'); ?>" method="post" enctype="multipart/form-data">
         
         
            <div class="row">
                 <div class="register-input col-lg-6">
                    <label for="name">Full Name</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/user.png" alt=""></span>
                        <input type="text" class="input-grp form-control" placeholder="name" aria-label="name" aria-describedby="basic-addon1" name="name">
                        
                    </div>
                    <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                </div>
                
                 <div class="register-input col-lg-6">
                    <label for="name">User Type</label>
                    <div class="input-group mb-3">
                        <select class="input-grp form-select" placeholder="Select user type" aria-label="Username" aria-describedby="basic-addon1" name="user_type">
                            <option selected>Select User Type</option>
                            <option value="1" selected="">Vendor</option>
                             <option value="2">Service Provider</option>
                          </select>
                    </div>
                    <?php echo form_error('user_type', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Email Address <span class="input-span">(An OTP will be sent to this mail)</span></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/mail.png" alt=""></span>
                        <input type="text" class="input-grp form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1" name="email">
                        <button class="input-btn btn btn-outline-secondary" type="button" id="button-addon2">GET OTP</button>

                    </div>
                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Enter OTP received on mail</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="OTP from Mail" aria-label="Recipient's username" aria-describedby="button-addon2" name="email_otp">
                        <button class="input-btn btn btn-outline-secondary" type="button" id="button-addon2">VERIFY</button>
                    </div>
                    <?php echo form_error('email_otp', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Mobile Number <span class="input-span">(An OTP will be sent to this number)</span></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/phone.png" alt=""></span>
                        <input type="text" class="input-grp2 form-control" placeholder="Enter Mobile Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="mobile_number">
                        <button class="input-btn btn btn-outline-secondary" type="button" id="button-addon2">GET OTP</button>
                    </div>
                    <?php echo form_error('mobile_number', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Enter OTP received on mobile</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="OTP from Phone" aria-label="Recipient's username" aria-describedby="button-addon2" name="mobile_otp">
                        <button class="input-btn btn btn-outline-secondary" type="button" id="button-addon2">VERIFY</button>
                    </div>
                    <?php echo form_error('mobile_otp', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <div class="register-input2">
                <label for="name">Address</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/map-pin.png" alt=""></span>
                    <input type="text" class="input-grp form-control" placeholder="Complete Address" aria-label="Username" aria-describedby="basic-addon1" name="address">
                </div>
                    <?php echo form_error('address', '<div class="error">', '</div>'); ?>
            </div>
            <div class="row">
                <div class="register-input col-lg-6">
                    <label for="name">ID Proof</label>
                    <div class="input-group mb-3">
                      <!--   <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/file.png" alt=""></span> -->
                        <select class="input-grp form-select" placeholder="Select ID Proof" aria-label="Username" aria-describedby="basic-addon1" name="id_proof">
                            <option selected>Select ID Proof</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select>
                    </div>
                    <?php echo form_error('id_proof', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">ID Number</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/file.png" alt=""></span>
                        <input type="text" class="input-grp form-control" placeholder="Input the ID Number" aria-label="id_number" aria-describedby="basic-addon1" name="id_number">
                    </div>
                    <?php echo form_error('id_number', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Upload ID Document</label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" name="id_document">
                    </div>
                    <?php echo form_error('id_document', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Upload CIN</label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" name="cin">
                    </div>
                    <?php echo form_error('cin', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Upload PAN</label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" name="pan">
                    </div>
                    <?php echo form_error('pan', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Upload TAN</label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" name="tan">
                    </div>
                    <?php echo form_error('tan', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Upload GSTIN</label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" name="gstin">
                    </div>
                    <?php echo form_error('gstin', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Upload UDYAM</label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" name="udyam">
                    </div>
                    <?php echo form_error('udyam', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Create Password</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/lock-line.png" alt=""></span>
                        <input type="password" class="input-grp form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1" name="password">
                    </div>
                    <?php echo form_error('password', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">Bank Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Bank name" aria-label="Bank name" aria-describedby="button-addon2" name="bank_name">
                    </div>
                    <?php echo form_error('bank_name', '<div class="error">', '</div>'); ?>
                </div>
                  <div class="register-input col-lg-6">
                    <label for="name">A/C No.</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="Account number" aria-label="Account number" aria-describedby="button-addon2" name="account_number">
                    </div>
                    <?php echo form_error('account_number', '<div class="error">', '</div>'); ?>
                </div>
                  <div class="register-input col-lg-6">
                    <label for="name">Branch Name</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Branch name" aria-label="Branch name" aria-describedby="button-addon2" name="branch_name">
                    </div>
                    <?php echo form_error('branch_name', '<div class="error">', '</div>'); ?>
                </div>
                <div class="register-input col-lg-6">
                    <label for="name">IFSC Code</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="IFSC Code" aria-label="IFSC Code" aria-describedby="button-addon2" name="ifsc_code">
                    </div>
                    <?php echo form_error('ifsc_code', '<div class="error">', '</div>'); ?>
                </div>
            </div>
            <button class="input-btn2 btn btn-outline-secondary" type="submit" id="button-addon2">REGISTER</button>
             </form>
            <p class="register-para">Already have an account? <a href="#">Log In</a></p>
        </div>
    </section>
    <script src="https://kit.fontawesome.com/4e5440edad.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>