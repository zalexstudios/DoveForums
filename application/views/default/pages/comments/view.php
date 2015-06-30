<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    {breadcrumbs}

<div class="well well-sm">

    <strong>{discussion_name}</strong>

</div>

<div class="btn-toolbar pagination-toolbar" role="toolbar">

    <!-- Check the user is logged in -->
    <?php if ($this->ion_auth->logged_in() === TRUE) { ?>

    <div class="btn-group pull-right">

        {btn_reply}

    </div>

    <div class="btn-group pull-right">

        {btn_new_discussion}

    </div>

    <?php } ?>

</div>

<?php if($has_comments) { ?>

    {comments}

    <div class="panel panel-default" id="{comment_id}">

        <div class="panel-heading">

            <div class="media-left">{avatar}</div>

            <div class="media-body">

                <p>{poster}<br><span class="label label-success">{points} Xp</span></p>

            </div>

        </div>

        <div class="panel-body">

            <div class="media">

                <div class="media-body">

                    <div class="row">

                        <div class="col-md-6">

                            <p class="text-muted">{posted}</p>

                        </div>

                        <div class="col-md-6">

                            <p class="pull-right"><strong>{comment_id_link}</strong></p>

                        </div>

                    </div>

                    <hr />

                    <p>{message}</p>

                    {edited}

                </div>

            </div>

        </div>

        <div class="panel-footer">

            <div class="btn-toolbar">

                <div class="btn-group">

                    {btn_pm}
                    {btn_thumbs_up}

                </div>

                <!-- Check the user is logged in -->
                <?php if ($this->ion_auth->logged_in() === TRUE ) { ?>

                <div class="btn-group pull-right">

                    {btn_delete_comment}
                    {btn_edit_comment}
                    {btn_report}

                </div>

                <?php } ?>

            </div>

        </div>

    </div>

    {/comments}

<?php } else { ?>

    <div class="alert alert-info"><p><?=lang('txt_no_comments');?></p></div>

<?php } ?>

<div class="btn-toolbar pagination-toolbar" role="toolbar">

    <!-- Check the user is logged in -->
    <?php if ($this->ion_auth->logged_in() === TRUE ) { ?>

        <div class="btn-group pull-right">

            {btn_reply}

        </div>

        <div class="btn-group pull-right">

            {btn_new_discussion}

        </div>

    <?php } ?>

</div>

<!-- Check if the user is logged in -->
<?php if($this->ion_auth->logged_in() === TRUE) { ?>

    <div class="panel panel-warning" id="quick_reply">

        <div class="panel-heading">

            <p class="panel-title"><?=lang('txt_quick_reply');?></p>

        </div>

        <div class="panel-body">

            <div id="new_comment">

                {form_open}

                <div class="form-group <?php if(form_error('message')){echo 'has-error';} ?>">

                    {message_field}
                    {message_error}

                </div>

                <div class="form-group">

                    {btn_post_comment}

                </div>

                {form_close}

            </div>

        </div>

    </div>

<?php } ?>