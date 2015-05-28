<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">

    <ol class="breadcrumb">
        <li><i class="fa fa-share-alt"></i> MySQL Connection</li>
        <li class="active"><i class="fa fa-database"></i> Database Creation</li>
        <li><i class="fa fa-table"></i> Table Creation</li>
        <li><i class="fa fa-cog"></i> Site Settings</li>
        <li><i class="fa fa-flag-checkered"></i> Finish</li>
    </ol>

    <div class="panel panel-primary">

        <div class="panel-heading">

            <h3 class="panel-title">Database Creation</h3>

        </div>

        <div class="panel-body">

            <p>Connection to MySQL Successful!</p>
            <p>Please enter the name of the database to install your forum data.<br>The database will be creater <strong>Automatically</strong> for you.</p>
            <br>

            <?php
            if (validation_errors())
            {
                echo '<div class="alert alert-danger" role="alert">' . validation_errors() .'</div>';
            }

            echo $this->messageci->display();

            ?>

            <?php echo form_open(); ?>

            <div class="form-group <?php if(form_error('database_name')){echo 'has-error';} ?>">

                <label for="database_name">Database Name</label>
                <input type="text" class="form-control" id="database_name" name="database_name" placeholder="Enter a database name.">

            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-primary" value="Next">

            </div>

        </div>

    </div>

</div>