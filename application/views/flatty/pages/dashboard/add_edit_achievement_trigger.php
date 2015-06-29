<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?php if($this->uri->segment('2') === 'add_achievement_trigger') { echo lang('tle_add'); } else { echo lang('tle_edit'); } ?></h3>

    </div>

    <div class="panel-body">

        {form_open}

        <div class="row">

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('action')){echo 'has-error';} ?>">
                    {action_label}
                    {action_field}
                    {action_error}
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('condition')){echo 'has-error';} ?>">
                    {condition_label}
                    {condition_field}
                    {condition_error}
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group <?php if(form_error('achievement')){echo 'has-error';} ?>">
                    {achievement_label}
                    {achievement_field}
                    {achievement_error}
                </div>

            </div>

        </div>

        <div class="form-group">
            {btn_add_edit_achievement_trigger}
        </div>

        {form_close}

    </div>

</div>