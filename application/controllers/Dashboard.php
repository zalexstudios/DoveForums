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
        ),
        'edit_category' => array(
            //0
            array(
                'field' => 'name[]',
                'rules' => 'required',
                'label' => 'lang:rules_name',
            ),
        ),
        'delete_category' => array(
            //0
            array(
                'field' => 'category',
                'rules' => 'required',
                'label' => 'lang:rules_category',
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
        'add_edit_achievement' => array(
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
                'field' => 'points',
                'rules' => 'required|numeric',
                'label' => 'lang:rules_points',
            ),
        ),
        'add_edit_achievement_trigger' => array(
            //0
            array(
                'field' => 'action',
                'rules' => 'required',
                'label' => 'lang:rules_action',
            ),
            //1
            array(
                'field' => 'condition',
                'rules' => 'required',
                'label' => 'lang:rules_condition',
            ),
            //2
            array(
                'field' => 'achievement',
                'rules' => 'required',
                'label' => 'lang:rules_achievement',
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
        ),
        'edit_category' => array(
            //0
            array(
                'id' => 'name',
                'name' => 'name',
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
            //4
            array(
                'id' => 'smtp_host',
                'name' => 'smtp_host',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //5
            array(
                'id' => 'smtp_port',
                'name' => 'smtp_port',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //6
            array(
                'id' => 'smtp_user',
                'name' => 'smtp_user',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //7
            array(
                'id' => 'smtp_pass',
                'name' => 'smtp_pass',
                'class' => 'form-control',
                'type' => 'password',
            )
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
        'add_edit_achievement' => array(
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
                'id' => 'points',
                'name' => 'points',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
        'add_edit_achievement_trigger' => array(
            //0
            array(
                'id' => 'condition',
                'name' => 'condition',
                'class' => 'form-control',
                'type' => 'text',
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

        // Check for any updates.
        // Get the current release versions.
        $current_versions = file_get_contents('http://www.doveforums.com/downloads/current-release-versions.php');

        if(!empty($current_versions)) {
            $version_list = explode("\n", $current_versions);

            foreach ($version_list as $vl) {
                if ($vl > $this->version) {
                    $update = TRUE;
                    $version = $vl;
                } else {
                    $update = FALSE;
                    $version = NULL;
                }
            }
        }


        // Define the page data.
        $data['page'] = array(
            // Other
            'update' => $update,
            'version' => $version,
            'download_link' => anchor( site_url('dashboard/updates'), lang('txt_here'), array('class' => 'alert-link')),
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
            '',
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
                // Build the users avatar.
                $data['avatar'] = array(
                    'src' => $this->gravatar->get_gravatar($row->email, $this->config->item('gravatar_rating'), '40', $this->config->item('gravatar_default_image') ),
                    'class' => 'img-thumbnail img-responsive',
                );

                $this->table->add_row(
                    img(element('avatar', $data)),
                    $row->username,
                    $row->first_name,
                    $row->last_name,
                    ($row->active == 1) ? anchor( site_url('dashboard/deactivate_user/'.$row->id), '<span class="label label-success">'.lang('txt_active').'</span>' ) : anchor( site_url('dashboard/activate_user/'.$row->id), '<span class="label label-danger">'.lang('txt_inactive').'</span>' ),
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
            $this->comments->delete_by(array('poster' => $user->username));

            // Delete any comments created by the user.
            $this->discussions->delete_by(array('poster' => $user->username));

            // Create a message.
            $this->messageci->set( sprintf( lang('success_delete_user'), $user->username), 'success');
        } else {
            // Create a message.
            $this->messageci->set( sprintf( lang('error_delete_user'), $user->username), 'error');
        }

        // Redirect.
        redirect( $this->agent->referrer(), 'refresh' );
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

            // Get the group permissions.
            $permissions = $this->permission->get_permissions($group_id);

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
     * Categories
     *
     * Add, Edit & Delete categories.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function categories()
    {
        // See if the form has been posted.
        if($this->input->post('action') == 'Add')
        {
            // Set the validation rules.
            $this->form_validation->set_rules($this->validation_rules['add_category']);
        }
        else if($this->input->post('action') == 'Edit')
        {
            // Set the validation rules.
            $this->form_validation->set_rules($this->validation_rules['edit_category']);
        }
        else if($this->input->post('action') == 'Delete')
        {
            // Set the validation rules.
            $this->form_validation->set_rules($this->validation_rules['delete_category']);
        }

        // See if the form has run.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_categories');

            // Define the page template.
            $data['template'] = 'pages/dashboard/categories';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_categories'));

            // Get all the categories.
            $categories = $this->categories->get_all();

            // Build the category dropdown.
            if(!empty($categories))
            {
                // Build the category options.
                $category_options[NULL] = lang('dd_category_default');

                foreach($categories as $row)
                {
                    $category_options[$row->id] = $row->name;
                }

                // Build the edit fields.
                foreach($categories as $cat)
                {
                    $data['categories'][] = array(
                        'category' => form_input(array('type' => 'text', 'class' => 'form-control', 'name' => 'name['.$cat->id.']'), set_value($cat->id, $cat->name)),
                        'hidden' => form_hidden('original_name[]', $cat->name),
                    );
                }
            }
            else
            {
                $category_options[NULL] = lang('dd_category_default');
                $category_options = '';
            }

            // Define the page data.
            $data['page'] = array(
                // Form.
                'form_open' => form_open( site_url('dashboard/categories') ),
                'form_close' => form_close(),
                // Hidden Fields.
                'add_hidden_field' => form_hidden('action', 'Add'),
                'edit_hidden_field' => form_hidden('action', 'Edit'),
                'delete_hidden_field' => form_hidden('action', 'Delete'),
                // Fields
                'name_field' => form_input( $this->form_fields['add_category'][0], set_value( $this->form_fields['add_category'][0]['name'], $this->input->post('name') ) ),
                'category_field' => form_dropdown('category', $category_options, '0', 'class="form-control"'),
                'categories' => element('categories', $data),
                // Errors.
                'name_error' => form_error($this->form_fields['add_category'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'category_error' => form_error('category', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i>', '</p>'),
                // Labels.
                'name_label' => form_label( lang('lbl_name'), $this->form_fields['add_category'][0]['id']),
                'category_label' => form_label( 'Category', 'category'),
                // Buttons.
                'btn_add' => form_submit('submit', 'Add New', 'class="btn btn-primary btn-sm"'),
                'btn_edit' => form_submit('submit', 'Update', 'class="btn btn-primary btn-sm"'),
                'btn_delete' => form_submit('submit', 'Delete', 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {
            if($this->input->post('action') == 'Add')
            {
                // Load the slug library.
                $config = array(
                    'field' => 'slug',
                    'title' => 'name',
                    'table' => 'categories',
                    'replacement' => 'underscore'
                );

                $this->load->library('slug', $config);

                // Build the data.
                $data = array(
                    'name' => $this->input->post('name'),
                    'slug' => $this->slug->create_uri( strip_tags($this->input->post('name') )),
                );

                // Add to the database.
                $insert = $this->categories->insert($data);

                if($insert)
                {
                    // Create success message.
                    $this->messageci->set( sprintf(lang('success_add_category'), $this->input->post('name')), 'success');
                }
                else
                {
                    // Create error message.
                    $this->messageci->set( sprintf( lang('error_add_category'), $this->input->post('name')), 'error');
                }

                // Redirect.
                redirect( site_url('dashboard/categories'), 'refresh');
            }
            else if($this->input->post('action') == 'Edit')
            {
                // Update the categories.
                foreach($this->input->post('name') as $key => $val)
                {
                    // Load the slug library.
                    $config = array(
                        'field' => 'slug',
                        'title' => 'name',
                        'id' => 'id',
                        'table' => 'categories',
                        'replacement' => 'underscore'
                    );

                    $this->load->library('slug', $config);

                    // Get the original category.
                    $cat = $this->categories->get_by('id', $key);

                    // Build the data.
                    $data = array(
                        'name' => $val,
                        'slug' => $this->slug->create_uri(strip_tags($val), $cat->id),
                    );

                    $update = $this->categories->update_by(array('id' => $key), $data);

                    if($update)
                    {
                        // Create a message.
                        $this->messageci->set( sprintf(lang('success_update_category'), $val), 'success' );
                    }
                    else
                    {
                        // Create a message.
                        $this->messageci->set( sprintf(lang('error_update_category'), $val), 'error' );
                    }
                }

                // Redirect.
                redirect( site_url('dashboard/categories'), 'refresh');
            }
            else if($this->input->post('action') == 'Delete')
            {
                // Grab the category.
                $cat = $this->categories->get_by('id', $this->input->post('category'));

                // Delete the category.
                $delete = $this->categories->delete($this->input->post('category'));

                if($delete)
                {
                    // Create success message.
                    $this->messageci->set( sprintf( lang('success_delete_category'), $cat->name), 'success' );
                }
                else
                {
                    // Create error message.
                    $this->messageci->set( sprintf( lang('error_delete_category'), $cat->name), 'error' );
                }

                // Redirect.
                redirect( site_url('dashboard/categories'), 'refresh');
            }
        }

    }

    /*****************************************************************************************
     * Reports Functions
     *****************************************************************************************/

    public function reports()
    {
        // Define the page title.
        $data['title'] = lang('tle_reports');

        // Define the page template.
        $data['template'] = 'pages/dashboard/reports';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_reports'));

        // Get any unread reports from the database.
        $unread = $this->reports->get_by('zapped', NULL);

        // Get all the reports from the database.
        $reports = $this->reports->get_all();


        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
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

            // Build the protocol options.
            $protocol = array(
                'smtp' => 'smtp',
                'mail' => 'mail',
                'sendmail' => 'sendmail',
            );

            // Build the mailtype options.
            $mailtype = array(
                'html' => 'html',
                'text' => 'text',
            );

            // Build the site language options.
            $language_options = $this->language->dropdown('code', 'language');

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
                'protocol_field' => form_dropdown('protocol', $protocol, $this->settings->get_setting('protocol'), 'class="form-control"'),
                'mailtype_field' => form_dropdown('mailtype', $mailtype, $this->settings->get_setting('mailtype'), 'class="form-control"'),
                'smtp_host_field' => form_input($this->form_fields['settings'][4], set_value($this->form_fields['settings'][4]['name'], $this->settings->get_setting('smtp_host'))),
                'smtp_port_field' => form_input($this->form_fields['settings'][5], set_value($this->form_fields['settings'][5]['name'], $this->settings->get_setting('smtp_port'))),
                'smtp_user_field' => form_input($this->form_fields['settings'][6], set_value($this->form_fields['settings'][6]['name'], $this->settings->get_setting('smtp_user'))),
                'smtp_pass_field' => form_input($this->form_fields['settings'][7], set_value($this->form_fields['settings'][7]['name'], $this->settings->get_setting('smtp_pass'))),
                'notify_new_registration_field' => form_checkbox('notify_new_registration', 1, set_value('notify_new_registration', $this->settings->get_setting('notify_new_registration'))),
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
                'protocol_label' => form_label( lang('lbl_protocol'), 'protocol'),
                'mailtype_label' => form_label( lang('lbl_mailtype'), 'mailtype'),
                'smtp_host_label' => form_label( lang('lbl_smtp_host'), $this->form_fields['settings'][4]['id']),
                'smtp_port_label' => form_label( lang('lbl_smtp_port'), $this->form_fields['settings'][5]['id']),
                'smtp_user_label' => form_label( lang('lbl_smtp_user'), $this->form_fields['settings'][6]['id']),
                'smtp_pass_label' => form_label( lang('lbl_smtp_pass'), $this->form_fields['settings'][7]['id']),
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
                'protocol' => $this->input->post('protocol'),
                'mailtype' => $this->input->post('mailtype'),
                'smtp_host' => $this->input->post('smtp_host'),
                'smtp_pass' => $this->input->post('smtp_pass'),
                'smtp_user' => $this->input->post('smtp_user'),
                'smtp_port' => $this->input->post('smtp_port'),
                'notify_new_registration' => $this->input->post('notify_new_registration')
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
        $languages = $this->language->get_all();

        if (!empty($languages))
        {
            foreach($languages as $row)
            {
                $this->table->add_row(
                    img('themes/default/img/flags/'.$row->icon),
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

    public function add_achievement()
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['add_edit_achievement']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_add');

            // Define the page template.
            $data['template'] = 'pages/dashboard/add_edit_achievement';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_add'));

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('dashboard/add_achievement') ),
                'form_close' => form_close(),
                // Fields
                'name_field' => form_input( $this->form_fields['add_edit_achievement'][0], set_value( $this->form_fields['add_edit_achievement'][0]['name'], $this->input->post('name') ) ),
                'description_field' => form_input( $this->form_fields['add_edit_achievement'][1], set_value( $this->form_fields['add_edit_achievement'][1]['name'], $this->input->post('description') ) ),
                'points_field' => form_input( $this->form_fields['add_edit_achievement'][2], set_value( $this->form_fields['add_edit_achievement'][2]['name'], $this->input->post('points') ) ),
                // Errors.
                'name_error' => form_error($this->form_fields['add_edit_achievement'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'description_error' => form_error($this->form_fields['add_edit_achievement'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'points_error' => form_error($this->form_fields['add_edit_achievement'][2]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'name_label' => form_label( lang('lbl_name'), $this->form_fields['add_edit_achievement'][0]['id']),
                'description_label' => form_label( lang('lbl_description'), $this->form_fields['add_edit_achievement'][1]['id']),
                'points_label' => form_label( lang('lbl_points'), $this->form_fields['add_edit_achievement'][2]['id']),
                // Buttons.
                'btn_add_edit_achievement' => form_submit('submit', lang('btn_add_achievement'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
                'action' => 'add',
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Data
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'points' => $this->input->post('points'),
            );

            if($this->achievements->add_achievement($data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( lang('success_create_achievement'), 'success');

                // Redirect.
                redirect( site_url('dashboard/achievements'), 'refresh' );
            }
            else
            {
                // Create a message.
                $this->messageci->set( lang('error_create_achievement'), 'error');

                // Redirect
                redirect( site_url('dashboard/achievements'), 'refresh' );
            }
        }
    }

    public function delete_achievement($achievement_id)
    {

        if(empty($achievement_id))
        {
            // Create a message.
            $this->messageci->set( lang('error_invalid_id'), 'error');

            // Redirect.
            redirect($this->agent->referrer());
        }

        $delete = $this->achievements->delete_achievement($achievement_id);

        if($delete === TRUE)
        {
            // Create a message.
            $this->messageci->set( lang('success_delete_achievement'), 'success');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }
        else
        {
            // Create a message.
            $this->messageci->set( lang('error_delete_achievement'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }
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

    public function add_achievement_trigger()
    {
        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['add_edit_achievement_trigger']);

        // See if the form has been submitted.
        if($this->form_validation->run() === FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_add');

            // Define the page template.
            $data['template'] = 'pages/dashboard/add_edit_achievement_trigger';

            // Build the breadcrumbs.
            $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
            $this->crumbs->add(lang('crumb_add'));

            // Build the trigger options.
            $action_options = array(
                'create_discussion' => 'Create Discussion',
                'edit_discussion' => 'Edit Discussion',
                'delete_discussion' => 'Delete Discussion',
                'create_comment' => 'Create Comment',
                'edit_comment' => 'Edit Comment',
                'delete_comment' => 'Delete Comment',
            );

            // Get the achievements.
            $achievements = $this->achievements->get_achievements();

            if(!empty($achievements))
            {
                $achievement_options[NULL] = lang('dd_achievement_default');

                foreach($achievements as $row)
                {
                    $achievement_options[$row->id] = $row->name;
                }
            }

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('dashboard/add_achievement_trigger') ),
                'form_close' => form_close(),
                // Fields
                'condition_field' => form_input( $this->form_fields['add_edit_achievement_trigger'][0], set_value( $this->form_fields['add_edit_achievement_trigger'][0]['name'], $this->input->post('condition') ) ),
                'action_field' => form_dropdown('action', $action_options, '0', 'class="form-control"'),
                'achievement_field' => form_dropdown('achievement', $achievement_options, '0', 'class="form-control"'),
                // Errors.
                'condition_error' => form_error($this->form_fields['add_edit_achievement_trigger'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'action_error' => form_error('action', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'achievement_error' => form_error('achievement', '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Labels.
                'condition_label' => form_label( lang('lbl_condition'), $this->form_fields['add_edit_achievement_trigger'][0]['id']),
                'action_label' => form_label( lang('lbl_action'), 'action'),
                'achievement_label' => form_label( lang('lbl_achievement'), 'achievement'),
                // Buttons.
                'btn_add_edit_achievement_trigger' => form_submit('submit', lang('btn_add_achievement_trigger'), 'class="btn btn-primary btn-sm"'),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
                'action' => 'add',
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );

        } else {

            // Data
            $data = array(
                'condition' => $this->input->post('condition'),
                'action' => $this->input->post('action'),
                'achievement_id' => $this->input->post('achievement'),
            );

            if($this->achievements->add_achievement_trigger($data) === TRUE)
            {
                // Create a message.
                $this->messageci->set( lang('success_create_achievement_trigger'), 'success');

                // Redirect.
                redirect( site_url('dashboard/achievements'), 'refresh' );
            }
            else
            {
                // Create a message.
                $this->messageci->set( lang('error_create_achievement_trigger'), 'error');

                // Redirect
                redirect( site_url('dashboard/achievements'), 'refresh' );
            }
        }
    }

    public function permissions()
    {
        // Define the page title.
        $data['title'] = lang('tle_permissions');

        // Define the page template.
        $data['template'] = 'pages/dashboard/permissions';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_permissions'));

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            lang('tbl_permission'),
            lang('tbl_key'),
            lang('tbl_category'),
            lang('tbl_action')
        );

        // Get all the permissions.
        $permissions = $this->permission->get_permissions();

        if (!empty($permissions))
        {
            foreach($permissions as $row)
            {
                $this->table->add_row(
                    $row->permission,
                    $row->key,
                    $row->category,
                    ''.anchor( site_url('dashboard/edit_permission/'.$row->permission_id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    anchor( site_url('dashboard/delete_permission/'.$row->permission_id), lang('btn_delete'), array('class' => 'btn btn-danger btn-xs'))
                );
            }
        }

        // Define the page data.
        $data['page'] = array(
            // Table.
            'tbl_permissions' => $this->table->generate(),
            // Buttons.
            'btn_add_permission' => anchor( site_url('dashboard/add_permission'), lang('btn_add_permission'), array('class' => 'btn btn-success btn-sm')),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function themes()
    {
        // Define the page title.
        $data['title'] = lang('tle_themes');

        // Define the page template.
        $data['template'] = 'pages/dashboard/themes';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_themes'));

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            '',
            lang('tbl_name'),
            lang('tbl_description'),
            lang('tbl_author'),
            lang('tbl_status'),
            lang('tbl_action')
        );

        // Get all the themes.
        $themes = $this->themes->get_all();

        if (!empty($themes))
        {
            foreach($themes as $row)
            {
                // Build the thumbnail image.
                $img = array(
                    'src' => base_url('themes/default/img/thumbs/'.$row->thumb.''),
                    'class' => 'img-thumbnail img-responsive',
                    'width' => '100px',
                    'height' => '100px',
                );

                $this->table->add_row(
                    anchor( site_url('dashboard/theme_details/'.$row->id), img($img)),
                    $row->name,
                    $row->description,
                    $row->author,
                    ($row->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'),
                    ''.($row->status == 0 ? anchor( site_url('dashboard/activate_theme/'.$row->id), '<i class="fa fa-check"></i>', array('class' => 'btn btn-success btn-xs')) : '').'&nbsp;'.
                    anchor( site_url('dashboard/edit_theme/'.$row->id), lang('btn_edit'), array('class' => 'btn btn-default btn-xs')).'&nbsp;'.
                    anchor( site_url('dashboard/delete_theme/'.$row->id), lang('btn_delete'), array('class' => 'btn btn-danger btn-xs'))
                );
            }
        }

        // Define the page data.
        $data['page'] = array(
            // Table.
            'tbl_themes' => $this->table->generate(),
            // Buttons.
            'btn_add_theme' => anchor( site_url('dashboard/add_theme'), lang('btn_add_theme'), array('class' => 'btn btn-success btn-sm')),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function activate_theme($theme_id)
    {
        // Deactivate all themes.
        $this->themes->update_all(array('status' => 0));

        $activate = $this->themes->update($theme_id, array('status' => 1));

        // Get the theme.
        $theme = $this->themes->get_by('id', $theme_id);

        // Update the settings table.
        $this->settings->edit_setting('theme', $theme->name);
        $this->settings->edit_setting('admin_theme', $theme->name);

        if($activate)
        {
            // Create a success message.
            $this->messageci->set( sprintf(lang('success_activate_theme'), $theme->name), 'success');
        } else {
            // Create a error message.
            $this->messageci->set( sprintf(lang('error_activate_theme'), $theme->name), 'error');
        }

        redirect( $this->agent->referrer(), 'refresh');
    }

    public function theme_details($theme_id)
    {
        // Define the page title.
        $data['title'] = lang('tle_theme_details');

        // Define the page template.
        $data['template'] = 'pages/dashboard/theme_details';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_themes'), 'dashboard/themes');
        $this->crumbs->add(lang('crumb_theme_details'));

        // Get the theme.
        $theme = $this->themes->get_by('id', $theme_id);

        // Build the image.
        $img = array(
            'src' => base_url('themes/default/img/thumbs/'.$theme->thumb.''),
            'class' => 'img-responsive img-thumbnail',
        );

        // Define the page data.
        $data['page'] = array(
            // Theme Details.
            'theme_name' => ucfirst($theme->name),
            'theme_description' => $theme->description,
            'theme_author' => $theme->author,
            'theme_image' => img($img),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function updates($do_update=NULL)
    {
        // Define the page title.
        $data['title'] = lang('tle_updates');

        // Define the page template.
        $data['template'] = 'pages/dashboard/updates';

        // Build the breadcrumbs.
        $this->crumbs->add(lang('crumb_dashboard'), 'dashboard');
        $this->crumbs->add(lang('crumb_updates'));

        // Get the current release versions.
        $current_versions = file_get_contents('http://www.doveforums.com/downloads/current-release-versions.php');

        if(!empty($current_versions))
        {
            $version_list = explode("\n", $current_versions);

            foreach($version_list as $vl)
            {
                if($vl > $this->version)
                {
                    $update_found = $vl;
                    $found = true;

                    // Download the file if we do not have it.
                    if(!is_file(APPPATH . 'updates/df_v_'.$vl.'.zip'))
                    {
                        $data['statuses'][]['status'] = lang('status_downloading_update');

                        $new_update = file_get_contents('http://www.doveforums.com/downloads/updates/df_v_'.$vl.'.zip');

                        if(!is_dir(APPPATH . 'updates'))
                        {
                            mkdir(APPPATH . 'updates');
                        }

                        $dl_handler = fopen(APPPATH . 'updates/df_v_'.$vl.'.zip', 'w');

                        if(!fwrite($dl_handler, $new_update))
                        {
                            $data['statuses'][]['status'] = lang('status_downloaded_failed');
                            exit();
                        }

                        fclose($dl_handler);

                        $data['statuses'][]['status'] = lang('status_downloaded_saved');
                    } else {
                        $data['statuses'][]['status'] = lang('status_already_downloaded');
                    }

                    if($do_update == 1)
                    {
                        // Open the file.
                        $zip_handle = zip_open(APPPATH . 'updates/df_v_'.$vl.'.zip');

                        while ($aF = zip_read($zip_handle) )
                        {
                            $thisFileName = zip_entry_name($aF);
                            $thisFileDir = dirname($thisFileName);

                            //Continue if its not a file
                            if ( substr($thisFileName,-1,1) == '/') continue;

                            //Make the directory if we need to...
                            if ( !is_dir ( FCPATH . $thisFileDir ) )
                            {
                                mkdir ( FCPATH . $thisFileDir );
                            }

                            //Overwrite the file
                            if ( !is_dir(FCPATH . $thisFileName) ) {
                                $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                                $contents = str_replace("\r\n", "\n", $contents);

                                //If we need to run commands, then do it.
                                if ( $thisFileName === 'upgrade.sql' )
                                {
                                    $upgradeExec = fopen('upgrade.sql','w');
                                    fwrite($upgradeExec, $contents);
                                    fclose($upgradeExec);
                                    $this->db->query(file_get_contents('upgrade.sql'));
                                    unlink('upgrade.sql');
                                }
                                else
                                {
                                    $updateThis = fopen(FCPATH . $thisFileName, 'w');
                                    fwrite($updateThis, $contents);
                                    fclose($updateThis);
                                    unset($contents);
                                }
                            }
                        }

                        $updated = TRUE;

                    } else {
                        $data['statuses'][]['status'] = anchor( site_url('dashboard/updates/1'), lang('status_install_now'), array('class' => 'btn btn-xs btn-primary'));
                        break;
                    }
                }
            }

            if($updated == TRUE)
            {
                $this->settings->edit_setting('version', $vl);

                // Create success message.
                $this->messageci->set( sprintf(lang('success_software_updated'), $vl), 'success');

                // Redirect
                redirect('dashboard/updates');
            }
            else if ($found != true) $data['statuses'][]['status'] = lang('status_up_to_date');
        }
        else echo 'failed';

        // Define the page data.
        $data['page'] = array(
            'current_version' => $this->version,
            'update_found' => $update_found,
            'statuses' => element('statuses', $data),
            'files' => element('files', $data),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

}