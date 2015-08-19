<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title"><?=lang('tle_updates');?></h3>

    </div>

    <div class="panel-body">

        <p class="small"><strong><?= lang('txt_current_version'); ?></strong>&nbsp;<?= lang('txt_version'); ?>&nbsp;{current_version}</p>

        <?php if($update_found) { ?>
        <p class="small"><strong><?= lang('txt_update_found'); ?></strong>&nbsp;<?= lang('txt_version'); ?>&nbsp;{update_found}</p>
        <?php } ?>

        <?php if($statuses) { ?>
        {statuses}
        <p class="small">{status}</p>
        {/statuses}
        <?php } ?>

    </div>

</div>