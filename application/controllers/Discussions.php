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
                'class' => 'ckeditor',
            ),
        ),
        'new_reply' => array(
            //0
            array(
                'id' => 'message',
                'name' => 'message',
                'class' => 'ckeditor',
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
                'class' => 'ckeditor',
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
                'class' => 'ckeditor',
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

        // Mark the discussion as read.
        $this->unread->mark_read($discussion_id);

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['new_comment']);

        // See if the form has been run.
        if( $this->form_validation->run() === FALSE )
        {
            // Get the discussion info.
            $discussion = $this->discussions->order_by(array('sticky' => 'DESC', 'posted' => 'DESC'))->get_by('id', $this->_discussion_id);

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

                    // Check the giver has not already given a thumbs up to this user for this comment.
                    $check = $this->thumbs->get_by(array('discussion_id' => $discussion_id, 'comment_id' => $row->id, 'recipient_user_id' => $row->poster_id, 'giver_user_id' => $this->session->userdata('user_id')));

                    $data['comments'][$row->id] = array(
                        'comment_id' => $row->id,
                        'poster' => anchor( site_url('users/profile/'.$row->poster_id.''), ucwords($row->poster)),
                        'message' => $row->message,
                        'avatar' => img( element('avatar', $data) ),
                        'points' => $user->points,
                        'posted' => timespan($row->posted, time()),
                        'btn_report' => anchor( site_url('comments/report_comment/'.$row->id.''), lang('btn_report'), array('class' => 'btn btn-default btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('tip_report_comment'))),
                        'btn_pm' => anchor( site_url('messages/send/'.$row->poster_id.''), lang('btn_pm'), array('class' => 'btn btn-default btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('tip_send_user_pm'))),
                        'btn_thumbs_up' => (!$check ? anchor( site_url('users/thumbs_up/'.$row->poster_id.'/'.$row->discussion_id.'/'.$row->id), lang('btn_thumbs_up'), array('class' => 'btn btn-default btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('tip_thumbs_up') )) : anchor('#', lang('btn_thumbs_up'), array('class' => 'btn btn-default btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('tip_thumbs_up'), 'disabled' => 'disabled' ))),
                        'btn_edit_comment' => ($row->poster_id == $this->session->userdata('user_id') || $this->ion_auth->is_admin()) ? anchor( site_url( 'comments/edit_comment/'.$row->id.''), lang('btn_edit'), array( 'class' => 'btn btn-default btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('tip_edit_comment')) ) : NULL,
                        'btn_delete_comment' => ($row->poster_id == $this->session->userdata('user_id') || $this->ion_auth->is_admin()) ? anchor( site_url( 'comments/delete_comment/'.$row->id.''), lang('btn_delete'), array( 'class' => 'btn btn-default btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('tip_delete_comment')) ) : NULL,
                        'edited' => (!empty($row->edited) ? '<hr /><p class="text-muted"><small>'.lang('txt_edited').'&nbsp;'.unix_to_human($row->edited).'&nbsp;'.lang('txt_by').'&nbsp;'.$row->edited_by.'</small></p>' : ''),
                        'given' => ($check ? '<span class="small text-muted">Thumbed at '.unix_to_human($check->given).'</span>' : ''),
                        'online' => ($this->users->user_online($user->id) == TRUE ? '<i class="fa fa-circle online" title="'.lang('txt_online').'"></i>' : '<i class="fa fa-circle offline" title="'.lang('txt_offline').'"></i>'),
                    );
                }

            } else {

                $data['comments'] = '';

            }

            // Get the category.
            $category = $this->categories->get_by('id', $discussion->category_id);

            // Build the page breadcrumbs.
            $this->crumbs->add ($category->name);
            $this->crumbs->add ($discussion->subject);

            // Build the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('discussions/view/'.$this->_discussion_id.'/#quick_reply') ),
                'form_close' => form_close(),
                // Fields.
                'message' => $this->input->post('message'),
                // Errors.
                'message_error' => form_error($this->form_fields['new_comment'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'btn_post_comment' => form_submit('submit', lang('btn_post_comment'), 'class="btn btn-primary btn-xs"'),
                'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-xs' )),
                'btn_reply' => anchor( site_url( 'discussions/reply/'.$this->_discussion_id), lang('btn_reply_discussion'), array( 'class' => 'btn btn-primary btn-xs' ) ),
                'lnk_sticky' => ($discussion->sticky == 0 ? anchor( site_url('discussions/sticky/'.$this->_discussion_id), lang('lnk_sticky')) : anchor( site_url('discussions/unstick/'.$this->_discussion_id), lang('lnk_unstick'))),
                'lnk_close' => ($discussion->closed == 0 ? anchor( site_url('discussions/close/'.$this->_discussion_id), lang('lnk_close')) : anchor( site_url('discussions/open/'.$this->_discussion_id), lang('lnk_open'))),
                // Discussion Data.
                'discussion_name' => $discussion->subject,
                // Comment Data.
                'comments' => element( 'comments', $data ),
                'has_comments' => (!empty($comments)) ? 1 : 0,
                'breadcrumbs' => $this->crumbs->output(),
                'login_link' => anchor( site_url('users/login'), lang('lnk_login')),
                'is_sticky' => ($discussion->sticky == 1 ? '<i class="fa fa-thumb-tack"></i>&nbsp;' : ''),
                'is_closed' => ($discussion->closed == 1 ? '<i class="fa fa-lock"></i>&nbsp;' : ''),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Build the comment data.
            $data = array(
                'discussion_id' => $this->_discussion_id,
                'poster' => $this->session->userdata('username'),
                'poster_id' => $this->session->userdata('user_id'),
                'poster_ip' => $this->input->ip_address(),
                'message' => $this->replace_links($this->input->post('message'), 'nofollow'),
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
                // Email the discussion creator.
                $data['email'] = array(
                    'username' => $this->session->userdata('username'),
                    'discussion' => $discussion->subject,
                    'reply' => anchor( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'Here'),
                    'site_name' => $this->config->item('site_name'),
                    'subject' => lang('txt_new_reply'),
                );

                $user = $this->users->get_by(array('username' => $discussion->poster));

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

                        // Send an email to the discussion creator if they want to receive one.
                        if($this->session->userdata('username') != $discussion->poster && $user->notify_of_replies == 1)
                        {
                            $this->send_email($user->email, 'default/emails/new_reply', element('email', $data));
                        }
                    }
                    else
                    {
                        // Create success message.
                        $this->messageci->set( lang('success_creating_comment'), 'success' );

                        // Send an email to the discussion creator if they want to receive one.
                        if($this->session->userdata('username') != $discussion->poster && $user->notify_of_replies == 1)
                        {
                            $this->send_email($user->email, 'default/emails/new_reply', element('email', $data));
                        }
                    }
                }
                else
                {
                    // Create success message.
                    $this->messageci->set( lang('success_creating_comment'), 'success' );

                    // Send an email to the discussion creator if they want to receive one.
                    if($this->session->userdata('username') != $discussion->poster && $user->notify_of_replies == 1)
                    {
                        $this->send_email($user->email, 'default/emails/new_reply', element('email', $data));
                    }
                }
            }
            else
            {
                // Create error message.
                $this->messageci->set( lang('error_creating_comment'), 'error' );
            }

            // Redirect.
            redirect( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'refresh' );
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
                'message' => $this->input->post('message'),
                // Errors.
                'message_error' => form_error($this->form_fields['new_reply'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'btn_post_comment' => form_submit('submit', lang('btn_post_comment'), 'class="btn btn-primary btn-xs"'),
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
                'message' => $this->replace_links($this->input->post('message'), 'nofollow'),
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
                // Email the discussion creator.
                $data['email'] = array(
                    'username' => $this->session->userdata('username'),
                    'discussion' => $discussion->subject,
                    'reply' => anchor( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'Here'),
                    'site_name' => $this->config->item('site_name'),
                    'subject' => lang('txt_new_reply'),
                );

                $user = $this->users->get_by(array('username' => $discussion->poster));

                if($this->permission->has_permission('unlock_achievements'))
                {
                    // Get the users comment count.
                    $comment_count = $this->comments->count($this->session->userdata('user_id'));

                    // See if the user is due an achievement.
                    $achievement = $this->achievements->give_achievement('create_comment', $comment_count);

                    if(is_array($achievement))
                    {
                        // Create success message.
                        $this->messageci->set( lang('success_creating_comment'), 'success' );

                        // Create achievement
                        $this->messageci->set( sprintf(lang('achievement_unlocked'), $achievement['points'], $achievement['name']),  'info');

                        // Send an email to the discussion creator if they want to receive one.
                        if($this->session->userdata('username') != $discussion->poster && $user->notify_of_replies == 1)
                        {
                            $this->send_email($user->email, 'default/emails/new_reply', element('email', $data));
                        }
                    }
                    else
                    {
                        // Create success message.
                        $this->messageci->set( lang('success_creating_comment'), 'success' );

                        // Send an email to the discussion creator if they want to receive one.
                        if($this->session->userdata('username') != $discussion->poster && $user->notify_of_replies == 1)
                        {
                            $this->send_email($user->email, 'default/emails/new_reply', element('email', $data));
                        }
                    }
                }
                else
                {
                    // Create success message.
                    $this->messageci->set( lang('success_creating_comment'), 'success' );

                    // Send an email to the discussion creator if they want to receive one.
                    if($this->session->userdata('username') != $discussion->poster && $user->notify_of_replies == 1)
                    {
                        $this->send_email($user->email, 'default/emails/new_reply', element('email', $data));
                    }
                }
            }
            else
            {
                // Create error message.
                $this->messageci->set( lang('error_creating_comment'), 'error' );
            }

            // Redirect.
            redirect( site_url('discussions/view/'.$this->_discussion_id.'/#'.$this->_comment_id), 'refresh' );

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
                'message' => $this->input->post('message'),
                'category_field' => form_dropdown('category', $category_options, '0', 'class="form-control"'),
                // Errors
                'subject_error' => form_error($this->form_fields['new_discussion'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'message_error' => form_error($this->form_fields['new_discussion'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'category_error' => form_error('category', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i>', '</p>'),
                // Buttons
                'btn_create_discussion' => form_submit('submit', lang('btn_create_discussion'), 'class="btn btn-primary btn-xs"'),
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
                'message' => $this->replace_links($this->input->post('message'), 'nofollow'),
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
                'btn_report_discussion' => form_submit('submit', lang('btn_report_discussion'), 'class="btn btn-primary btn-xs"'),
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
            // Create error message.
            $this->messageci->set( lang('error_permission_required'), 'error');
        }

        // Check a discussion ID was supplied.
        if ( empty($discussion_id) || $discussion_id === NULL )
        {
            // Create error message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );
        }

        if($this->forums->delete_discussion($discussion_id))
        {
            // Create success message.
            $this->messageci->set( lang('success_delete_discussion'), 'success');
        }
        else {
            // Create error message.
            $this->messageci->set( lang('error_delete_discussion'), 'error');
        }

        // Redirect.
        redirect( site_url(), 'refresh');
    }

    public function sticky($discussion_id)
    {
        // Clear the discussion id.
        $this->_discussion_id = '';

        // Set the discussion id.
        $this->_discussion_id = $discussion_id;

        // Get the discussion.
        $discussion = $this->discussions->get_by('id', $this->_discussion_id);

        // Update the discussion.
        $update = $this->discussions->update($discussion_id, array('sticky' => 1));

        if($update)
        {
            // Create success message.
            $this->messageci->set( sprintf(lang('success_sticky_discussion'), $discussion->subject), 'success');
        } else {
            // Create error message.
            $this->messageci->set( sprintf(lang('error_sticky_discussion'), $discussion->subject), 'error');
        }

        // Redirect.
        redirect( $this->agent->referrer(), 'refresh');
    }

    public function unstick($discussion_id)
    {
        // Clear the discussion id.
        $this->_discussion_id = '';

        // Set the discussion id.
        $this->_discussion_id = $discussion_id;

        // Get the discussion.
        $discussion = $this->discussions->get_by('id', $this->_discussion_id);

        // Update the discussion.
        $update = $this->discussions->update($this->_discussion_id, array('sticky' => 0));

        if($update)
        {
            // Create success message.
            $this->messageci->set( sprintf(lang('success_unstick_discussion'), $discussion->subject), 'success');
        } else {
            // Create error message.
            $this->messageci->set( sprintf(lang('error_unstick_discussion'), $discussion->subject), 'error');
        }

        // Redirect.
        redirect( $this->agent->referrer(), 'refresh');
    }

    public function open($discussion_id)
    {
        // Clear the discussion id.
        $this->_discussion_id = '';

        // Set the discussion id.
        $this->_discussion_id = $discussion_id;

        // Get the discussion.
        $discussion = $this->discussions->get_by('id', $this->_discussion_id);

        // Update the discussion.
        $update = $this->discussions->update($this->_discussion_id, array('closed' => 0));

        if($update)
        {
            // Create success message.
            $this->messageci->set( sprintf(lang('success_open_discussion'), $discussion->subject), 'success');
        } else {
            // Create error message.
            $this->messageci->set( sprintf(lang('error_open_discussion'), $discussion->subject), 'error');
        }

        // Redirect.
        redirect( $this->agent->referrer(), 'refresh');
    }

    public function close($discussion_id)
    {
        // Clear the discussion id.
        $this->_discussion_id = '';

        // Set the discussion id.
        $this->_discussion_id = $discussion_id;

        // Get the discussion.
        $discussion = $this->discussions->get_by('id', $this->_discussion_id);

        // Update the discussion.
        $update = $this->discussions->update($discussion_id, array('closed' => 1));

        if($update)
        {
            // Create success message.
            $this->messageci->set( sprintf(lang('success_close_discussion'), $discussion->subject), 'success');
        } else {
            // Create error message.
            $this->messageci->set( sprintf(lang('error_close_discussion'), $discussion->subject), 'error');
        }

        // Redirect.
        redirect( $this->agent->referrer(), 'refresh');
    }

    public function mark_all()
    {
        $mark = $this->unread->mark_all();

        if($mark)
        {
            // Create success message.
            $this->messageci->set( lang('success_mark_all'), 'success');
        } else {
            // Create error message.
            $this->messageci->set( lang('error_mark_all'), 'error');
        }

        redirect( $this->agent->referrer(), 'refresh');
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