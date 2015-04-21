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
    );

    public function view($category_slug, $discussion_slug)
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['new_comment']);

        // See if the form has been run.
        if( $this->form_validation->run() === FALSE )
        {
            // Get the discussion info.
            $discussion = $this->discussions->get_singleton($discussion_slug);

            // Update the discussion view count.
            $this->discussions->update(array('view_count' => ++$discussion[0]->view_count), $discussion[0]->discussion_id);

            // Setup the Pagination.
            $config['base_url'] = site_url('discussions/'.$category_slug.'/'.$discussion_slug.'');
            $config['total_rows'] = count( $this->comments->get_comments( $discussion[0]->discussion_id ) );
            $config['per_page'] = $this->config->item('comments_per_page');
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $this->pagination->initialize($config);

            // Get the comments.
            $comments = $this->comments->get_comments($discussion[0]->discussion_id, $config['per_page'], $page);

            // Define the page title.
            $data['title'] = ucwords($discussion[0]->discussion_name);

            // Define the page template.
            $data['template'] = 'pages/discussions/view';

            if( is_array( $comments ) )
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
                        'report_button' => anchor( site_url('comments/report/'.$row->comment_id.''), '<i class="fa fa-bullhorn"></i> Report', array('class' => 'btn btn-default btn-sm pull-right', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Report this comment to a moderator.')),
                        'pm_button' => anchor( site_url('users/pm/'.$row->user_id.''), '<i class="fa fa-envelope-o"></i> PM', array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Send this user a personal message.')),
                        'thumbs_up_button' => anchor( site_url('users/thumbs_up/'.$row->user_id.''), '<i class="fa fa-thumbs-o-up"></i>', array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Give this user a Thumbs Up.' )),
                    );

                    $has_comments = 1;
                }

            }
            else
            {
                $data['comments'] = '';

                $has_comments = 0;
            }

            // Build the discussion starters avatar.
            $data['avatar'] = array(
                'src' => $this->gravatar->get_gravatar($discussion[0]->email, $this->config->item('gravatar_rating'), $this->config->item('gravatar_size'), $this->config->item('gravatar_default_image') ),
                'class' => 'media-object'
            );

            // Build the page breadcrumbs.
            $this->crumbs->add($discussion[0]->category_name, 'categories/'.$category_slug.'');
            $this->crumbs->add($discussion[0]->discussion_name, 'discussions/'.$category_slug.'/'.$discussion_slug.'');

            // Build the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'/#quick_reply') ),
                'form_close' => form_close(),
                // Fields.
                'comment_field' => form_textarea( $this->form_fields['new_comment'][0], set_value( $this->form_fields['new_comment'][0]['name'], $this->input->post('comment') ) ),
                // Hidden Fields.
                'discussion_id_field_hidden' => form_hidden('discussion_id', $discussion[0]->discussion_id),
                // Errors.
                'comment_error' => form_error($this->form_fields['new_comment'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'post_comment_button' => form_submit('submit', lang('btn_post_comment'), 'class="btn btn-primary btn-sm"'),
                'report_button' => anchor( site_url('discussions/report/'.$discussion[0]->discussion_id.''), lang('btn_report'), array('class' => 'btn btn-default btn-sm pull-right', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Report this discussion to a moderator.')),
                'pm_button' => anchor( site_url('users/pm/'.$discussion[0]->insert_user_id.''), lang('btn_send_pm'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Send this user a private message.')),
                'thumbs_up_button' => anchor( site_url('users/thumbs_up/'.$discussion[0]->insert_user_id.''), lang('btn_thumbs_up'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Give this user a Thumbs Up.')),
                'new_discussion_button' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
                'reply_button' => anchor( site_url( 'discussions/reply/'.$category_slug.'/'.$discussion_slug.'' ), lang('btn_reply_discussion'), array( 'class' => 'btn btn-primary btn-sm' ) ),
                // Discussion Data.
                'comment_id' => '#0',
                'comment_id_link' => anchor( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'/#0'), '#0'),
                'discussion_name' => $discussion[0]->discussion_name,
                'created_by' => anchor( site_url('users/profile/'.$discussion[0]->user_id), ucwords( $discussion[0]->username ) ),
                'body' => nl2br($discussion[0]->body),
                'avatar' => img( element('avatar', $data ) ),
                'created_date' => date('jS M Y - h:i:s A', strtotime( $discussion[0]->insert_date )),
                // Comment Data.
                'comments' => element( 'comments', $data ),
                'has_comments' => $has_comments,
                'breadcrumbs' => $this->crumbs->output(),
                'login_link' => anchor( site_url('users/login'), 'Login'),
                // Other.
                'pagination' => $this->pagination->create_links(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else {
            // Set the timezone.
            date_default_timezone_set($this->config->item('default_timezone'));

            // Get the discussion from the database.
            $discussion = $this->discussions->get_singleton($discussion_slug);

            // Get the category info from the database.
            $category = $this->categories->get_singleton($category_slug);

            // Form has been submitted, sanitie the data.
            $comment = strip_tags($this->security->xss_clean($this->input->post('comment')));

            // Build the data to insert into the database.
            $data = array(
                'discussion_id' => $this->input->post('discussion_id'),
                'insert_user_id' => $this->session->userdata('user_id'),
                'body' => $comment,
                'insert_date' => date('Y-m-d G:i:s', time()),
                'insert_ip' => $this->input->ip_address(),
            );

            // Insert into the comments table.
            $this->comments->insert($data);

            $comment_id = $this->db->insert_id();

            // Build the data for the discussions table.
            $data = array(
                'last_comment_id' => $comment_id,
                'last_comment_user_id' => $this->session->userdata('user_id'),
                'comment_count' => ++$discussion[0]->comment_count,
                'last_comment_date' => date('Y-m-d H:i:s', time()),
            );

            // Update the discussions table.
            $this->discussions->update($data, $discussion[0]->discussion_id);

            // Build the data for the categories table.
            $data = array(
                'comment_count' => ++$category[0]->comment_count,
                'last_comment_id' => $comment_id,
                'last_comment_date' => date('Y-m-d G:i:s', time()),
            );

            // Update the categories table.
            if ($this->categories->update($data, $category[0]->category_id) === TRUE) {

                // Create a message.
                $this->messageci->set(lang('success_creating_comment'), 'success');

                // Redirect.
                redirect(site_url('discussions/' . $category_slug . '/' . $discussion_slug . ''));
            } else {
                // Create a message.
                $this->messageci->set(lang('error_creating_comment'), 'error');

                // Redirect.
                redirect(site_url('discussions/' . $category_slug . '/' . $discussion_slug . ''));
            }

        }

    }

}