<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-warning">

    <div class="panel-heading">

        <h3 class="panel-title"><?=sprintf(lang('tle_profile'), $username);?></h3>

    </div>

    <div class="panel-body">

        <div class="row">

            <div class="col-md-12">

                <p class="text-center"><strong>{username}</strong></p>

                    {avatar}

            </div>

        </div>

        <br />

        <div class="row">

            <div class="col-md-12">

                <p class="text-center">{btn_send_pm}&nbsp;{btn_report_user}</p>

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_real_name');?></strong>

            </div>

            <div class="col-md-9">

                {first_name}&nbsp;{last_name}

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_joined');?></strong>

            </div>

            <div class="col-md-9">

                {joined}

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_last_visit');?></strong>

            </div>

            <div class="col-md-9">

                {last_visit}

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_total_discussions');?></strong>

            </div>

            <div class="col-md-9">

                {total_discussions}

            </div>

        </div>

        <hr class="dashed" />

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_total_comments');?></strong>

            </div>

            <div class="col-md-9">

                {total_comments}

            </div>

        </div>

    </div>

</div>