<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-warning">

    <div class="panel-heading">

        <h3 class="panel-title">Post a New Reply</h3>

    </div>

    <div class="panel-body">

        <div class="row">

            <div class="col-md-12">

                <strong>Reply to discussion: {discussion_name}</strong>

            </div>

        </div>

        <hr class="dashed" />

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

                <strong>Your Message</strong>

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

                {post_comment_button}
                {discussion_id_field_hidden}
                {category_id_field_hidden}

            </div>

        </div>

        {form_close}

    </div>

</div>