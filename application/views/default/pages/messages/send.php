<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">Compose a Private Message</h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-12">

                <div class="form-group">

                    {recipient_label}
                    {recipient_field}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <div class="form-group <?php if(form_error('subject')){echo 'has-error';} ?>">

                    {subject_label}
                    {subject_field}
                    {subject_error}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <div class="form-group <?php if(form_error('message')){echo 'has-error';} ?>">

                    {message_label}
                    {message_field}
                    {message_error}

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                {recipient_hidden_field}
                {send_pm_button}

            </div>

        </div>

        {form_close}

    </div>

</div>