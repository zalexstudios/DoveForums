<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">

    <ol class="breadcrumb">
        <li><i class="fa fa-share-alt"></i> MySQL Connection</li>
        <li><i class="fa fa-table"></i> Table Creation</li>
        <li class="active"><i class="fa fa-cog"></i> Site Settings</li>
        <li><i class="fa fa-flag-checkered"></i> Finish</li>
    </ol>

    <div class="panel panel-primary">

        <div class="panel-heading">

            <h3 class="panel-title">Site Settings</h3>

        </div>

        <div class="panel-body">

            <p>Database tables created Successful!</p>
            <p>Please enter the site settings below.</p>
            <hr class="dashed">

            <?php
            if (validation_errors())
            {
                echo '<div class="alert alert-danger" role="alert">' . validation_errors() .'</div>';
            }
            ?>

            <?php echo form_open(); ?>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group <?php if(form_error('admin_username')){echo 'has-error';} ?>">

                        <label for="admin_username">Admin Username</label>
                        <input type="text" class="form-control" id="admin_username" name="admin_username" placeholder="Enter a admin username.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> This will be your admin username on the forums.</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('admin_email')){echo 'has-error';} ?>">

                        <label for="admin_email">Admin Email</label>
                        <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="Enter your admin email.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> This email will be used to send & receive notifications.</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('admin_password')){echo 'has-error';} ?>">

                        <label for="admin_password">Admin Password</label>
                        <input type="password" class="form-control" id="admin_password" name="admin_password" placeholder="Enter your admin password.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> This will be the password for your admin account.</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('admin_password_confirm')){echo 'has-error';} ?>">

                        <label for="admin_password_confirm">Confirm Password</label>
                        <input type="password" class="form-control" id="admin_password_confirm" name="admin_password_confirm" placeholder="Confirm your admin password.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Must match the password above.</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('first_name')){echo 'has-error';} ?>">

                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Example: John</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('recaptcha_site_key')){echo 'has-error';} ?>">

                        <label for="recaptcha_site_key">Recaptcha Site Key</label>
                        <input type="text" class="form-control" id="recaptcha_site_key" name="recaptcha_site_key" placeholder="Enter your recaptcha site key.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Enter a recaptcha site key, you can create one <a href="https://www.google.com/recaptcha/admin" target="_blank">Here</a></small></p>

                    </div>

                    <div class="form-group <?php if(form_error('recaptcha_lang')){echo 'has-error';} ?>">

                        <label for="recaptcha_lang">Recaptcha Language</label>
                        <input type="text" class="form-control" id="recaptcha_lang" name="recaptcha_lang" placeholder="Enter your recaptcha language.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Enter a recaptcha language, you can check them <a href="https://developers.google.com/recaptcha/docs/language" target="_blank">Here</a></small></p>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group <?php if(form_error('base_url')){echo 'has-error';} ?>">

                        <label for="base_url">Base Url</label>
                        <input type="text" class="form-control" id="base_url" name="base_url" placeholder="Enter your forum base url.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Example: http://www.yoursite.com/ (don`t forget the trailing slash!)</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('site_title')){echo 'has-error';} ?>">

                        <label for="site_title">Site Title</label>
                        <input type="text" class="form-control" id="site_title" name="site_title" placeholder="Enter your forum name.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Example: Fun Forums</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('encryption_key')){echo 'has-error';} ?>">

                        <label for="encryption_key">Encryption Key</label>
                        <input type="text" class="form-control" id="encryption_key" name="encryption_key" placeholder="Enter a encryption key.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Enter a encryption key, you can generate one <a href="http://randomkeygen.com/" target="_blank">Here</a> </small></p>

                    </div>

                    <div class="form-group <?php if(form_error('site_language')){echo 'has-error';} ?>">

                        <label for="site_language">Site Language</label>
                        <?php echo $site_language; ?>
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Select the sites default language.</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('last_name')){echo 'has-error';} ?>">

                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name.">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Example: Doe</small></p>

                    </div>

                    <div class="form-group <?php if(form_error('recaptcha_secret_key')){echo 'has-error';} ?>">

                        <label for="recaptcha_secret_key">Recaptcha Secret Key</label>
                        <input type="text" class="form-control" id="recaptcha_secret_key" name="recaptcha_secret_key" placeholder="Enter your recaptcha secret key..">
                        <p class="help-block"><small><i class="fa fa-question-circle"></i> Enter a recaptcha secret key, you can create one <a href="https://www.google.com/recaptcha/admin" target="_blank">Here</a></small></p>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <hr class="dashed">

                    <div class="form-group">

                        <input type="submit" class="btn btn-primary" value="Next">

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>