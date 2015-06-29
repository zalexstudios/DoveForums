<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_forgot_password');?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-12">

                <div class="form-group <?php if(form_error('identity')){echo 'has-error';} ?>">

                    {identity_label}
                    {identity_field}
                    {identity_error}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <div class="form-group">

                    {btn_forgot_password}

                </div>

            </div>

        </div>

        <div class="clearfix"></div>

        {form_close}

    </div>

</div>