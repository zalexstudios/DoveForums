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
        'add_category' => array(
            //0
            array(
                'field' => 'name',
                'rules' => 'required',
                'label' => 'lang:rules_name',
            ),
            //1
            array(
                'field' => 'description',
                'rules' => 'required',
                'label' => 'lang:rules_description',
            ),
        ),
        'edit_category' => array(
            //0
            array(
                'field' => 'name',
                'rules' => 'required',
                'label' => 'lang:rules_name',
            ),
            //1
            array(
                'field' => 'description',
                'rules' => 'required',
                'label' => 'lang:rules_description',
            ),
            //2
            array(
                'field' => 'slug',
                'rules' => 'required',
                'label' => 'lang:rules_slug',
            ),
        ),
        'add_edit_group' => array(
            //0
            array(
                'field' => 'name',
                'rules' => 'required',
                'label' => 'lang:rules_name',
            ),
            //1
            array(
                'field' => 'description',
                'rules' => 'required',
                'label' => 'lang:rules_description',
            ),
        ),
        'settings' => array(
            //0
            array(
                'field' => 'site_name',
                'rules' => 'required',
                'label' => 'lang:rules_site_name',
            ),
            //1
            array(
                'field' => 'site_email',
                'rules' => 'required|valid_email',
                'label' => 'lang:rules_site_email',
            ),
            //2
            array(
                'field' => 'site_keywords',
                'rules' => 'required',
                'label' => 'lang:rules_site_keywords',
            ),
            //3
            array(
                'field' => 'site_description',
                'rules' => 'required',
                'label' => 'lang:rules_site_description',
            ),
        ),
        'add_edit_language' => array(
            //0
            array(
                'field' => 'language',
                'rules' => 'required',
                'label' => 'lang:rules_language',
            ),
            //1
            array(
                'field' => 'code',
                'rules' => 'required',
                'label' => 'lang:rules_code',
            ),
            //2
            array(
                'field' => 'icon',
                'rules' => 'required',
                'label' => 'lang:rules_icon',
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
                'type' => 'email',
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
                'type' => 'email',
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
        'add_category' => array(
            //0
            array(
                'id' => 'name',
                'name' => 'name',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'description',
                'name' => 'description',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
        'edit_category' => array(
            //0
            array(
                'id' => 'name',
                'name' => 'name',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'description',
                'name' => 'description',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //2
            array(
                'id' => 'slug',
                'name' => 'slug',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
        'add_edit_group' => array(
            //0
            array(
                'id' => 'name',
                'name' => 'name',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'description',
                'name' => 'description',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
        'settings' => array(
            //0
            array(
                'id' => 'site_name',
                'name' => 'site_name',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'site_email',
                'name' => 'site_email',
                'class' => 'form-control',
                'type' => 'email',
            ),
            //2
            array(
                'id' => 'site_keywords',
                'name' => 'site_keywords',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //3
            array(
                'id' => 'site_description',
                'name' => 'site_description',
                'class' => 'textarea',
                'type' => 'text',
                'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;',
            ),
        ),
        'add_edit_language' => array(
            //0
            array(
                'id' => 'language',
                'name' => 'language',
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'English'
            ),
            //1
            array(
                'id' => 'code',
                'name' => 'code',
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'english',
            ),
            //2
            array(
                'id' => 'icon',
                'name' => 'icon',
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'gb.png',
            ),
        ),
    );

    public function index()
    {
        // Define the page title.
        $data['title'] = lang('tle_dashboard');

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

    /**
     * All Users
     *
     * Lists all the users in the database.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function all_users()
    {
        // Define the page title.
        $data['title'] = lang('tle_users');

        // Define the page template.
        $data['template'] = 'pages/dashboard/users';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_users'));

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
                    ($row->active == 1) ? anchor( site_url('dashboard/deactivate_user/'.$row->id), lang('txt_active') ) : anchor( site_url('dashboard/activate_user/'.$row->id), lang('txt_inactive') ),
                    ''.anchor( site_url('dashboard/edit_user/'.$row->id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    ''.anchor( site_url('dashboard/view_user/'.$row->id), lang('btn_view'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
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

    /**
     * Add User
     *
     * Add a new user to the database.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function add_user()
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['add_user']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_add');

            // Define the page template.
            $data['template'] = 'pages/dashboard/add_user';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_add'));

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
                'username_label' => form_label( lang('lbl_username'), $this->form_fields['add_user'][0]['id']),
                'email_label' => form_label( lang('lbl_email'), $this->form_fields['add_user'][1]['id']),
                'password_label' => form_label( lang('lbl_password'), $this->form_fields['add_user'][2]['id']),
                'first_name_label' => form_label( lang('lbl_first_name'), $this->form_fields['add_user'][3]['id']),
                'last_name_label' => form_label( lang('lbl_last_name'), $this->form_fields['add_user'][4]['id']),
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
                $this->messageci->set( sprintf(lang('success_add_user'), $this->input->post('username')), 'success');

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

    /**
     * Edit User
     *
     * Edit the supplied user.
     *
     * @param       integer      $user_id
     * @author      Chris Baines
     * @since       0.0.1
     */
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
            $data['title'] = lang('tle_edit');

            // Define the page template.
            $data['template'] = 'pages/dashboard/edit_user';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_edit'));

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
                'username_label' => form_label( lang('lbl_username'), $this->form_fields['edit_user'][0]['id']),
                'email_label' => form_label( lang('lbl_email'), $this->form_fields['edit_user'][1]['id']),
                'first_name_label' => form_label( lang('lbl_first_name'), $this->form_fields['edit_user'][2]['id']),
                'last_name_label' => form_label( lang('lbl_last_name'), $this->form_fields['edit_user'][3]['id']),
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

    /**
     * Delete User
     *
     * Deletes the specified user from the database
     * including all related discussions and comments.
     *
     * @param       integer      $user_id
     * @author      Chris Baines
     * @since       0.0.1
     *
     */
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
            // Delete any discussions created by the user.
            $this->forums->delete_discussions($user_id);

            // Delete any comments created by the user.
            $this->forums->delete_comments($user_id);

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
     * @param       integer     $user_id
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
     * @param       integer     $user_id
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
     * Group Functions
     *****************************************************************************************/

    public function all_groups()
    {
        // Define the page title.
        $data['title'] = lang('tle_groups');

        // Define the page template.
        $data['template'] = 'pages/dashboard/groups';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_groups'));

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            lang('tbl_name'),
            lang('tbl_description'),
            lang('tbl_action')
        );

        // Get all the categories.
        $groups = $this->ion_auth->groups()->result();

        if (!empty($groups))
        {
            foreach($groups as $row)
            {
                $this->table->add_row(
                    $row->name,
                    $row->description,
                    ''.anchor( site_url('dashboard/edit_group/'.$row->id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    ''.anchor( site_url('dashboard/view_group/'.$row->id), lang('btn_view'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    anchor( site_url('dashboard/delete_group/'.$row->id), lang('btn_delete'), array('class' => 'btn btn-danger btn-xs'))
                );
            }
        }

        // Define the page data.
        $data['page'] = array(
            // Table.
            'tbl_groups' => $this->table->generate(),
            // Buttons.
            'btn_add_group' => anchor( site_url('dashboard/add_group'), lang('btn_add_group'), array('class' => 'btn btn-success btn-sm')),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function add_group()
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['add_edit_group']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_add');

            // Define the page template.
            $data['template'] = 'pages/dashboard/add_edit_group';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_add'));

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('dashboard/add_group') ),
                'form_close' => form_close(),
                // Fields
                'name_field' => form_input( $this->form_fields['add_edit_group'][0], set_value( $this->form_fields['add_edit_group'][0]['name'], $this->input->post('name') ) ),
                'description_field' => form_input( $this->form_fields['add_edit_group'][1], set_value( $this->form_fields['add_edit_group'][1]['name'], $this->input->post('description') ) ),
                // Errors.
                'name_error' => form_error($this->form_fields['add_edit_group'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'description_error' => form_error($this->form_fields['add_edit_group'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'name_label' => form_label( lang('lbl_name'), $this->form_fields['add_edit_group'][0]['id']),
                'description_label' => form_label( lang('lbl_description'), $this->form_fields['add_edit_group'][1]['id']),
                // Buttons.
                'btn_add_edit_group' => form_submit('submit', lang('btn_add_group'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
                'action' => 'add',
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            if ($this->ion_auth->create_group($this->input->post('name'), $this->input->post('description')))
            {
                // Create a message.
                $this->messageci->set( $this->ion_auth->messages(), 'success');

                // Redirect.
                redirect( site_url('dashboard/all_groups'), 'refresh');
            } else {
                // Create a message.
                $this->messageci->set( $this->ion_auth->errors(), 'error');

                // Redirect.
                redirect( site_url('dashboard/all_groups'), 'refresh');
            }
        }
    }

    public function edit_group($group_id)
    {

        if(empty($group_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['add_edit_group']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_edit');

            // Define the page template.
            $data['template'] = 'pages/dashboard/add_edit_group';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_edit'));

            // Get the group.
            $group = $this->ion_auth->group($group_id)->row();

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('dashboard/edit_group/'.$group_id) ),
                'form_close' => form_close(),
                // Fields
                'name_field' => form_input( $this->form_fields['add_edit_group'][0], set_value( $this->form_fields['add_edit_group'][0]['name'], $group->name ) ),
                'description_field' => form_input( $this->form_fields['add_edit_group'][1], set_value( $this->form_fields['add_edit_group'][1]['name'], $group->description ) ),
                // Errors.
                'name_error' => form_error($this->form_fields['add_edit_group'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'description_error' => form_error($this->form_fields['add_edit_group'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'name_label' => form_label( lang('lbl_name'), $this->form_fields['add_edit_group'][0]['id']),
                'description_label' => form_label( lang('lbl_description'), $this->form_fields['add_edit_group'][1]['id']),
                // Buttons.
                'btn_add_edit_group' => form_submit('submit', lang('btn_edit_group'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            if ($this->ion_auth->update_group($group_id, $this->input->post('name'), $this->input->post('description')))
            {
                // Create a message.
                $this->messageci->set( $this->ion_auth->messages(), 'success');

                // Redirect.
                redirect( site_url('dashboard/all_groups'), 'refresh');
            } else {
                // Create a message.
                $this->messageci->set( $this->ion_auth->errors(), 'error');

                // Redirect.
                redirect( site_url('dashboard/all_groups'), 'refresh');
            }
        }

    }

    public function delete_group($group_id)
    {

        if(empty($group_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        if($this->ion_auth->delete_group($group_id))
        {
            // Create a message.
            $this->messageci->set( $this->ion_auth->messages(), 'success');

            // Redirect.
            redirect( site_url('dashboard/all_groups'), 'refresh');
        } else {
            // Create a message.
            $this->messageci->set( $this->ion_auth->errors(), 'error');

            // Redirect.
            redirect( site_url('dashboard/all_groups'), 'refresh');
        }

    }

    /*****************************************************************************************
     * Categories Functions
     *****************************************************************************************/

    /**
     * All Categories
     *
     * Lists all the categories in the database.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function all_categories()
    {
        // Define the page title.
        $data['title'] = lang('tle_categories');

        // Define the page template.
        $data['template'] = 'pages/dashboard/categories';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_categories'));

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            lang('tbl_name'),
            lang('tbl_slug'),
            lang('tbl_description'),
            lang('tbl_discussion_count'),
            lang('tbl_comment_count'),
            lang('tbl_action')
        );

        // Get all the categories.
        $categories = $this->forums->get_categories_admin();

        if (!empty($categories))
        {
            foreach($categories as $row)
            {
                $this->table->add_row(
                    $row->name,
                    $row->slug,
                    $row->description,
                    $row->discussion_count,
                    $row->comment_count,
                    ''.anchor( site_url('dashboard/edit_category/'.$row->category_id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    ''.anchor( site_url('dashboard/view_category/'.$row->category_id), lang('btn_view'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    anchor( site_url('dashboard/delete_category/'.$row->category_id), lang('btn_delete'), array('class' => 'btn btn-danger btn-xs'))
                );
            }
        }

        // Define the page data.
        $data['page'] = array(
            // Table.
            'categories_table' => $this->table->generate(),
            // Buttons.
            'btn_add_category' => anchor( site_url('dashboard/add_category'), lang('btn_add_category'), array('class' => 'btn btn-success btn-sm')),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    /**
     * Add Category
     *
     * Add a new category to the database.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function add_category()
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['add_category']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_add');

            // Define the page template.
            $data['template'] = 'pages/dashboard/add_category';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_add'));

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('dashboard/add_category') ),
                'form_close' => form_close(),
                // Fields
                'name_field' => form_input( $this->form_fields['add_category'][0], set_value( $this->form_fields['add_category'][0]['name'], $this->input->post('name') ) ),
                'description_field' => form_input( $this->form_fields['add_category'][1], set_value( $this->form_fields['add_category'][1]['name'], $this->input->post('description') ) ),
                // Errors.
                'name_error' => form_error($this->form_fields['add_category'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'description_error' => form_error($this->form_fields['add_category'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'name_label' => form_label( lang('lbl_name'), $this->form_fields['add_category'][0]['id']),
                'description_label' => form_label( lang('lbl_description'), $this->form_fields['add_category'][1]['id']),
                // Buttons.
                'btn_add_category' => form_submit('submit', lang('btn_add_category'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Gather the data.
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            );

            if ($this->forums->add_category($data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( sprintf(lang('success_add_category'), $this->input->post('name')), 'success');

                // Redirect.
                redirect( site_url('dashboard/all_categories'), 'refresh');
            } else {
                // Create a message.
                $this->messageci->set( lang('error_add_category'), 'error');

                // Redirect.
                redirect( site_url('dashboard/all_categories'), 'refresh');
            }
        }

    }

    /**
     * Edit Category
     *
     * Edit the supplied category.
     *
     * @param       integer     $category_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function edit_category($category_id)
    {
        if(empty($category_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['edit_category']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_edit');

            // Define the page template.
            $data['template'] = 'pages/dashboard/edit_category';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_edit'));

            // Get the category from the database.
            $category = $this->forums->get_category_admin($category_id);

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('dashboard/edit_category/'.$category_id) ),
                'form_close' => form_close(),
                // Fields
                'name_field' => form_input( $this->form_fields['edit_category'][0], set_value( $this->form_fields['edit_category'][0]['name'], $category->name ) ),
                'description_field' => form_input( $this->form_fields['edit_category'][1], set_value( $this->form_fields['edit_category'][1]['name'], $category->description ) ),
                'slug_field' => form_input( $this->form_fields['edit_category'][2], set_value( $this->form_fields['edit_category'][2]['name'], $category->slug ) ),
                // Errors.
                'name_error' => form_error($this->form_fields['edit_category'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'description_error' => form_error($this->form_fields['edit_category'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'slug_error' => form_error($this->form_fields['edit_category'][2]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'name_label' => form_label( lang('lbl_name'), $this->form_fields['edit_category'][0]['id']),
                'description_label' => form_label( lang('lbl_description'), $this->form_fields['edit_category'][1]['id']),
                'slug_label' => form_label( lang('lbl_slug'), $this->form_fields['edit_category'][2]['id']),
                // Hidden.
                'category_id_hidden_field' => form_hidden('category_id', $category->category_id),
                // Buttons.
                'btn_update_category' => form_submit('submit', lang('btn_update_category'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Gather the data.
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'slug' => $this->input->post('slug'),
            );

            if ($this->forums->update_category( $this->input->post('category_id'), $data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( sprintf(lang('success_update_category'), $this->input->post('name')), 'success');

                // Redirect.
                redirect( site_url('dashboard/all_categories'), 'refresh');
            } else {
                // Create a message.
                $this->messageci->set( sprintf(lang('error_update_category'), $this->input->post('name')), 'error');

                // Redirect.
                redirect( site_url('dashboard/all_categories'), 'refresh');
            }

        }
    }

    /**
     * Delete Category
     *
     * Deletes the supplied category.
     *
     * @param       integer     $category_id
     * @author      Chris Baines
     * @since       0.0.1
     *
     */
    public function delete_category($category_id)
    {
        if(empty($category_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        // See if the category is deletable.
        $deletable = $this->forums->get_row( 'deletable', 'category_id', $category_id, $this->tables['categories']);

        if ($deletable == 0)
        {
            // Create a message.
            $this->messageci->set( lang('error_not_deletable'), 'error');

            // Redirect
            redirect( $this->agent->referrer() );
        }

        // Perform the delete.
        if ($this->forums->delete_category($category_id) === TRUE)
        {
            // Create a message.
            $this->messageci->set( lang('success_delete_category'), 'success');

            // Redirect.
            redirect( $this->agent->referrer() );
        } else {
            // Create a message.
            $this->messageci->set( lang('error_delete_category'), 'error');

            // Redirect.
            redirect( $this->agent->referrer() );
        }
    }

    /*****************************************************************************************
     * Discussion Functions
     *****************************************************************************************/

    public function all_discussions()
    {
        // Define the page title.
        $data['title'] = lang('tle_discussions');

        // Define the page template.
        $data['template'] = 'pages/dashboard/discussions';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_discussions'));

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
        $data['title'] = lang('tle_edit');

        // Define the page template.
        $data['template'] = 'pages/dashboard/edit_discussion';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_edit'));

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

    public function settings()
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['settings']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE) {

            // Define the page title.
            $data['title'] = lang('tle_settings');

            // Define the page template.
            $data['template'] = 'pages/dashboard/settings';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_settings'));

            // Build the gravatar rating options.
            $gravatar_rating = array(
                'g' => lang('dd_g'),
                'pg' => lang('dd_pg'),
                'r' => lang('dd_r'),
                'x' => lang('dd_x'),
            );

            // Build the gravatar default image options.
            $gravatar_default_image = array(
                'mm' => lang('dd_mm'),
                'identicon' => lang('dd_identicon'),
                'monsterid' => lang('dd_monsterid'),
                'wavatar' => lang('dd_wavatar'),
                'retro' => lang('dd_retro'),
                'blank' => lang('dd_blank'),
            );

            // Build the gravatar size options.
            $gravatar_size = array(
                '10' => lang('dd_10_10'),
                '20' => lang('dd_20_20'),
                '30' => lang('dd_30_30'),
                '40' => lang('dd_40_40'),
                '50' => lang('dd_50_50'),
                '60' => lang('dd_60_60'),
            );

            // Build the per page options.
            $per_page = array(
                '5' => lang('dd_5'),
                '10' => lang('dd_10'),
                '15' => lang('dd_15'),
                '20' => lang('dd_20'),
                '25' => lang('dd_25'),
                '30' => lang('dd_30'),
                '35' => lang('dd_35'),
                '40' => lang('dd_40'),
                '45' => lang('dd_45'),
                '50' => lang('dd_50'),
            );

            // Build the site language options.
            $languages = $this->forums->get_languages();

            if(!empty($languages))
            {
                foreach($languages as $row)
                {
                    $language_options[$row->code] = $row->language;
                }
            }

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open(site_url('dashboard/settings')),
                'form_close' => form_close(),
                // Fields
                'site_name_field' => form_input($this->form_fields['settings'][0], set_value($this->form_fields['settings'][0]['name'], $this->settings->get_setting('site_name'))),
                'site_email_field' => form_input($this->form_fields['settings'][1], set_value($this->form_fields['settings'][1]['name'], $this->settings->get_setting('site_email'))),
                'site_keywords_field' => form_input($this->form_fields['settings'][2], set_value($this->form_fields['settings'][2]['name'], $this->settings->get_setting('site_keywords'))),
                'site_language_field' => form_dropdown('site_language', $language_options, $this->settings->get_setting('site_language'), 'class="form-control"'),
                'site_description_field' => form_textarea($this->form_fields['settings'][3], set_value($this->form_fields['settings'][3]['name'], $this->settings->get_setting('site_description'))),
                'gravatar_rating_field' => form_dropdown('gravatar_rating', $gravatar_rating, $this->settings->get_setting('gravatar_rating'), 'class="form-control"'),
                'gravatar_default_image_field' => form_dropdown('gravatar_default_image', $gravatar_default_image, $this->settings->get_setting('gravatar_default_image'), 'class="form-control"'),
                'gravatar_size_field' => form_dropdown('gravatar_size', $gravatar_size, $this->settings->get_setting('gravatar_size'), 'class="form-control"'),
                'discussions_per_page_field' => form_dropdown('discussions_per_page', $per_page, $this->settings->get_setting('discussions_per_page'), 'class="form-control"'),
                'comments_per_page_field' => form_dropdown('comments_per_page', $per_page, $this->settings->get_setting('comments_per_page'), 'class="form-control"'),
                // Errors.
                'site_name_error' => form_error($this->form_fields['settings'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'site_email_error' => form_error($this->form_fields['settings'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'site_keywords_error' => form_error($this->form_fields['settings'][2]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'site_description_error' => form_error($this->form_fields['settings'][3]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'site_name_label' => form_label( lang('lbl_site_name'), $this->form_fields['settings'][0]['id']),
                'site_email_label' => form_label( lang('lbl_site_email'), $this->form_fields['settings'][1]['id']),
                'site_keywords_label' => form_label( lang('lbl_site_keywords'), $this->form_fields['settings'][2]['id']),
                'site_language_label' => form_label( lang('lbl_site_language'), 'site_language'),
                'site_description_label' => form_label( lang('lbl_site_description'), $this->form_fields['settings'][3]['id']),
                'gravatar_rating_label' => form_label( lang('lbl_gravatar_rating'), 'gravatar_rating'),
                'gravatar_default_image_label' => form_label( lang('lbl_gravatar_default_image'), 'gravatar_default_image'),
                'gravatar_size_label' => form_label( lang('lbl_gravatar_size'), 'gravatar_size'),
                'discussions_per_page_label' => form_label( lang('lbl_discussions_per_page'), 'discussions_per_page'),
                'comments_per_page_label' => form_label( lang('lbl_comments_per_page'), 'comments_per_page'),
                // Buttons.
                'btn_update_settings' => form_submit('submit', lang('btn_update_settings'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render(element('page', $data), element('title', $data), element('template', $data));

        } else {

            // Gather the data.
            $data = array(
                'site_name' => $this->input->post('site_name'),
                'site_email' => $this->input->post('site_email'),
                'site_keywords' => $this->input->post('site_keywords'),
                'site_language' => $this->input->post('site_language'),
                'site_description' => $this->input->post('site_description'),
                'gravatar_rating' => $this->input->post('gravatar_ratings'),
                'gravatar_default_image' => $this->input->post('gravatar_default_image'),
                'gravatar_size' => $this->input->post('gravatar_size'),
                'discussions_per_page' => $this->input->post('discussions_per_page'),
                'comments_per_page' => $this->input->post('comments_per_page'),
            );

            foreach($data as $k => $v)
            {
                // Update the settings.
                $this->settings->edit_setting($k, $v);
            }

            // Create a message
            $this->messageci->set( lang('success_update_settings'), 'success');

            // Redirect
            redirect( site_url('dashboard/settings'), 'refresh');
        }
    }

    public function language()
    {
        // Define the page title.
        $data['title'] = lang('tle_language_packs');

        // Define the page template.
        $data['template'] = 'pages/dashboard/language_packs';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_language_packs'));

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            lang('tbl_icon'),
            lang('tbl_language'),
            lang('tbl_code'),
            lang('tbl_action')
        );

        // Get all the languages.
        $languages = $this->forums->get_languages();

        if (!empty($languages))
        {
            foreach($languages as $row)
            {
                $this->table->add_row(
                    img('templates/assets/img/flags/'.$row->icon),
                    $row->language,
                    $row->code,
                    ''.anchor( site_url('dashboard/edit_language/'.$row->id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    anchor( site_url('dashboard/delete_language/'.$row->id), lang('btn_delete'), array('class' => 'btn btn-danger btn-xs'))
                );
            }
        }

        // Define the page data.
        $data['page'] = array(
            // Table.
            'tbl_language_packs' => $this->table->generate(),
            // Buttons.
            'btn_add_language' => anchor( site_url('dashboard/add_language'), lang('btn_add_language'), array('class' => 'btn btn-success btn-sm')),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function add_language()
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['add_edit_language']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE) {

            // Define the page title.
            $data['title'] = lang('tle_add');

            // Define the page template.
            $data['template'] = 'pages/dashboard/add_edit_language';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_add'));

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open(site_url('dashboard/add_language')),
                'form_close' => form_close(),
                // Fields
                'language_field' => form_input($this->form_fields['add_edit_language'][0], set_value($this->form_fields['add_edit_language'][0]['name'], $this->input->post('language'))),
                'code_field' => form_input($this->form_fields['add_edit_language'][1], set_value($this->form_fields['add_edit_language'][1]['name'], $this->input->post('code'))),
                'icon_field' => form_input($this->form_fields['add_edit_language'][2], set_value($this->form_fields['add_edit_language'][2]['name'], $this->input->post('icon'))),
                // Errors.
                'language_error' => form_error('language', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'code_error' => form_error('code', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'icon_error' => form_error('icon', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'language_label' => form_label( lang('lbl_language'), $this->form_fields['settings'][0]['id']),
                'code_label' => form_label( lang('lbl_code'), $this->form_fields['settings'][1]['id']),
                'icon_label' => form_label( lang('lbl_icon'), $this->form_fields['settings'][2]['id']),
                // Buttons.
                'btn_add_edit_language' => form_submit('submit', lang('btn_add_language'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render(element('page', $data), element('title', $data), element('template', $data));

        } else {

            // Gather the data.
            $data = array(
                'language' => $this->input->post('language'),
                'code' => strtolower($this->input->post('code')),
                'icon' => $this->input->post('icon'),
            );

            if($this->forums->add_language($data))
            {
                // Create a message
                $this->messageci->set( lang('success_add_language'), 'success');

                // Redirect
                redirect( site_url('dashboard/language'), 'refresh');
            } else {
                // Create a message
                $this->messageci->set( lang('edit_add_language'), 'success');

                // Redirect
                redirect( site_url('dashboard/language'), 'refresh');
            }

        }

    }

    public function edit_language($language_id)
    {

    }

    public function delete_language($language_id)
    {

    }

    public function achievements()
    {
        // Define the page title.
        $data['title'] = lang('tle_achievements');

        // Define the page template.
        $data['template'] = 'pages/dashboard/achievements';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_achievements'));

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            lang('tbl_name'),
            lang('tbl_description'),
            lang('tbl_points'),
            lang('tbl_action')
        );

        // Get all the languages.
        $achievements = $this->achievements->get_achievements();

        if (!empty($achievements))
        {
            foreach($achievements as $row)
            {
                $this->table->add_row(
                    $row->name,
                    $row->description,
                    $row->points,
                    ''.anchor( site_url('dashboard/edit_achievement/'.$row->id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    anchor( site_url('dashboard/delete_achievement/'.$row->id), lang('btn_delete'), array('class' => 'btn btn-danger btn-xs'))
                );
            }
        }

        // Define the page data.
        $data['page'] = array(
            // Table.
            'tbl_achievements' => $this->table->generate(),
            // Buttons.
            'btn_add_achievement' => anchor( site_url('dashboard/add_achievement'), lang('btn_add_achievement'), array('class' => 'btn btn-success btn-sm')),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function achievement_triggers()
    {
        // Define the page title.
        $data['title'] = lang('tle_achievement_triggers');

        // Define the page template.
        $data['template'] = 'pages/dashboard/achievement_triggers';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_achievement_triggers'));

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            lang('tbl_action'),
            lang('tbl_condition'),
            lang('tbl_achievement'),
            lang('tbl_action')
        );

        // Get all the languages.
        $achievement_triggers = $this->achievements->get_all_triggers();

        if (!empty($achievement_triggers))
        {
            foreach($achievement_triggers as $row)
            {
                $this->table->add_row(
                    $row->action,
                    $row->condition,
                    $row->name,
                    ''.anchor( site_url('dashboard/edit_achievement_trigger/'.$row->id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    anchor( site_url('dashboard/delete_achievement_trigger/'.$row->id), lang('btn_delete'), array('class' => 'btn btn-danger btn-xs'))
                );
            }
        }

        // Define the page data.
        $data['page'] = array(
            // Table.
            'tbl_achievement_triggers' => $this->table->generate(),
            // Buttons.
            'btn_add_achievement_trigger' => anchor( site_url('dashboard/add_achievement_trigger'), lang('btn_add_achievement_trigger'), array('class' => 'btn btn-success btn-sm')),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

}