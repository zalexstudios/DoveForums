<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    private $validation_rules = array(
        'add_user' => array(
            //0
            array(
                'field' => 'username',
                'rules' => 'required',
                'label' => 'lang:rules_username',
            ),
            //1
            array(
                'field' => 'email',
                'rules' => 'required|valid_email',
                'label' => 'lang:rules_email',
            ),
            //2
            array(
                'field' => 'password',
                'rules' => 'required',
                'label' => 'lang:rules_password',
            ),
        ),
        'edit_user' => array(
            //0
            array(
                'field' => 'username',
                'rules' => 'required',
                'label' => 'lang:rules_username',
            ),
            //1
            array(
                'field' => 'email',
                'rules' => 'required|valid_email',
                'label' => 'lang:rules_email',
            ),
        ),
    );

    private $form_fields = array(
        'add_user' => array(
            //0
            array(
                'id' => 'username',
                'name' => 'username',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'email',
                'name' => 'email',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //2
            array(
                'id' => 'password',
                'name' => 'password',
                'class' => 'form-control',
                'type' => 'password',
            ),
            //3
            array(
                'id' => 'first_name',
                'name' => 'first_name',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //4
            array(
                'id' => 'last_name',
                'name' => 'last_name',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
        'edit_user' => array(
            //0
            array(
                'id' => 'username',
                'name' => 'username',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'email',
                'name' => 'email',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //2
            array(
                'id' => 'first_name',
                'name' => 'first_name',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //3
            array(
                'id' => 'last_name',
                'name' => 'last_name',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
    );

    public function index()
    {
        // Define the page title.
        $data['title'] = 'Dashboard';

        // Define the page template.
        $data['template'] = 'pages/dashboard/dashboard';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard');

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    /*****************************************************************************************
     * User Functions
     *****************************************************************************************/

    public function all_users()
    {
        // Define the page title.
        $data['title'] = 'All Users';

        // Define the page template.
        $data['template'] = 'pages/dashboard/users';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard', 'dashboard');
        $this->crumbs->add('All Users');

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            lang('tbl_username'),
            lang('tbl_first_name'),
            lang('tbl_last_name'),
            lang('tbl_status'),
            lang('tbl_action')
        );

        // Get all the users from the database.
        $users = $this->ion_auth->users()->result();

        // Check users exist.
        if (!empty($users))
        {
            // Loop though all the users and add them to a table.
            foreach($users as $row)
            {
                $this->table->add_row(
                    $row->username,
                    $row->first_name,
                    $row->last_name,
                    ($row->active == 1) ? anchor( site_url('dashboard/deactivate_user/'.$row->id), '<span class="text-success">Active</span>') : anchor( site_url('dashboard/activate_user/'.$row->id), '<span class="text-danger">Inactive</span>'),
                    ''.anchor( site_url('dashboard/edit_user/'.$row->id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    anchor( site_url('dashboard/delete_user/'.$row->id), lang('btn_delete'), array('class' => 'btn btn-danger btn-xs'))
                );
            }
        }

        // Define the page data.
        $data['page'] = array(
            // Table.
            'users_table' => $this->table->generate(),
            // Buttons.
            'btn_add_user' => anchor( site_url('dashboard/add_user'), lang('btn_add_user'), array('class' => 'btn btn-success btn-sm')),
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function add_user()
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['add_user']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = 'Add User';

            // Define the page template.
            $data['template'] = 'pages/dashboard/add_user';

            // Build the breadcrumbs.
            $this->crumbs->add('Dashboard', 'dashboard');
            $this->crumbs->add('Add User');

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('dashboard/add_user') ),
                'form_close' => form_close(),
                // Fields
                'username_field' => form_input( $this->form_fields['add_user'][0], set_value( $this->form_fields['add_user'][0]['name'], $this->input->post('username') ) ),
                'email_field' => form_input( $this->form_fields['add_user'][1], set_value( $this->form_fields['add_user'][1]['name'], $this->input->post('email') ) ),
                'password_field' => form_input( $this->form_fields['add_user'][2] ),
                'first_name_field' => form_input( $this->form_fields['add_user'][3], set_value( $this->form_fields['add_user'][3]['name'], $this->input->post('first_name') ) ),
                'last_name_field' => form_input( $this->form_fields['add_user'][4], set_value( $this->form_fields['add_user'][4]['name'], $this->input->post('last_name') ) ),
                // Errors.
                'username_error' => form_error($this->form_fields['add_user'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'email_error' => form_error($this->form_fields['add_user'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'password_error' => form_error($this->form_fields['add_user'][2]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'username_label' => form_label('Username:', $this->form_fields['add_user'][0]['id']),
                'email_label' => form_label('Email:', $this->form_fields['add_user'][1]['id']),
                'password_label' => form_label('Password:', $this->form_fields['add_user'][2]['id']),
                'first_name_label' => form_label('First Name:', $this->form_fields['add_user'][3]['id']),
                'last_name_label' => form_label('Last Name:', $this->form_fields['add_user'][4]['id']),
                // Buttons.
                'btn_add_user' => form_submit('submit', lang('btn_add_user'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        } else {

            $username = $this->input->post('username');
            $email = strtolower($this->input->post('email'));
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
            );

            if( $this->ion_auth->register($username, $password, $email, $additional_data) )
            {
                // Create a message.
                $this->messageci->set( lang('success_add_user'), 'success');

                // Redirect.
                redirect( site_url('dashboard/all_users'), 'refresh');
            } else {
                // Create a message.
                $this->messageci->set( lang('error_add_user'), 'error');

                // Redirect.
                redirect( site_url('dashboard/all_users'), 'refresh');
            }

        }
    }

    public function edit_user($user_id)
    {
        if(empty($user_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['edit_user']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {

            // Define the page title.
            $data['title'] = 'Edit User';

            // Define the page template.
            $data['template'] = 'pages/dashboard/edit_user';

            // Build the breadcrumbs.
            $this->crumbs->add('Dashboard', 'dashboard');
            $this->crumbs->add('Edit User');

            // Get the user from the database.
            $user = $this->ion_auth->user($user_id)->row();

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('dashboard/edit_user/'.$user_id) ),
                'form_close' => form_close(),
                // Fields
                'username_field' => form_input( $this->form_fields['edit_user'][0], set_value( $this->form_fields['edit_user'][0]['name'], $user->username ) ),
                'email_field' => form_input( $this->form_fields['edit_user'][1], set_value( $this->form_fields['edit_user'][1]['name'], $user->email ) ),
                'first_name_field' => form_input( $this->form_fields['edit_user'][2], set_value( $this->form_fields['edit_user'][2]['name'], $user->first_name ) ),
                'last_name_field' => form_input( $this->form_fields['edit_user'][3], set_value( $this->form_fields['edit_user'][3]['name'], $user->last_name ) ),
                // Errors.
                'username_error' => form_error($this->form_fields['edit_user'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'email_error' => form_error($this->form_fields['edit_user'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'username_label' => form_label('Username:', $this->form_fields['edit_user'][0]['id']),
                'email_label' => form_label('Email:', $this->form_fields['edit_user'][1]['id']),
                'first_name_label' => form_label('First Name:', $this->form_fields['edit_user'][2]['id']),
                'last_name_label' => form_label('Last Name:', $this->form_fields['edit_user'][3]['id']),
                // Buttons.
                'btn_add_user' => form_submit('submit', lang('btn_update_user'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
            );

            if ($this->ion_auth->update($user_id, $data))
            {
                // Create a message.
                $this->messageci->set( sprintf( lang('success_update_user'), $this->input->post('username') ), 'success');

                // Redirect.
                redirect( site_url('dashboard/all_users'), 'refresh');
            } else {
                // Create a message.
                $this->messageci->set( sprintf( lang('error_update_user'), $this->input->post('username') ), 'error');

                // Redirect.
                redirect( site_url('dashboard/all_users'), 'refresh');
            }
        }

    }

    public function delete_user($user_id)
    {
        if(empty($user_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        // Get the user.
        $user = $this->ion_auth->user($user_id)->row();

        if ($this->ion_auth->delete_user($user_id) === TRUE)
        {
            // Create a message.
            $this->messageci->set( sprintf( lang('success_delete_user'), $user->username), 'success');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh' );
        } else {
            // Create a message.
            $this->messageci->set( sprintf( lang('error_delete_user'), $user->username), 'error');

            // Redirect.
            redirect( $this->agent->referrer() );
        }
    }

    /**
     * Activate User
     *
     * Activates the supplied user.
     *
     * @param       int     $user_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function activate_user($user_id)
    {
        if(empty($user_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        $activation = $this->ion_auth->activate($user_id);

        if($activation)
        {
            // Create a message.
            $this->messageci->set( lang('success_user_activation'), 'success');

            // Redirect.
            redirect($this->agent->referrer());
        } else {
            // Create a message.
            $this->messageci->set( lang('error_user_activation'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }
    }

    /**
     * Deactivate User
     *
     * Deactivates the supplied user.
     *
     * @param       int     $user_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function deactivate_user($user_id)
    {
        if(empty($user_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        $deactivate = $this->ion_auth->deactivate($user_id);

        if($deactivate)
        {
            // Create a message.
            $this->messageci->set( lang('success_user_deactivation'), 'success');

            // Redirect
            redirect($this->agent->referrer());
        } else {
            // Create a message.
            $this->messageci->set( lang('error_user_deactivation'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }
    }

    /*****************************************************************************************
     * Categories Functions
     *****************************************************************************************/

    public function all_categories()
    {
        // Define the page title.
        $data['title'] = 'All Categories';

        // Define the page template.
        $data['template'] = 'pages/dashboard/all_categories';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard', 'dashboard');
        $this->crumbs->add('All Categories');

        /* TODO - Build the all categories page. */

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function add_category()
    {
        // Define the page title.
        $data['title'] = 'Add Category';

        // Define the page template.
        $data['template'] = 'pages/dashboard/add_category';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard', 'dashboard');
        $this->crumbs->add('Add Category');

        /* TODO - Build the add categories page. */

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function edit_category($category_id)
    {
        if(empty($category_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        // Define the page title.
        $data['title'] = 'Edit Category';

        // Define the page template.
        $data['template'] = 'pages/dashboard/edit_category';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard', 'dashboard');
        $this->crumbs->add('Edit Category');

        /* TODO - Build the edit categories page. */

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function delete_category($category_id)
    {
        if(empty($category_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        /* TODO */
    }

    /*****************************************************************************************
     * Discussion Functions
     *****************************************************************************************/

    public function all_discussions()
    {
        // Define the page title.
        $data['title'] = 'All Discussions';

        // Define the page template.
        $data['template'] = 'pages/dashboard/all_discussions';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard', 'dashboard');
        $this->crumbs->add('All Discussions');

        /* TODO - Build the all discussions page. */

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function edit_discussion($discussion_id)
    {
        if(empty($discussion_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        // Define the page title.
        $data['title'] = 'Edit Discussion';

        // Define the page template.
        $data['template'] = 'pages/dashboard/edit_discussion';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard', 'dashboard');
        $this->crumbs->add('Edit Discussion');

        /* TODO - Build the edit discussion page. */

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function delete_discussion($discussion_id)
    {
        if(empty($discussion_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        /* TODO */
    }

    /*****************************************************************************************
     * Comment Functions
     *****************************************************************************************/

    /*****************************************************************************************
     * Settings Functions
     *****************************************************************************************/


}