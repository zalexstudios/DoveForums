<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_register');?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-12">

                <div class="form-group <?php if(form_error('username')){echo 'has-error';} ?>">

                    {username_label}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {username_field}
                    </div>
                    {username_error}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('email')){echo 'has-error';} ?>">

                    {email_label}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                        {email_field}
                    </div>
                    {email_error}

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('password')){echo 'has-error';} ?>">

                    {password_label}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        {password_field}
                    </div>
                    {password_error}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                {recaptcha_field}

            </div>

        </div>

        <hr class="dashed">

        <div class="row">

            <div class="col-md-12">

                <div class="form-group">

                    {register_button}

                </div>

            </div>

        </div>

        <div class="clearfix"></div>

        {form_close}

    </div>

</div>
