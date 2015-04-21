{breadcrumbs}

<div class="well well-sm"><strong>{discussion_name}</strong></div>

<div class="panel panel-default">

    <div class="panel-heading">

        <div class="media-left">{avatar}</div>

        <div class="media-body">

            <p>{created_by}</p>

        </div>

    </div>

    <div class="panel-body">

        <div class="media">

            <div class="media-body">

                <p class="small text-muted">{date_created}</p>

                <hr />

                <p>{body}</p>

            </div>

        </div>

    </div>

</div>

<?php if($has_comments) { ?>

    {comments}

    <div class="panel panel-default" id="{comment_id}">

        <div class="panel-heading">

            <div class="media-left">{avatar}</div>

            <div class="media-body">

                <p>{created_by}</p>

            </div>

        </div>

        <div class="panel-body">

            <div class="media">

                <div class="media-body">

                    <div class="row">

                        <div class="col-md-6">

                            <p class="text-muted">{created_date}</p>

                        </div>

                        <div class="col-md-6">

                            <p class="pull-right"><strong>{comment_id_link}</strong></p>

                        </div>

                    </div>

                    <hr />

                    <p>{body}</p>

                </div>

            </div>

        </div>

        <div class="panel-footer">

            {report_button}

        </div>

    </div>

    {/comments}

<?php } else { ?>

    <div class="alert alert-info"><p>No comments to show, why not create one?</p></div>

<?php } ?>

<!-- Check if the user is logged in -->
<?php if($this->ion_auth->logged_in() === TRUE) { ?>

    <h4><small>Leave a comment</small></h4>

    <div id="new_comment">

        {form_open}

        <div class="form-group">

            {comment_field}

        </div>

        <div class="form-group">

            {discussion_id_field_hidden}
            {post_comment_button}

        </div>

        {form_close}

    </div>

<?php } ?>