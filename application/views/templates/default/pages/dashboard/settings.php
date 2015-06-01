<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">Settings</h3>

    </div>

    <div class="panel-body">

        {form_open}

        <fieldset>

            <legend>Site</legend>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group <?php if(form_error('site_name')){echo 'has-error';} ?>">
                        {site_name_label}
                        {site_name_field}
                        {site_name_error}
                    </div>

                    <div class="form-group <?php if(form_error('site_keywords')){echo 'has-error';} ?>">
                        {site_keywords_label}
                        {site_keywords_field}
                        {site_keywords_error}
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group <?php if(form_error('site_email')){echo 'has-error';} ?>">
                        {site_email_label}
                        {site_email_field}
                        {site_email_error}
                    </div>

                    <div class="form-group">
                        {site_language_label}
                        {site_language_field}
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="form-group <?php if(form_error('site_description')){echo 'has-error';} ?>">
                        {site_description_label}
                        {site_description_field}
                        {site_description_error}
                    </div>

                </div>

            </div>

        </fieldset>

        <fieldset>

            <legend>Gravatar</legend>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        {gravatar_rating_label}
                        {gravatar_rating_field}
                    </div>

                    <div class="form-group">
                        {gravatar_size_label}
                        {gravatar_size_field}
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        {gravatar_default_image_label}
                        {gravatar_default_image_field}
                    </div>

                </div>

            </div>

        </fieldset>

        <fieldset>

            <legend>Reading</legend>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        {discussions_per_page_label}
                        {discussions_per_page_field}
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        {comments_per_page_label}
                        {comments_per_page_field}
                    </div>

                </div>

            </div>

        </fieldset>

        <div class="form-group">
            {btn_update_settings}
        </div>

        {form_close}

    </div>

</div>