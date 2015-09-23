<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_login');?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    {identity_label}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                        {identity_field}
                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    {password_label}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        {password_field}
                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <div class="form-group">

                    {btn_forgot_password}
                    {btn_login}

                </div>

            </div>

        </div>

        <div class="clearfix"></div>

        {form_close}

    </div>

</div>