<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="btn-toolbar pagination-toolbar" role="toolbar">

    <!-- Check the user is logged in -->
    <?php if ($this->ion_auth->logged_in() === TRUE) { ?>

        <div class="btn-group pull-right">

            {btn_new_discussion}

        </div>

    <?php } ?>

</div>

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">{name}</h3>

    </div>

    <div class="panel-body">

        <div class="media">

            <ul class="media-list">

                <?php if($has_discussions === 1) { ?>

                    {discussions}

                    <li class="media">

                        <div class="media-body">

                            <h5 class="media-heading"><strong>{subject}</strong></h5>

                            <p class="small">{views} <?=lang('txt_views');?>&nbsp;&nbsp;&nbsp;&nbsp;{replies} <?=lang('txt_comments');?>&nbsp;&nbsp;&nbsp;&nbsp;<?=lang('txt_most_recent_by');?> {last_poster}&nbsp;&nbsp;&nbsp;&nbsp;{last_comment}&nbsp;&nbsp;&nbsp;&nbsp;{category}</p>

                        </div>

                    </li>

                    {/discussions}

                <?php } else { ?>

                    <li class="media">

                        <div class="media-body">

                            <h4 class="media-heading"><strong><?=lang('txt_no_discussions');?></strong></h4>

                        </div>

                    </li>

                <?php } ?>

            </ul>

        </div>

    </div>

</div>

<div class="btn-toolbar pagination-toolbar" role="toolbar">

    <!-- Check the user is logged in -->
    <?php if ($this->ion_auth->logged_in() === TRUE) { ?>

        <div class="btn-group pull-right">

            {btn_new_discussion}

        </div>

    <?php } ?>

</div>