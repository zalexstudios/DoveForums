<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    {breadcrumbs}

    <h4><strong>{is_sticky}{is_closed}{discussion_name}</strong></h4>

<div class="btn-toolbar pagination-toolbar" role="toolbar">

    <?php if($this->ion_auth->is_admin()) { ?>

    <div class="btn-group pull-right">

        <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cog fa-fw"></i> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li>{lnk_sticky}</li>
            <li>{lnk_close}</li>
        </ul>

    </div>

    <?php } ?>

    <!-- Check the user is logged in -->
    <?php if ($this->ion_auth->logged_in() === TRUE) { ?>

        <?php if (empty($is_closed)) { ?>

        <div class="btn-group pull-right">

            {btn_reply}

        </div>

        <?php } ?>

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

                <p>{online}&nbsp;{poster}<br><span class="label label-success">{points} Xp</span></p>

            </div>

        </div>

        <div class="panel-body">

            <div class="media">

                <div class="media-body">

                    <p class="text-muted"><small>{posted}&nbsp;<?= lang('txt_ago'); ?></small></p>

                    <hr />

                    <p>{message}</p>

                    {edited}

                </div>

            </div>

        </div>

        <!-- Check the user is logged in -->
        <?php if ($this->ion_auth->logged_in() === TRUE ) { ?>

        <div class="panel-footer">

            <div class="btn-toolbar">

                <div class="btn-group">

                    {btn_pm}
                    {btn_thumbs_up}

                </div>

                <div class="btn-group pull-right">

                    {btn_delete_comment}
                    {btn_edit_comment}
                    {btn_report}

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

    {/comments}

<?php } else { ?>

    <div class="alert alert-info"><p><?=lang('txt_no_comments');?></p></div>

<?php } ?>

<div class="btn-toolbar pagination-toolbar" role="toolbar">

    <!-- Check the user is logged in -->
    <?php if ($this->ion_auth->logged_in() === TRUE ) { ?>

        <?php if (empty($is_closed)) { ?>

            <div class="btn-group pull-right">

                {btn_reply}

            </div>

        <?php } ?>

        <div class="btn-group pull-right">

            {btn_new_discussion}

        </div>

    <?php } ?>

</div>

<!-- Check if the user is logged in -->
<?php if($this->ion_auth->logged_in() === TRUE) { ?>

    <?php if (empty($is_closed)) { ?>

    <div class="panel panel-warning" id="quick_reply">

        <div class="panel-heading">

            <p class="panel-title"><?=lang('txt_quick_reply');?></p>

        </div>

        <div class="panel-body">

            <div id="new_comment">

                {form_open}

                <div class="form-group <?php if(form_error('message')){echo 'has-error';} ?>">

                    <textarea name="message" id="message" class="ckeditor">

                        {message}

                    </textarea>

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

<?php } ?>