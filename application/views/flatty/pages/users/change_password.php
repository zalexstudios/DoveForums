<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_change_password'); ?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-12">

                <div class="form-group <?php if(form_error('old_password')){echo 'has-error';} ?>">

                    {old_password_label}
                    {old_password_field}
                    {old_password_error}

                </div>

                <div class="form-group <?php if(form_error('new_password')){echo 'has-error';} ?>">

                    {new_password_label}
                    {new_password_field}
                    {new_password_error}

                </div>

                <div class="form-group <?php if(form_error('confirm_new_password')){echo 'has-error';} ?>">

                    {confirm_new_password_label}
                    {confirm_new_password_field}
                    {confirm_new_password_error}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <div class="form-group">

                    {btn_change_password}

                </div>

            </div>

        </div>

        <div class="clearfix"></div>

        {form_close}

    </div>

</div>
