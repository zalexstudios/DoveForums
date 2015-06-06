<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends Front_Controller {

    private $validation_rules = array(
        'edit_comment' => array(
            //0
            array(
                'field' => 'comment',
                'rules' => 'required',
                'label' => 'lang:rules_comment',
            ),
        ),
        'report_comment' => array(
            //0
            array(
                'field' => 'reason',
                'rules' => 'required',
                'label' => 'lang:rules_reason',
            ),
        ),
    );

    private $form_fields = array(
        'edit_comment' => array(
            //0
            array(
                'id' => 'comment',
                'name' => 'comment',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
    );

    public function edit_comment( $comment_id )
    {
        // Check if the user has permission.
        if(!$this->permission->has_permission('edit_comments'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Check a comment ID was supplied.
        if ( empty($comment_id) || $comment_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['edit_comment']);

        // See if the form has been run.
        if( $this->form_validation->run() === FALSE )
        {
            // Define the page title.
            $data['title'] = lang('tle_edit_comment');

            // Define the page template.
            $data['template'] = 'pages/comments/edit';

            // Build the page breadcrumbs.
            $this->crumbs->add(lang('crumb_edit_comment'));

            // Get the comment from the database.
            $comment = $this->forums->get_comment_by_id($comment_id);

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open('comments/edit_comment/'.$comment_id),
                'form_close' => form_close(),
                // Fields.
                'comment_field' => form_textarea( $this->form_fields['edit_comment'][0], set_value( $this->form_fields['edit_comment'][0]['name'], $comment->body ) ),
                // Errors
                'comment_error' => form_error($this->form_fields['edit_comment'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons
                'btn_update_comment' => form_submit('submit', lang('btn_update_comment'), 'class="btn btn-primary btn-sm"'),
                // Hidden.
                'comment_id_hidden_field' => form_hidden('comment_id', $comment_id),
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
                'body' => $this->input->post('comment'),
            );

            if ($this->forums->update_comment($this->input->post('comment_id'), $data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( lang('success_update_comment'), 'success');

                // Redirect.
                redirect( site_url(), 'refresh' );
            } else {
                // Create a message.
                $this->messageci->set( lang('error_update_comment'), 'error');

                // Redirect.
                redirect( site_url(), 'refresh');
            }
        }
    }

    /**
     * Delete Comment
     *
     * @param       integer     $comment_id
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_comment( $comment_id = NULL )
    {
        // Check if the user has permission.
        if(!$this->permission->has_permission('edit_comments'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Check a comment ID was supplied.
        if ( empty($comment_id) || $comment_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        if($this->forums->delete_comment($comment_id))
        {
            // Create a message.
            $this->messageci->set( lang('success_delete_comment'), 'success');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');

        } else {
            // Create a message.
            $this->messageci->set( lang('error_delete_comment'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }
    }

    public function report_comment($comment_id = NULL)
    {
        // Check if the user has permission.
        if(!$this->permission->has_permission('report_comments'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Check a comment ID was supplied.
        if ( empty($comment_id) || $comment_id === NULL )
        {
            // Create a message.
            $this->messageci->set ( lang('error_invalid_id'), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['report_comment']);

        // See if the form has been run.
        if($this->form_validation->run() === FALSE) {

            // Define the page title.
            $data['title'] = lang('tle_report_comment');

            // Define the page template.
            $data['template'] = 'pages/comments/report';

            // Build the page breadcrumbs.
            $this->crumbs->add(lang('crumb_report_comment'));

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
                'form_open' => form_open('comments/report_comment/' . $comment_id),
                'form_close' => form_close(),
                // Fields.
                'report_field' => form_dropdown('reason', $reason, '0', 'class="form-control"'),
                // Errors
                'report_error' => form_error('reason', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i>', '</p>'),
                // Hidden
                'comment_id_hidden_field' => form_hidden('comment_id', $comment_id),
                // Buttons
                'btn_report_comment' => form_submit('submit', lang('btn_report_comment'), 'class="btn btn-primary btn-sm"'),
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

            if ($this->forums->report_comment($this->input->post('comment_id'), $data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( lang('success_report_comment'),  'success');

                // Redirect.
                redirect( site_url(), 'refresh' );
            } else {
                // Create a message.
                $this->messageci->set( lang('error_report_comment'),  'error');

                // Redirect.
                redirect( site_url(), 'refresh');
            }
        }
    }
}
