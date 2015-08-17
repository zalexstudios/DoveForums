<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<footer>

    <?php if($this->users->users_online()) { ?>
    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">

                    <h3 class="panel-title">Who`s Online</h3>

                </div>

                <div class="panel-body">

                    <p class="small">
                    {online_users}
                        {user}
                    {/online_users}
                    </p>

                </div>

            </div>

        </div>

    </div>
    <?php } ?>

    <p class="text-center text-muted"><small>{copy_text}</small></p>

</footer>