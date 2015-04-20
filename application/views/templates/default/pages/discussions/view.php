{breadcrumbs}

<div class="panel panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">{discussion_name}</h3>

    </div>

    <div class="panel-body">

        <div class="media">

            <div class="media-left">{avatar}</div>

            <div class="media-body">

                <p>{created_by} in {category_name} - {date_created}</p>

                <p>{body}</p>

            </div>

        </div>

    </div>

</div>

<?php if($has_comments) { ?>

    {comments}

    <div class="panel panel-default">

        <div class="panel-body">

            <div class="media">

                <div class="media-left">{avatar}</div>

                <div class="media-body">

                    <p>{created_by} - {created_date}</p>

                    <p>{body}</p>

                </div>

            </div>

        </div>

    </div>

    {/comments}

<?php } ?>