<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="row">

    <div class="col-md-12">

        <?php if($update == TRUE) { ?>
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p><strong>A new update is available!</strong></p>
                <p>Version: {version}</p>
                <p>Click {download_link} to download.</p>
            </div>
        <?php } ?>

    </div>

</div>

<div class="row">

    <div class="col-md-6">

        <div class="panel panel-default">

            <div class="panel-heading">

                <h4 class="panel-title"><i class="fa fa-newspaper-o"></i> Dove Forums News</h4>

            </div>

            <div class="panel-body">


            </div>


        </div>

    </div>

    <div class="col-md-6">


    </div>

</div>