<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo GetValue('app_name','setup_app',array('id'=>'where/1')); ?></title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/login/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/login/css/style.css">
</head>
<body>

    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
                <div class="container">
                    <div class="signin-content">
                        <div class="signin-image">
                            <figure><img src="<?php echo base_url()?>assets/login/images/signin-image.jpg" alt="sing up image"></figure>
                        </div>
    
                        <div class="signin-form">
                            <h2 class="form-title">Sign up</h2>
                            <form method="POST" class="register-form" id="login-form" action="<?php echo base_url()?>login/cek_login">
                                <div class="form-group">
                                    <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    <input type="text" name="username" id="your_name" placeholder="Your Name"/>
                                </div>
                                <div class="form-group">
                                    <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                    <input type="password" name="password" id="your_pass" placeholder="Password"/>
                                </div>
                                
                                <div class="form-group form-button">
                                    <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- JS -->
        <script src="<?php echo base_url()?>assets/login/vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url()?>assets/login/js/main.js"></script>
</body>
    </html>