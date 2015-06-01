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

        <h3 class="panel-title">All Categories</h3>

    </div>

    <div class="panel-body">

        <div class="media">

            <ul class="media-list">

                <?php if($has_categories === 1) { ?>

                    {categories}

                    <li class="media">

                        <div class="media-body">

                            <h5 class="media-heading"><strong>{name}</strong></h5>

                            <p>
                                {description}<br />
                                <span class="small">
                                    {discussion_count} Discussions&nbsp;&nbsp;&nbsp;&nbsp;
                                    {comment_count} Comments&nbsp;&nbsp;&nbsp;&nbsp;
                                    Most recent {latest_discussion}&nbsp;By {last_comment_by}
                                </span>
                            </p>

                        </div>

                    </li>

                    {/categories}

                <?php } else { ?>

                    <li class="media">

                        <div class="media-body">

                            <h4 class="media-heading"><strong>No Discussions</strong></h4>

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