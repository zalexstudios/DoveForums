<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussions extends Front_Controller {

    // Discussion ID storage.
    private $_discussion_id;

    // Comment ID storage.
    private $_comment_id;

    // Category ID storage.
    private $_category_id;

    // Validation rules array.
    private $validation_rules = array(
        'new_comment' => array(
            //0
            array(
                'field' => 'message',
                'rules' => 'required',
                'label' => 'lang:rules_comment',
            ),
        ),
        'new_reply' => array(
            //0
            array(
                'field' => 'message',
                'rules' => 'required',
                'label' => 'lang:rules_comment',
            ),
        ),
        'new_discussion' => array(
            //0
            array(
                'field' => 'subject',
                'rules' => 'required',
                'label' => 'lang:rules_subject',
            ),
            //1
            array(
                'field' => 'message',
                'rules' => 'required',
                'label' => 'lang:rules_body',
            ),
            //2
            array(
                'field' => 'category',
                'rules' => 'required',
                'label' => 'lang:rules_category',
            )
        ),
        'edit_discussion' => array(
            //0
            array(
                'field' => 'name',
                'rules' => 'required',
                'label' => 'lang:rules_subject',
            ),
            //1
            array(
                'field' => 'body',
                'rules' => 'required',
                'label' => 'lang:rules_body',
            ),
            //2
            array(
                'field' => 'category',
                'rules' => 'required',
                'label' => 'lang:rules_category',
            ),
        ),
        'report_discussion' => array(
            //0
            array(
                'field' => 'reason',
                'rules' => 'required',
                'label' => 'lang:rules_reason',
            ),
        ),
    );

    // Form Fields array.
    private $form_fields = array(
        'new_comment' => array(
            //0
            array(
                'id' => 'message',
                'name' => 'message',
                'type' => 'textarea',
                'class' => 'textarea',
                'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;',
            ),
        ),
        'new_reply' => array(
            //0
            array(
                'id' => 'message',
                'name' => 'message',
                'type' => 'textarea',
                'class' => 'textarea',
                'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;',
            ),
        ),
        'new_discussion' => array(
            //0
            array(
                'id' => 'subject',
                'name' => 'subject',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'message',
                'name' => 'message',
                'type' => 'textarea',
                'class' => 'textarea',
                'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;',
            ),
        ),
        'edit_discussion' => array(
            //0
            array(
                'id' => 'name',
                'name' => 'name',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'body',
                'name' => 'body',
                'type' => 'textarea',
                'class' => 'textarea',
                'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;',
            ),
        ),
    );

    /**
     * View
     *
     * View a discussion and all its comments.
     *
     * @param       integer      $discussion_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function view($discussion_id)
    {
        // Clear the discussion ID variable.
        $this->_discussion_id = '';

        // Set the current discussion ID variable.
        $this->set_discussion_id($discussion_id);

        //Check if the user has permission.
        if(!$this->permission->has_permission('view_discussions'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['new_comment']);

        // See if the form has been run.
        if( $this->form_validation->run() === FALSE )
        {
            // Get the discussion info.
            $discussion = $this->discussions->get_by('id', $this->_discussion_id);

            // Update the discussion view count.
            $this->discussions->update($this->_discussion_id, array('views' => ++$discussion->views));

            // Get the comments.
            $comments = $this->comments->get_many_by('discussion_id', $this->_discussion_id);

            // Clear the category ID variable.
            $this->_category_id = '';

            // Set the category ID variable.
            $this->_category_id = $discussion->category_id;

            // Define the page title.
            $data['title'] = ucwords($discussion->subject);

            // Define the page template.
            $data['template'] = 'pages/comments/view';

            // Loop through the comments.
            if( !empty( $comments ) )
            {
                foreach( $comments as $row )
                {
                    // Get the user for this comment.
                    $user = $this->ion_auth->user($row->poster_id)->row();

                    // Build the users avatar.
                    $data['avatar'] = array(
                        'src' => $this->gravatar->get_gravatar($user->email, $this->config->item('gravatar_rating'), $this->config->item('gravatar_size'), $this->config->item('gravatar_default_image') ),
                    );

                    $data['comments'][$row->id] = array(
                        'comment_id' => $row->id,
                        'comment_id_link' => anchor( site_url('discussions/view/'.$this->_discussion_id.'/#'.$row->id), '#'.$row->id.''),
                        'poster' => anchor( site_url('users/profile/'.$row->poster_id.''), ucwords($row->poster)),
                        'message' => $row->message,
                        'avatar' => img( element('avatar', $data) ),
                        'points' => $user->points,
                        'posted' => unix_to_human($row->posted),
                        'btn_report' => anchor( site_url('comments/report_comment/'.$row->id.''), lang('btn_report'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Report this comment to a moderator.')),
                        'btn_pm' => anchor( site_url('messages/send/'.$row->poster_id.''), lang('btn_pm'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Send this user a personal message.')),
                        'btn_thumbs_up' => anchor( site_url('users/thumbs_up/'.$row->poster_id.''), lang('btn_thumbs_up'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Give this user a Thumbs Up.' )),
                        'btn_edit_comment' => ($row->poster_id == $this->session->userdata('user_id') || $this->ion_auth->is_admin()) ? anchor( site_url( 'comments/edit_comment/'.$row->id.''), lang('btn_edit_comment'), array( 'class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Edit this Comment') ) : NULL,
                        'btn_delete_comment' => ($row->poster_id == $this->session->userdata('user_id') || $this->ion_auth->is_admin()) ? anchor( site_url( 'comments/delete_comment/'.$row->id.''), lang('btn_delete_comment'), array( 'class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete this Comment') ) : NULL,
                        'edited' => (!empty($row->edited) ? '<p class="text-muted">Edited '.unix_to_human($row->edited).' by '.$row->edited_by.'</p>' : ''),
                    );
                }

            } else {

                $data['comments'] = '';

            }

            // Build the page breadcrumbs.
            //$this->crumbs->add ($discussion->category_name);
            //$this->crumbs->add ($discussion->discussion_name);

            // Build the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('discussions/view/'.$this->_discussion_id.'/#quick_reply') ),
                'form_close' => form_close(),
                // Fields.
                'message_field' => form_textarea( $this->form_fields['new_comment'][0], set_value( $this->form_fields['new_comment'][0]['name'], $this->input->post('message') ) ),
                // Errors.
                'message_error' => form_error($this->form_fields['new_comment'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'btn_post_comment' => form_submit('submit', lang('btn_post_comment'), 'class="btn btn-primary btn-sm"'),
                'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
                'btn_reply' => anchor( site_url( 'discussions/reply/'.$this->_discussion_id), lang('btn_reply_discussion'), array( 'class' => 'btn btn-primary btn-sm' ) ),
                // Discussion Data.
                'discussion_name' => $discussion->subject,
                // Comment Data.
                'comments' => element( 'comments', $data ),
                'has_comments' => (!empty($comments)) ? 1 : 0,
                'breadcrumbs' => $this->crumbs->output(),
                'login_link' => anchor( site_url('users/login'), lang('lnk_login')),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Build the comment data.
            $data = array(
                'discussion_id' => $this->_discussion_id,
                'poster' => $this->session->userdata('username'),
                'poster_id' => $this->session->userdata('user_id'),
                'poster_ip' => $this->input->ip_address(),
                'message' => $this->input->post('message'),
                'posted' => now(),
            );

            // Clear the comment ID variable.
            $this->_comment_id = '';

            // Insert the comment & store the ID.
            $this->_comment_id = $this->comments->insert($data);

            // Get the discussion from the data.
            $discussion = $this->discussions->get_by('id', $this->_discussion_id);

            $discussion_replies = $discussion->replies;

            // Build the data for the discussion update.
            $data = array(
                'last_comment' => now(),
                'last_comment_id' => $this->_comment_id,
                'last_poster' => $this->session->userdata('username'),
                'last_poster_id' => $this->session->userdata('user_id'),
                'replies' => ++$discussion_replies,
            );

            // Update the discussion.
            $discussion_update = $this->discussions->update($this->_discussion_id, $data);

            // Get the category from the database.
            $category = $this->categories->get_by('id', $discussion->category_id);

            // Adjust the comment count.
            $comment_count = $category->comment_count;

            // Build the data for the category update.
            $data = array(
                'comment_count' => ++$comment_count,
            );

            // Update the category.
            $category_update = $this->categories->update($this->_category_id, $data);

            if(!empty($this->_comment_id) && !empty($category_update) && !empty($discussion_update))
            {
                if($this->permission->has_permission('unlock_achievements'))
                {
                    // Get the users comment count.
                    $comment_count = $this->comments->count($this->session->userdata('user_id'));

                    // See if the user is due an achievement.
                    $achievement = $this->achievements->give_achievement('create_comment', $comment_count);

                    if(is_array($achievement))
                    {
                        // Create a message.
                        $this->messageci->set( lang('success_creating_comment'), 'success' );

                        // Create achievement
                        $this->messageci->set( sprintf(lang('achievement_unlocked'), $achievement['points'], $achievement['name']),  'info');

                        // Redirect.
                        redirect( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'refresh' );
                    }
                    else
                    {
                        // Create a message.
                        $this->messageci->set( lang('success_creating_comment'), 'success' );

                        // Redirect.
                        redirect( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'refresh'  );
                    }
                }
                else
                {
                    // Create a message.
                    $this->messageci->set( lang('success_creating_comment'), 'success' );

                    // Redirect.
                    redirect( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'refresh'  );
                }
            }
            else
            {
                // Create a message.
                $this->messageci->set( lang('error_creating_comment'), 'error' );

                // Redirect.
                redirect( site_url('discussions/view/'.$this->_discussion_id), 'refresh' );
            }
        }
    }

    /**
     * Reply
     *
     * Create a full reply to the discussion.
     *
     * @param       integer     $discussion_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function reply($discussion_id)
    {
        // Clear the discussion ID variable.
        $this->_discussion_id = '';

        // Set the current discussion ID variable.
        $this->set_discussion_id($discussion_id);

        // Check if the user has permission.
        if(!$this->permission->has_permission('create_comments'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // See if the user is logged in.
        if ($this->ion_auth->logged_in() === FALSE)
        {
            // Create a message.
            $this->messageci->set( lang('error_login_required'), 'error');

            // Redirect.
            redirect('users/login', 'refresh');
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['new_reply']);

        // See if the form has been run.
        if( $this->form_validation->run() === FALSE )
        {
            // Define the page title.
            $data['title'] = lang('tle_new_reply');

            // Define the page template.
            $data['template'] = 'pages/discussions/reply';

            // Get the discussion info.
            $discussion = $this->discussions->get_by('id', $this->_discussion_id);

            // Build the page breadcrumbs.
            $this->crumbs->add($discussion->subject, 'discussions/view/'.$this->_discussion_id);
            $this->crumbs->add('Post Reply');

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open('discussions/reply/'.$this->_discussion_id),
                'form_close' => form_close(),
                // Fields.
                'message_field' => form_textarea( $this->form_fields['new_reply'][0], set_value( $this->form_fields['new_reply'][0]['name'], $this->input->post('message') ) ),
                // Errors.
                'message_error' => form_error($this->form_fields['new_reply'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'btn_post_comment' => form_submit('submit', lang('btn_post_comment'), 'class="btn btn-primary btn-sm"'),
                // Other.
                'discussion_name' => $discussion->subject,
                'logged_in_user' => $this->session->userdata('username'),
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {
            // Get the data required.
            $data = array(
                'poster' => $this->session->userdata('username'),
                'poster_id' => $this->session->userdata('user_id'),
                'poster_ip' => $this->input->ip_address(),
                'message' => $this->input->post('message'),
                'discussion_id' => $this->_discussion_id,
                'posted' => now(),
            );

            // Clear the comment ID variable.
            $this->_comment_id = '';

            // Set the comment ID variable.
            $this->_comment_id = $this->comments->insert($data);

            // Get the discussion from the database.
            $discussion = $this->discussions->get_by('id', $this->_discussion_id);

            // Replies count.
            $discussion_replies = $discussion->replies;

            // Build the data for the discussion update.
            $data = array(
                'last_comment' => now(),
                'last_comment_id' => $this->_comment_id,
                'last_poster' => $this->session->userdata('username'),
                'last_poster_id' => $this->session->userdata('user_id'),
                'replies' => ++$discussion_replies,
            );

            // Update the discussion.
            $discussion_update = $this->discussions->update($this->_discussion_id, $data);

            // Get the category from the database.
            $category = $this->categories->get_by('id', $discussion->category_id);

            // Comment count.
            $comment_count = $category->comment_count;

            // Build the data for the category update.
            $data = array(
                'comment_count' => ++$comment_count,
            );

            // Update the category.
            $category = $this->categories->update($category->id, $data);

            if(!empty($this->_comment_id) && !empty($discussion_update) && !empty($category))
            {
                if($this->permission->has_permission('unlock_achievements'))
                {
                    // Get the users comment count.
                    $comment_count = $this->comments->count($this->session->userdata('user_id'));

                    // See if the user is due an achievement.
                    $achievement = $this->achievements->give_achievement('create_comment', $comment_count);

                    if(is_array($achievement))
                    {
                        // Create a message.
                        $this->messageci->set( lang('success_creating_comment'), 'success' );

                        // Create achievement
                        $this->messageci->set( sprintf(lang('achievement_unlocked'), $achievement['points'], $achievement['name']),  'info');

                        // Redirect.
                        redirect( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'refresh' );
                    }
                    else
                    {
                        // Create a message.
                        $this->messageci->set( lang('success_creating_comment'), 'success' );

                        // Redirect.
                        redirect( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'refresh' );
                    }
                }
                else
                {
                    // Create a message.
                    $this->messageci->set( lang('success_creating_comment'), 'success' );

                    // Redirect.
                    redirect( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'refresh' );
                }
            }
            else
            {
                // Create a message.
                $this->messageci->set( lang('error_creating_comment'), 'error' );

                // Redirect.
                redirect( site_url('discussions/view/'.$this->_discussion_id), 'refresh' );
            }

        }
    }

    /**
     * New Discussion
     *
     * Allows the user to create a new discussion.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function new_discussion()
    {
        // Check if the user has permission.
        if(!$this->permission->has_permission('create_discussions'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['new_discussion']);

        // See if the form has been run.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_new_discussion');

            // Define the page template.
            $data['template'] = 'pages/discussions/new';

            // Build the page breadcrumbs.
            $this->crumbs->add( lang('crumb_create_discussion') );

            // Get all the categories.
            $categories = $this->categories->get_all();

            // Build the category dropdown.
            if(!empty($categories))
            {
                $category_options[NULL] = lang('dd_category_default');

                foreach($categories as $row)
                {
                    $category_options[$row->id] = $row->name;
                }
            }

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open('discussions/new_discussion'),
                'form_close' => form_close(),
                // Fields.
                'subject_field' => form_input( $this->form_fields['new_discussion'][0], set_value( $this->form_fields['new_discussion'][0]['name'], $this->input->post('subject') ) ),
                'message_field' => form_textarea( $this->form_fields['new_discussion'][1], set_value( $this->form_fields['new_discussion'][1]['name'], $this->input->post('message') ) ),
                'category_field' => form_dropdown('category', $category_options, '0', 'class="form-control"'),
                // Errors
                'subject_error' => form_error($this->form_fields['new_discussion'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'message_error' => form_error($this->form_fields['new_discussion'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'category_error' => form_error('category', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i>', '</p>'),
                // Buttons
                'btn_create_discussion' => form_submit('submit', lang('btn_create_discussion'), 'class="btn btn-primary btn-sm"'),
                // Other.
                'breadcrumbs' => $this->crumbs->output(),
                'logged_in_user' => $this->session->userdata('username'),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Build the discussion data.
            $data = array(
                'category_id' => $this->input->post('category'),
                'poster' => $this->session->userdata('username'),
                'posted' => now(),
                'subject' => $this->input->post('subject'),
                'last_poster' => $this->session->userdata('username'),
                'replies' => '1',
            );

            // Insert the discussion.
            $discussion_id = $this->discussions->insert($data);

            // Build the comment data.
            $data = array(
                'discussion_id' => $discussion_id,
                'poster' => $this->session->userdata('username'),
                'poster_id' => $this->session->userdata('user_id'),
                'poster_ip' => $this->input->ip_address(),
                'message' => $this->input->post('message'),
                'posted' => now(),
            );

            // Insert the discussion
            $comment_id = $this->comments->insert($data);

            // Build the data for the discussion update.
            $data = array(
                'first_comment_id' => $comment_id,
                'last_comment' => now(),
                'last_comment_id' => $comment_id,
            );

            // Update the discussion.
            $discussion = $this->discussions->update($discussion_id, $data);

            // Build the category data.
            $category = $this->categories->get_by('id', $this->input->post('category'));
            $discussion_count = $category->discussion_count;
            $comment_count = $category->comment_count;

            $data = array(
                'discussion_count' => ++$discussion_count,
                'comment_count' => ++$comment_count,
            );

            // Update the category.
            $category = $this->categories->update($this->input->post('category'), $data);

            if(!empty($discussion) && !empty($category))
            {
                if($this->permission->has_permission('unlock_achievements'))
                {
                    // Get the users comment count.
                    $discussion_count = $this->discussions->count($this->session->userdata('user_id'));

                    // See if the user is due an achievement.
                    $achievement = $this->achievements->give_achievement('create_discussion', $discussion_count);

                    if(is_array($achievement))
                    {
                        // Create a message.
                        $this->messageci->set( lang('success_create_discussion'), 'success' );

                        // Create achievement
                        $this->messageci->set( sprintf(lang('achievement_unlocked'), $achievement['points'], $achievement['name']),  'info');

                        // Redirect.
                        redirect( site_url('discussions/view/'.$discussion_id.'/#'.$comment_id), 'refresh' );
                    }
                    else
                    {
                        // Create a message.
                        $this->messageci->set( lang('success_create_discussion'), 'success' );

                        // Redirect.
                        redirect( site_url('discussions/view/'.$discussion_id.'/#'.$comment_id), 'refresh' );
                    }
                }
                else
                {
                    // Create a message.
                    $this->messageci->set( lang('success_create_discussion'), 'success' );

                    // Redirect.
                    redirect( site_url('discussions/view/'.$discussion_id.'/#'.$comment_id), 'refresh' );
                }
            }
            else
            {
                // Create a message.
                $this->messageci->set( lang('error_create_discussion'), 'error' );

                // Redirect.
                redirect( site_url(), 'refresh' );
            }

        }
    }

    /**
     * Report Discussion.
     *
     * Allows a user to report a discussion.
     *
     * @param       integer      $discussion_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function report_discussion ( $discussion_id = NULL )
    {
        // Check if the user has permission.
        if(!$this->permission->has_permission('report_discussions'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }
        // Check a discussion ID was supplied.
        if ( empty($discussion_id) || $discussion_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['report_discussion']);

        // See if the form has been run.
        if($this->form_validation->run() === FALSE) {

            // Define the page title.
            $data['title'] = lang('tle_report_discussion');

            // Define the page template.
            $data['template'] = 'pages/discussions/report';

            // Build the page breadcrumbs.
            $this->crumbs->add( lang('crumb_report_discussions') );

            // Build the reason dropdown.
            $reason = array(
                '' => lang('dd_default_reason'),
                '1' => lang('dd_break_rules'),
                '2' => lang('dd_inappropriate_content'),
                '3' => lang('dd_spam_content'),
                '4' => lang('dd_wrong_forum'),
                '5' => lang('dd_other'),
            );

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open('discussions/report_discussion/' . $discussion_id),
                'form_close' => form_close(),
                // Fields.
                'report_field' => form_dropdown('reason', $reason, '0', 'class="form-control"'),
                // Errors
                'report_error' => form_error('reason', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i>', '</p>'),
                // Hidden
                'discussion_id_hidden_field' => form_hidden('discussion_id', $discussion_id),
                // Buttons
                'btn_report_discussion' => form_submit('submit', lang('btn_report_discussion'), 'class="btn btn-primary btn-sm"'),
                // Other.
                'breadcrumbs' => $this->crumbs->output(),
                'logged_in_user' => $this->session->userdata('username'),
            );

            $this->render(element('page', $data), element('title', $data), element('template', $data));
        }
        else
        {
            // Gather the data.
            $data = array(
                'reason' => $this->input->post('reason'),
            );

            if ($this->forums->report_discussion($this->input->post('discussion_id'), $data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( lang('success_report_discussion'),  'success');

                // Redirect.
                redirect( site_url(), 'refresh' );
            } else {
                // Create a message.
                $this->messageci->set( lang('error_report_discussion'),  'error');

                // Redirect.
                redirect( site_url(), 'refresh');
            }
        }
    }

    /**
     * Edit Discussion
     *
     * Allows the user to edit the discussion via the supplied
     * discussion ID.
     *
     * @param       integer      $discussion_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function edit_discussion ( $discussion_id = NULL )
    {
        // Check if the user has permission.
        if(!$this->permission->has_permission('edit_discussions'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Check a discussion ID was supplied.
        if ( empty($discussion_id) || $discussion_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['edit_discussion']);

        // See if the form has been run.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_edit_discussion');

            // Define the page template.
            $data['template'] = 'pages/discussions/edit';

            // Build the page breadcrumbs.
            $this->crumbs->add( lang('crumb_edit_discussion') );

            // Get the discussion from the database.
            $discussion = $this->forums->get_discussion_by_id($discussion_id);

            // Get all the categories.
            $categories = $this->forums->get_categories_dropdown();

            // Build the category dropdown.
            if(!empty($categories))
            {
                $category_options[NULL] = lang('dd_category_default');

                foreach($categories as $row)
                {
                    $category_options[$row->category_id] = $row->name;
                }
            }

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open('discussions/edit_discussion/'.$discussion_id),
                'form_close' => form_close(),
                // Fields.
                'name_field' => form_input( $this->form_fields['edit_discussion'][0], set_value( $this->form_fields['edit_discussion'][0]['name'], $discussion->discussion_name ) ),
                'body_field' => form_textarea( $this->form_fields['edit_discussion'][1], set_value( $this->form_fields['edit_discussion'][1]['name'], $discussion->body ) ),
                'category_field' => form_dropdown('category', $category_options, $discussion->category_id, 'class="form-control"'),
                // Errors
                'name_error' => form_error($this->form_fields['edit_discussion'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'body_error' => form_error($this->form_fields['edit_discussion'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'category_error' => form_error('category', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i>', '</p>'),
                // Buttons
                'btn_update_discussion' => form_submit('submit', lang('btn_update_discussion'), 'class="btn btn-primary btn-sm"'),
                // Hidden.
                'discussion_id_hidden_field' => form_hidden('discussion_id', $discussion_id),
                // Other.
                'breadcrumbs' => $this->crumbs->output(),
                'logged_in_user' => $this->session->userdata('username'),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {
            // Gather the data.
            $data = array(
                'name' => $this->input->post('name'),
                'body' => $this->input->post('body'),
                'category' => $this->input->post('category'),
            );

            if ($this->forums->update_discussion($this->input->post('discussion_id'), $data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( sprintf(lang('success_update_discussion'), $this->input->post('name')), 'success');

                // Redirect.
                redirect( site_url('forums'), 'refresh' );
            } else {
                // Create a message.
                $this->messageci->set( sprintf(lang('error_update_discussion'), $this->input->post('name')), 'error');

                // Redirect.
                redirect( site_url('forums'), 'refresh');
            }
        }

    }

    /**
     * Delete Discussion
     *
     * Deletes the discussion via the supplied discussion ID.
     *
     * @param       integer      $discussion_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_discussion ( $discussion_id = NULL )
    {
        // Check if the user has permission.
        if(!$this->permission->has_permission('delete_discussions'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Check a discussion ID was supplied.
        if ( empty($discussion_id) || $discussion_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        if($this->forums->delete_discussion($discussion_id))
        {
            // Create a message.
            $this->messageci->set( lang('success_delete_discussion'), 'success');

            // Redirect.
            redirect( site_url(), 'refresh');

        } else {
            // Create a message.
            $this->messageci->set( lang('error_delete_discussion'), 'error');

            // Redirect.
            redirect( site_url(), 'refresh');
        }
    }

    private function set_discussion_id($discussion_id)
    {
        $this->_discussion_id = $discussion_id;
    }

    private function get_discussion_id()
    {
        return $this->_discussion_id;
    }

}
