<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-warning">

    <div class="panel-heading">

        <h3 class="panel-title"><?=sprintf(lang('tle_profile'), $username);?></h3>

    </div>

    <div class="panel-body">

        <div class="row">

            <div class="col-md-12">

                <p class="text-center">{online}&nbsp;<strong>{username}</strong></p>

                    {avatar}

                <p class="text-center"><span class="label label-success">{points} Xp</span></p>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <p class="text-center">{btn_send_pm}</p>

            </div>

        </div>

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_real_name');?></strong>

            </div>

            <div class="col-md-9">

                {first_name}&nbsp;{last_name}

            </div>

        </div>

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_joined');?></strong>

            </div>

            <div class="col-md-9">

                {joined} <?= lang('txt_ago'); ?>

            </div>

        </div>

        <div class="row">

            <div class="col-md-3">

                <strong><?= lang('txt_last_visit');?></strong>

            </div>

            <div class="col-md-9">

                {last_visit} <?= lang('txt_ago'); ?>

            </div>

        </div>

        <div class="row">

            <div class="col-md-3">

                <strong><?=lang('txt_total_discussions');?></strong>

            </div>

            <div class="col-md-9">

                {total_discussions}

            </div>

        </div>

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

<?php if($has_achievements) { ?>

<div class="panel panel-info">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_achievements');?></h3>

    </div>

    <div class="panel-body">

        {achievements}

            <div class="alert alert-info">

                <div class="row">

                    <div class="col-md-1">

                        <i class="fa fa-trophy fa-3x"></i>

                    </div>

                    <div class="col-md-11">

                        <strong>{name}<span class="badge pull-right">{points} Xp</span></strong><br />
                        <p>{description}</p>

                    </div>

                </div>

            </div>

        {/achievements}
    </div>

</div>

<?php } ?>

<?php if($tbl_thumbs) { ?>

<div class="panel panel-success">

    <div class="panel-heading">

        <h3 class="panel-title">Received Thumbs</h3>

    </div>

    <div class="panel-body">

        {tbl_thumbs}

    </div>

</div>

<?php } ?>