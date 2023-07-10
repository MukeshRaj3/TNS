    <!-- Breadcrumb Area Start -->
    <!-- <div class="bg-white breadcrumb-area bg-12 text-center">
        <div class="container">
            <h1> login </h1>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> >> login </li>
                </ul>
            </nav>
        </div>
    </div> -->
    <!-- Breadcrumb Area End -->
    <div class="bg-white pt-110 pb-110" id="login_form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-12  p-5 m-5 shadow rounded">
                    <div class="login-register-wrapper">
                        <div class="login-form-container">
                            <h3 class="text-center text-success mt-0">Login</h3>
                            <?php if ($this->session->flashdata('message') !== NULL) { ?>
                                <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                                    <?php echo $this->session->flashdata('message')['1']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php } ?>
                            <div class="login-register-form">
                                <?php echo form_open("auth/login"); ?>
                                <label for="emailaddress " class="mb-0"><?php echo lang('login_identity_label', 'identity'); ?></label>
                                <?php echo form_input($identity); ?>
                                <div class="error"><?php echo form_error('identity'); ?></div>
                                <label for="password " class="mb-0 mt-4"><?php echo lang('login_password_label', 'password'); ?></label>
                                <?php echo form_input($password); ?>
                                <div class="error"><?php echo form_error('password'); ?></div>
                                <div class="button-box">
                                    <div class="login-toggle-btn mt-4 mb-3">
                                        <a href="<?php echo base_url('auth/forgot_password'); ?>">Forgot Password?</a>
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary btn-md">Login</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="signup-login text-center">
                                <p class="white" style="margin-top: 20px;">
                                    If you are new user ? <a class="btn btn-danger" href="<?php echo base_url('auth/register'); ?>" style="color:#fff;margin-left: 10px;">Sign up?</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>