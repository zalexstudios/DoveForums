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
                    {username_field}
                    {username_error}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('password')){echo 'has-error';} ?>">

                    {password_label}
                    {password_field}
                    {password_error}

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('confirm_password')){echo 'has-error';} ?>">

                    {confirm_password_label}
                    {confirm_password_field}
                    {confirm_password_error}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('email')){echo 'has-error';} ?>">

                    {email_label}
                    {email_field}
                    {email_error}

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('confirm_email')){echo 'has-error';} ?>">

                    {confirm_email_label}
                    {confirm_email_field}
                    {confirm_email_error}

                </div>

            </div>

        </div>

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
