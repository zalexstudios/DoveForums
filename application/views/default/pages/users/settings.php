<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_settings');?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <fieldset>

            <legend><?=lang('txt_personal');?></legend>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group <?php if(form_error('email')){echo 'has-error';} ?>">
                        {email_label}
                        {email_field}
                        {email_error}
                    </div>

                    <div class="form-group">
                        {first_name_label}
                        {first_name_field}
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        {language_label}
                        {language_field}
                    </div>

                    <div class="form-group">
                        {last_name_label}
                        {last_name_field}
                    </div>

                </div>

            </div>

        </fieldset>

        <fieldset>

            <legend><?= lang('txt_notifications'); ?></legend>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <div class="checkbox">

                            <label>
                                {notify_of_replies_field} <?= lang('txt_notify_of_replies'); ?>
                            </label>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">


                </div>

            </div>

        </fieldset>

        <div class="form-group">
            {btn_update_settings}
        </div>

        {form_close}

    </div>

</div>