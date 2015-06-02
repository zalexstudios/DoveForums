<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_resert_password');?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('new_password')){echo 'has-error';} ?>">

                    {new_password_label}
                    {new_password_field}
                    {new_password_error}

                </div>

            </div>

            <div class="col-md-6">

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

                    {user_id_hidden_field}
                    {csrf_hidden_field}
                    {btn_reset_password}

                </div>

            </div>

        </div>

        <div class="clearfix"></div>

        {form_close}

    </div>

</div>