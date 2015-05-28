<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">

    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-share-alt"></i> MySQL Connection</li>
        <li><i class="fa fa-database"></i> Database Creation</li>
        <li><i class="fa fa-table"></i> Table Creation</li>
        <li><i class="fa fa-cog"></i> Site Settings</li>
        <li><i class="fa fa-flag-checkered"></i> Finish</li>
    </ol>

    <div class="panel panel-primary">

        <div class="panel-heading">

            <h3 class="panel-title">MySQL Connection</h3>

        </div>

        <div class="panel-body">

            <p><strong>Welcome to Dove Forums!</strong></p>
            <p>Before you can use your new Forums, you have to complete a quick installation.</p>
            <p>The installer will automate the creating of the database and tables for you.</p>
            <p>First of all, please enter your MySQL <strong>Hostname</strong>, <strong>Username</strong>, <strong>Password</strong>.</p>
            <p><strong>Example:</strong></p>
            <pre>hostname: localhost<br>username: root<br>password: root</pre>
            <br>

            <?php
                if (validation_errors())
                {
                    echo '<div class="alert alert-danger" role="alert">' . validation_errors() .'</div>';
                }

                echo $this->messageci->display();
            ?>

            <?php echo form_open(); ?>

            <div class="form-group <?php if(form_error('db_hostname')){echo 'has-error';} ?>">

                <label for="db_hostname">Hostname</label>
                <input type="text" class="form-control" id="db_hostname" name="db_hostname" placeholder="Enter your MySQL hostname">

            </div>

            <div class="form-group <?php if(form_error('db_username')){echo 'has-error';} ?>">

                <label for="db_username">Username</label>
                <input type="text" class="form-control" id="db_username" name="db_username" placeholder="Enter your MySQL username">

            </div>

            <div class="form-group <?php if(form_error('db_password')){echo 'has-error';} ?>">

                <label for="db_password">Password</label>
                <input type="text" class="form-control" id="db_password" name="db_password" placeholder="Enter your MySQL password">

            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-primary" value="Next">

            </div>

        </div>

    </div>

</div>