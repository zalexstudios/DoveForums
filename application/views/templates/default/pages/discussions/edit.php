<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-warning">

    <div class="panel-heading">

        <h3 class="panel-title">Edit Discussion</h3>

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

                <strong>Subject:</strong>

            </div>

            <div class="col-md-9">

                <div class="form-group  <?php if(form_error('name')){echo 'has-error';} ?>">

                    {name_field}
                    {name_error}

                </div>

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-3">

                <strong>Category:</strong>

            </div>

            <div class="col-md-9">

                <div class="form-group  <?php if(form_error('category')){echo 'has-error';} ?>">

                    {category_field}
                    {category_error}

                </div>

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-3">

                <strong>Your Message:</strong>

            </div>

            <div class="col-md-9">

                <div class="form-group <?php if(form_error('body')){echo 'has-error';} ?>">

                    {body_field}
                    {body_error}

                </div>


            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-12">

                {btn_update_discussion}
                {discussion_id_hidden_field}

            </div>

        </div>

        {form_close}

    </div>

</div>