<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- <div class="bg-white breadcrumb-area bg-12 text-center">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> >> Sign Up </li>
            </ul>
        </nav>
    </div>
</div> -->
<div class="bg-white pt-110 pb-110" id="login_form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-12 m-5 p-5 shadow">
                <div class="login-register-wrapper">
                    <div class="login-form-container">
                        <h3 class="text-center text-success mt-0">Sign Up </h3>
                        <?php if ($this->session->flashdata('message') !== NULL) { ?>
                            <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('message')['1']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                        <div class="login-register-form">
                            <?php echo form_open("auth/register"); ?>
                            <div class="form-group relative mb-20 mb-sm-20">
                                <label for="first_name" class="form-label">First Name*</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" onkeydown="checkCharacterOnly(event);" maxlength="100" autocomplete="off" value="<?php echo $this->input->post('first_name'); ?>">
                                <div class="error"><?php echo form_error('first_name'); ?></div>
                            </div>
                            <div class="form-group relative mb-20 mb-sm-20">
                                <label for="last_name" class="form-label">Last Name*</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" onkeydown="checkCharacterOnly(event);" maxlength="100" autocomplete="off" value="<?php echo $this->input->post('last_name'); ?>">
                                <div class="error"><?php echo form_error('last_name'); ?></div>
                            </div>
                            <div class="form-group relative mb-20 mb-sm-20">
                                <label for="contact_email" class="form-label">Contact Email*</label>
                                <input type="email" name="email" value="<?php echo $this->input->post('email'); ?>" id="email" class="form-control" placeholder="Email" autocomplete="off" role="presentation" onchange="check_email_exists(this);">
                                <div class="error"><?php echo form_error('email'); ?></div>
                                <div class="email-validation" style="color:red"></div>
                            </div>
                            <div class="form-group relative mb-20 mb-sm-20">
                                <label for="phone" class="form-label">Contact Tel Number</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Business Tel Number" maxlength="12" onkeydown="checkNumberOnly(event);" autocomplete="off" value="<?php echo $this->input->post('phone'); ?>">
                                <div class="error"><?php echo form_error('phone'); ?></div>
                            </div>
                            <div class="form-group relative mb-20 mb-sm-20">
                                <label for="password" class="form-label">Password*</label>
                                <input type="password" name="password" value="" id="password" class="form-control" role="presentation" autocomplete="off" placeholder="Password" autocomplete="off">
                                <div class="error"><?php echo form_error('password'); ?></div>
                            </div>
                            <div class="form-group relative mb-20 mb-sm-20">
                                <label for="password_confirm" class="form-label">Confirm Password*</label>
                                <input type="password" name="password_confirm" value="" id="password_confirm" class="form-control" placeholder="Confirm Password" autocomplete="off">
                                <div class="error"><?php echo form_error('password_confirm'); ?></div>
                            </div>
                            <div class="button-box">
                                <button type="submit" class="btn btn-outline-primary btn-md">Sign Up</button>
                            </div>
                            <div class="signup-login text-center">
                                <p class="white" style="margin-top: 20px;">
                                    Already a member ? <a class="btn btn-danger" href="<?php echo base_url('auth/login'); ?>" style="color:#fff;margin-left: 10px;">Login</a>
                                </p>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.login-register-wrapper .login-form-container .login-register-form form input {
    margin-bottom: 0px !important;
}
</style>