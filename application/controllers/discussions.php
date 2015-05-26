<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussions extends Front_Controller {

    private $validation_rules = array(
        'new_comment' => array(
            //0
            array(
                'field' => 'comment',
                'rules' => 'required',
                'label' => 'lang:rules_comment',
            ),
        ),
        'new_reply' => array(
            //0
            array(
                'field' => 'comment',
                'rules' => 'required',
                'label' => 'lang:rules_comment',
            ),
        ),
        'new_discussion' => array(
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
            )
        ),
    );

    private $form_fields = array(
        'new_comment' => array(
            //0
            array(
                'id' => 'comment',
                'name' => 'comment',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
        'new_reply' => array(
            //0
            array(
                'id' => 'comment',
                'name' => 'comment',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
        'new_discussion' => array(
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
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
    );

    /**
     * View
     *
     * View a discussion and all its comments.
     *
     * @param       string      $category_slug
     * @param       string      $discussion_slug
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function view ($category_slug, $discussion_slug)
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['new_comment']);

        // See if the form has been run.
        if( $this->form_validation->run() === FALSE )
        {
            // Get the discussion info.
            $discussion = $this->forums->get_discussion($discussion_slug);

            // Update the discussion view count.
            $this->forums->update_discussion_count( $discussion->discussion_id, ++$discussion->view_count );

            // Setup the Pagination.
            $config['base_url'] = site_url('discussions/'.$category_slug.'/'.$discussion_slug.'');
            $config['total_rows'] = count( $this->forums->get_comments( $discussion->discussion_id ) );
            $config['per_page'] = $this->config->item('comments_per_page');
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $this->pagination->initialize($config);

            // Get the comments.
            $comments = $this->forums->get_comments($discussion->discussion_id, $config['per_page'], $page);

            // Define the page title.
            $data['title'] = ucwords($discussion->discussion_name);

            // Define the page template.
            $data['template'] = 'pages/discussions/view';

            // Loop through the comments.
            if( !empty( $comments ) )
            {
                foreach( $comments as $row )
                {
                    // build the users avatar.
                    $data['avatar'] = array(
                        'src' => $this->gravatar->get_gravatar($row->email, $this->config->item('gravatar_rating'), $this->config->item('gravatar_size'), $this->config->item('gravatar_default_image') ),
                    );

                    $data['comments'][] = array(
                        'comment_id' => $row->comment_id,
                        'comment_id_link' => anchor( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'/#'.$row->comment_id.''), '#'.$row->comment_id.''),
                        'created_by' => anchor( site_url('users/profile/'.$row->user_id.''), ucwords($row->username)),
                        'body' => nl2br($row->body),
                        'avatar' => img( element('avatar', $data) ),
                        'created_date' => date('jS M Y - h:i:s A', strtotime( $row->insert_date ) ),
                        'report_button' => anchor( site_url('comments/report_comment/'.$row->comment_id.''), '<i class="fa fa-bullhorn"></i> Report', array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Report this comment to a moderator.')),
                        'pm_button' => anchor( site_url('messages/send/'.$row->user_id.''), '<i class="fa fa-envelope-o"></i> PM', array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Send this user a personal message.')),
                        'thumbs_up_button' => anchor( site_url('users/thumbs_up/'.$row->user_id.''), '<i class="fa fa-thumbs-o-up"></i>', array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Give this user a Thumbs Up.' )),
                        'edit_comment_button' => anchor( site_url( 'comments/edit_comment/'.$row->comment_id.''), lang('btn_edit_comment'), array( 'class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Edit this Comment') ),
                        'delete_comment_button' => anchor( site_url( 'comments/delete_comment/'.$row->comment_id.''), lang('btn_delete_comment'), array( 'class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete this Comment') ),
                    );
                }

            } else {

                $data['comments'] = '';

            }

            // Build the discussion starters avatar.
            $data['avatar'] = array(
                'src' => $this->gravatar->get_gravatar($discussion->email, $this->config->item('gravatar_rating'), $this->config->item('gravatar_size'), $this->config->item('gravatar_default_image') ),
                'class' => 'media-object'
            );

            // Build the page breadcrumbs.
            $this->crumbs->add ($discussion->category_name, 'categories/'.$category_slug.'');
            $this->crumbs->add ($discussion->discussion_name, 'discussions/'.$category_slug.'/'.$discussion_slug.'');

            // Build the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'/#quick_reply') ),
                'form_close' => form_close(),
                // Fields.
                'comment_field' => form_textarea( $this->form_fields['new_comment'][0], set_value( $this->form_fields['new_comment'][0]['name'], $this->input->post('comment') ) ),
                // Hidden Fields.
                'discussion_id_field_hidden' => form_hidden('discussion_id', $discussion->discussion_id),
                'category_id_field_hidden' => form_hidden('category_id', $discussion->category_id),
                // Errors.
                'comment_error' => form_error($this->form_fields['new_comment'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'post_comment_button' => form_submit('submit', lang('btn_post_comment'), 'class="btn btn-primary btn-sm"'),
                'report_button' => anchor( site_url('discussions/report_discussion/'.$discussion->discussion_id.''), lang('btn_report'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Report this discussion to a moderator.')),
                'pm_button' => anchor( site_url('messages/send/'.$discussion->insert_user_id.''), lang('btn_send_pm'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Send this user a private message.')),
                'thumbs_up_button' => anchor( site_url('users/thumbs_up/'.$discussion->insert_user_id.''), lang('btn_thumbs_up'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Give this user a Thumbs Up.')),
                'new_discussion_button' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
                'reply_button' => anchor( site_url( 'discussions/reply/'.$category_slug.'/'.$discussion_slug.'' ), lang('btn_reply_discussion'), array( 'class' => 'btn btn-primary btn-sm' ) ),
                'edit_discussion_button' => anchor( site_url( 'discussions/edit_discussion/'.$discussion->discussion_id), lang('btn_edit_discussion'), array( 'class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Edit this Discussion') ),
                'delete_discussion_button' => anchor( site_url( 'discussions/delete_discussion/'.$discussion->discussion_id), lang('btn_delete_discussion'), array( 'class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Delete this Discussion') ),
                // Discussion Data.
                'comment_id' => '#0',
                'comment_id_link' => anchor( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'/#0'), '#0'),
                'discussion_name' => $discussion->discussion_name,
                'created_by' => anchor( site_url('users/profile/'.$discussion->user_id), ucwords( $discussion->username ) ),
                'body' => nl2br($discussion->body),
                'avatar' => img( element('avatar', $data ) ),
                'created_date' => date('jS M Y - h:i:s A', strtotime( $discussion->insert_date )),
                // Comment Data.
                'comments' => element( 'comments', $data ),
                'has_comments' => (!empty($comments)) ? 1 : 0,
                'breadcrumbs' => $this->crumbs->output(),
                'login_link' => anchor( site_url('users/login'), 'Login'),
                // Other.
                'pagination' => $this->pagination->create_links(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Get the data required.
            $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'discussion_id' => $this->input->post('discussion_id'),
                'category_id' => $this->input->post('category_id'),
                'body' => $this->input->post('comment'),
                'insert_ip' => $this->input->ip_address(),
            );

            // Add Comment.
            $add_comment = $this->forums->add_comment( $data );

            if($add_comment === TRUE)
            {
                // Create a message.
                $this->messageci->set( lang('success_creating_comment'), 'success' );

                // Redirect.
                redirect( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'') );
            }
            else
            {
                // Create a message.
                $this->messageci->set( lang('error_creating_comment'), 'error' );

                // Redirect.
                redirect( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'') );
            }
        }
    }

    /**
     * Reply
     *
     * Create a full reply to the discussion.
     *
     * @param       string      $category_slug
     * @param       string      $discussion_slug
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function reply ($category_slug, $discussion_slug)
    {
        // See if the user is logged in.
        if ($this->ion_auth->logged_in() === FALSE)
        {
            // Create a message.
            $this->messageci->set( lang('error_login_required'), 'error');

            // Redirect.
            redirect('discussions/'.$category_slug.'/'.$discussion_slug.'', 'redirect');
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['new_reply']);

        // See if the form has been run.
        if( $this->form_validation->run() === FALSE )
        {
            // Define the page title.
            $data['title'] = 'Post a New Reply';

            // Define the page template.
            $data['template'] = 'pages/discussions/reply';

            // Get the discussion info.
            $discussion = $this->forums->get_discussion($discussion_slug);

            // Build the page breadcrumbs.
            $this->crumbs->add($discussion->category_name, 'categories/'.$category_slug.'');
            $this->crumbs->add($discussion->discussion_name, 'discussions/'.$category_slug.'/'.$discussion_slug.'');
            $this->crumbs->add('Post Reply');

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open('discussions/reply/'.$category_slug.'/'.$discussion_slug.''),
                'form_close' => form_close(),
                // Fields.
                'comment_field' => form_textarea( $this->form_fields['new_reply'][0], set_value( $this->form_fields['new_reply'][0]['name'], $this->input->post('comment') ) ),
                // Hidden Fields.
                'discussion_id_field_hidden' => form_hidden('discussion_id', $discussion->discussion_id),
                'category_id_field_hidden' => form_hidden('category_id', $discussion->category_id),
                // Errors.
                'comment_error' => form_error($this->form_fields['new_reply'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'post_comment_button' => form_submit('submit', lang('btn_post_comment'), 'class="btn btn-primary btn-sm"'),
                // Other.
                'discussion_name' => $discussion->discussion_name,
                'logged_in_user' => $this->session->userdata('username'),
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {
            // Get the data required.
            $data = array(
                'user_id'           => $this->session->userdata('user_id'),
                'discussion_id'     => $this->input->post('discussion_id'),
                'category_id'       => $this->input->post('category_id'),
                'body'              => $this->input->post('comment'),
                'insert_ip'         => $this->input->ip_address(),
            );

            // Add Comment.
            $add_comment = $this->forums->add_comment( $data );

            if($add_comment === TRUE)
            {
                // Create a message.
                $this->messageci->set( lang('success_creating_comment'), 'success' );

                // Redirect.
                redirect( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'') );
            }
            else
            {
                // Create a message.
                $this->messageci->set( lang('error_creating_comment'), 'error' );

                // Redirect.
                redirect( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'') );
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
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['new_discussion']);

        // See if the form has been run.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = 'Create a new Discussion';

            // Define the page template.
            $data['template'] = 'pages/discussions/new';

            // Build the page breadcrumbs.
            $this->crumbs->add('Create Discussion');

            // Get all the categories.
            $categories = $this->forums->get_categories_dropdown();

            // Build the category dropdown.
            if(!empty($categories))
            {
                $category_options[NULL] = 'Pick Category...';

                foreach($categories as $row)
                {
                    $category_options[$row->category_id] = $row->name;
                }
            }

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open('discussions/new_discussion'),
                'form_close' => form_close(),
                // Fields.
                'name_field' => form_input( $this->form_fields['new_discussion'][0], set_value( $this->form_fields['new_discussion'][0]['name'], $this->input->post('name') ) ),
                'body_field' => form_textarea( $this->form_fields['new_discussion'][1], set_value( $this->form_fields['new_discussion'][1]['name'], $this->input->post('body') ) ),
                'category_field' => form_dropdown('category', $category_options, '0', 'class="form-control"'),
                // Errors
                'name_error' => form_error($this->form_fields['new_discussion'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'body_error' => form_error($this->form_fields['new_discussion'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'category_error' => form_error('category', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i>', '</p>'),
                // Buttons
                'btn_create_discussion' => form_submit('submit', lang('btn_create_discussion'), 'class="btn btn-primary btn-sm"'),
                // Other.
                'breadcrumbs' => $this->crumbs->output(),
                'logged_in_user' => $this->session->userdata('username'),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Gather the data.
            $data = array(
                'name' => $this->input->post('name'),
                'body' => $this->input->post('body'),
                'category' => $this->input->post('category'),
            );

            if ($this->forums->create_discussion($data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( lang('success_create_discussion'), 'success');

                // Redirect.
                redirect( site_url(), 'refresh' );
            } else {
                // Create a message.
                $this->messageci->set( lang('error_create_discussion'), 'error');

                // Redirect.
                redirect( site_url(), 'refresh');
            }

        }
    }

    public function report_discussion ( $discussion_id = NULL )
    {
        // Check a discussion ID was supplied.
        if ( empty($discussion_id) || $discussion_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        /* TODO */
    }

    public function edit_discussion ( $discussion_id = NULL )
    {
        // Check a discussion ID was supplied.
        if ( empty($discussion_id) || $discussion_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        /* TODO */

    }

    public function delete_discussion ( $discussion_id = NULL )
    {
        // Check a discussion ID was supplied.
        if ( empty($discussion_id) || $discussion_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        if($this->forums->delete_discussion($discussion_id) === TRUE)
        {

        } else {

        }
    }

}