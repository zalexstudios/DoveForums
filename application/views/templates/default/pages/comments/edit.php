<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-warning">

    <div class="panel-heading">

        <h3 class="panel-title">Edit Comment</h3>

    </div>

    <div class="panel-body">

        <div class="row">

            <div class="col-md-3">

                <strong>Username:</strong>

            </div>

            <div class="col-md-9">

                {logged_in_user}

            </div>

        </div>

        <hr class="dashed" />

        {form_open}

        <div class="row">

            <div class="col-md-3">

                <strong>Your Message:</strong>

            </div>

            <div class="col-md-9">

                <div class="form-group <?php if(form_error('comment')){echo 'has-error';} ?>">

                    {comment_field}
                    {comment_error}

                </div>

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-12">

                {btn_update_comment}
                {comment_id_hidden_field}

            </div>

        </div>

        {form_close}

    </div>

</div>