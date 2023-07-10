<style type="text/css">
    body {
    font-family: 'Poppins', sans-serif;
}

.login-div-1 {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0px 4px 40px 0px rgba(0, 0, 0, 0.25);
    border-radius: 15px;
    text-align: center;
    margin: 2rem auto;
    padding: 2rem 4rem;
    width: 50%;
}

.login-div-1 h4 {
    font-weight: 700;
    margin-bottom: 3rem;
}

.login-input {
    text-align: start;
    margin-bottom: 1rem;
}

.login-input label {
    font-weight: 600;
    margin-bottom: .5rem;
}

.login-input input:focus {
    border: 1px solid #FFD200 !important;
    box-shadow: none !important;
}

.input-group-text {
    background-color: white !important;
    border-right: none;
    border: 1px solid #909090;
}

.input-grp {
    border-left: none !important;
}

.input-span {
    color: #9B9B9B;
    font-weight: 400;
}

.input-btn2 {
    margin: 1rem 0;
    border-radius: 3px !important;
    background-color: #FFD200 !important;
    color: black !important;
    font-weight: 700 !important;
    border: none !important;
    padding: 0.5rem 2rem !important;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}

.login-para {
    margin-top: 1.5rem;
}

.login-para p {
    font-weight: 600;
}

.login-para a {
    text-decoration: none !important;
    font-weight: 600;
}

@media (min-width: 350px) and (max-width: 520px) {
    .login-div-1 {
        width: 100%;
        box-shadow: none;
        padding: 0 1.2rem;
    }
    
    .login-input label {
        font-size: .8rem;
    }   
}
</style>
<!-- <?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<section class="login">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-xl-7 col-lg-6 d-none d-lg-block">
                    <div class="login-image bg-cover h-100" style="background-image: url('Assetes/Product/5.png');">

                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 ">
                    <div class="form-area bg-blue">
                        <h2 class="f-700 mb-5 white">Seller Login</h2>
                        <?php if ($this->session->flashdata('message') !== NULL) { ?>
                            <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo $this->session->flashdata('message')['1']; ?></div>
                        <?php } ?>
                        <?php echo form_open("account/seller_login");?>
                            <div class="form-group relative mb-25 mb-sm-20">
                                <label for="emailaddress"><?php echo lang('login_identity_label', 'identity');?></label>
                                <?php echo form_input($identity);?>
                                <?php echo form_error('identity'); ?>
                            </div>
                            <div class="form-group relative mb-20 mb-sm-20">
                                <label for="password"><?php echo lang('login_password_label', 'password');?></label>
                                <?php echo form_input($password);?>
                                <?php echo form_error('password'); ?>
                            </div>
                            <button class="btn btn-black btn-block mt-20" type="submit"> Log In </button>
                            <div class="signup-login text-center">
                                <p class="white" style="margin-top: 20px;">
                                    If Don't have account ? <a class="btn btn-danger" href="<?php echo base_url('account/seller_register'); ?>" style="color:#fff;margin-left: 10px;">SIGN-IN</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
     -->
  <section class="container">
        <div class="login-div-1">
            <h4>LOG IN</h4>
             <?php if ($this->session->flashdata('message') !== NULL) {
                  echo "sadas"; die;
              ?>

                <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible">

                <?php echo $this->session->flashdata('message')['1']; ?>

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                </div>

            <?php } ?>
            <?php echo form_open("account/seller_login");?>
            <div class="login-input">
                <label for="name">Mobile Number <span class="input-span">(An OTP will be sent to this number)</span></label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/phone.png" alt=""></span>
                    <input type="text" class="input-grp form-control" name="identity" placeholder="Enter Mobile Number" aria-label="Username" aria-describedby="basic-addon1">
                    <?php echo form_error('identity'); ?>

                </div>
            </div>
            <div class="login-input">
                <label for="name">Enter OTP received on mobile</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>images/register/lock-line.png" alt=""></span>
                    <input type="text" class="input-grp form-control" name="otp" placeholder="OTP from Phone" aria-label="Username" aria-describedby="basic-addon1">
                    <?php echo form_error('password'); ?>
                </div>
            </div>
            <button class="input-btn2 btn btn-outline-secondary"  id="button-addon2" type="submit">LOGIN</button>
           </form>
            <p class="login-para">Already have an account? <a href="#">Log In</a></p>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
