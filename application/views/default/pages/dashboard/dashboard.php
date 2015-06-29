<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_dashboard');?></h3>

    </div>

    <div class="panel-body">

        <div class="row">

            <div class="col-md-3">

                <div class="panel panel-default">

                    <div class="panel-heading">

                        <h4 class="panel-title"><i class="fa fa-users"></i> Users</h4>

                    </div>

                    <div class="panel-body">

                        <p>Registered: <span class="label label-success">{user_count}</span></p>

                        <hr class="dashed">

                        <p>Reported: <span class="label label-warning">{reported_user_count}</span></p>

                        <hr class="banned">

                        <p>Banned: <span class="label label-danger">{banned_user_count}</span></p>

                    </div>

                    <div class="panel-footer text-center">

                        <a class="btn btn-primary btn-sm">View All</a>

                    </div>

                </div>

            </div>

            <div class="col-md-3">


            </div>

        </div>

    </div>

</div>