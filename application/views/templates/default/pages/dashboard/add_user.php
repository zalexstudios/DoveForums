<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_add');?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('username')){echo 'has-error';} ?>">
                    {username_label}
                    {username_field}
                    {username_error}
                </div>

                <div class="form-group <?php if(form_error('password')){echo 'has-error';} ?>">
                    {password_label}
                    {password_field}
                    {password_error}
                </div>

                <div class="form-group">
                    {last_name_label}
                    {last_name_field}
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('email')){echo 'has-error';} ?>">
                    {email_label}
                    {email_field}
                    {email_error}
                </div>

                <div class="form-group">
                    {first_name_label}
                    {first_name_field}
                </div>

            </div>

        </div>

        <div class="form-group">
            {btn_add_user}
        </div>

        {form_close}

    </div>

</div>