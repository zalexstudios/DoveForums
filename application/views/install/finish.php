<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">

    <ol class="breadcrumb">
        <li><i class="fa fa-share-alt"></i> MySQL Connection</li>
        <li><i class="fa fa-table"></i> Table Creation</li>
        <li class="active"><i class="fa fa-cog"></i> Site Settings</li>
        <li><i class="fa fa-flag-checkered"></i> Finish</li>
    </ol>

    <div class="panel panel-primary">

        <div class="panel-heading">

            <h3 class="panel-title">Site Settings</h3>

        </div>

        <div class="panel-body">

            <p>Settings config created Successful!</p>
            <p>The installation is now complete!</p>
            <p>For security reasons, all files related to this installer will be deleted after you click the "Finish Installation" button.</p>
            <p>You will then be redirected to the home page of your forums.</p>
            <p>Login as admin (with the account details you created a moment ago) once the installation is finished, and create your categories.</p>
            <p>Have fun with Dove Forums, and dont forget to check out the Dove Forums home page for updates, plugins & more.</p>
            <p>Thank you for choosing Dove Forums, Regards Dove Forums Team.</p>
            <hr class="dashed">


            <hr class="dashed">

            <div class="form-group">

                <a href="<?= site_url('install/delete_files'); ?>" class="btn btn-primary">Finish Installation</a>

            </div>

        </div>

    </div>

</div>