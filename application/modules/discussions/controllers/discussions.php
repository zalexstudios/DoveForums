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
                'placeholder' => 'Enter comment.',
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

            // Get the comments.
            $comments = $this->comments->get_comments($discussion[0]->discussion_id);

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

                    $data['comments'] = array(
                        array(
                            'created_by' => anchor( site_url('users/profile/'.$row->user_id.''), $row->username),
                            'body' => nl2br($row->body),
                            'avatar' => img( element('avatar', $data) ),
                            'created_date' => date('jS M Y - h:i:s A', strtotime( $row->insert_date ) ),
                        ),
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
                'class' => 'media-object',
            );

            // Build the page breadcrumbs.
            $this->crumbs->add($discussion[0]->category_name, 'categories/'.$category_slug.'');
            $this->crumbs->add($discussion[0]->discussion_name, 'discussions/'.$category_slug.'/'.$discussion_slug.'');

            // Build the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('discussions/'.$category_slug.'/'.$discussion_slug.'') ),
                'form_close' => form_close(),
                // Fields.
                'comment_field' => form_textarea( $this->form_fields['new_comment'][0], set_value( $this->form_fields['new_comment'][0]['name'], $this->input->post('comment') ) ),
                // Hidden Fields.
                'discussion_id_field_hidden' => form_hidden('discussion_id', $discussion[0]->discussion_id),
                // Buttons.
                'post_comment_button' => form_submit('submit', 'Post Comment', 'class="btn btn-primary"'),
                // Discussion Data.
                'discussion_name' => $discussion[0]->discussion_name,
                'category_name' => anchor( site_url('categories/'.$discussion[0]->category_slug), $discussion[0]->category_name ),
                'created_by' => anchor( site_url('users/profile/'.$discussion[0]->user_id), $discussion[0]->username ),
                'body' => nl2br($discussion[0]->body),
                'avatar' => img( element('avatar', $data ) ),
                'date_created' => date('jS M Y - h:i:s A', strtotime( $discussion[0]->insert_date )),
                // Comment Data.
                'comments' => element( 'comments', $data ),
                'has_comments' => $has_comments,
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {

        }


    }
}