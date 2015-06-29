<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?php if($this->uri->segment('2') === 'add_language') { echo lang('tle_add'); } else {  echo lang('tle_edit'); } ?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('language')){echo 'has-error';} ?>">
                    {language_label}
                    {language_field}
                    {language_error}
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('code')){echo 'has-error';} ?>">
                    {code_label}
                    {code_field}
                    {code_error}
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('icon')){echo 'has-error';} ?>">
                    {icon_label}
                    {icon_field}
                    {icon_error}
                </div>

            </div>

        </div>

        <div class="form-group">
            {btn_add_edit_language}
        </div>

        {form_close}

    </div>

</div>