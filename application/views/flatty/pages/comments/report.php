<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-warning">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_report_comment');?></h3>

    </div>

    <div class="panel-body">

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_username');?></strong>

            </div>

            <div class="col-md-9">

                {logged_in_user}

            </div>

        </div>

        <hr class="dashed" />

        {form_open}

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_report_reason');?></strong>

            </div>

            <div class="col-md-9">

                <div class="form-group <?php if(form_error('reason')){echo 'has-error';} ?>">

                    {report_field}
                    {report_error}

                </div>

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-12">

                {comment_id_hidden_field}
                {btn_report_comment}

            </div>

        </div>

        {form_close}

    </div>

</div>