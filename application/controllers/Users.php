<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Front_Controller {

    private $validation_rules = array(
        'login' => array(
            //0
            array(
                'field' => 'identity',
                'rules' => 'required',
                'label' => 'lang:rules_email',
            ),
            //1
            array(
                'field' => 'password',
                'rules' => 'required',
                'label' => 'lang:rules_password',
            ),
        ),
        'register' => array(
            //0
            array(
                'field' => 'username',
                'rules' => 'required',
                'label' => 'lang:rules_username',
            ),
            //1
            array(
                'field' => 'password',
                'rules' => 'required|matches[confirm_password]',
                'label' => 'lang:rules_password',
            ),
            //2
            array(
                'field' => 'confirm_password',
                'rules' => 'required',
                'label' => 'lang:rules_confirm_password',
            ),
            //3
            array(
                'field' => 'email',
                'rules' => 'required|valid_email|matches[confirm_email]',
                'label' => 'lang:rules_email',
            ),
            //4
            array(
                'field' => 'confirm_email',
                'rules' => 'required|valid_email',
                'label' => 'lang:rules_confirm_email',
            ),
        ),
        'change_password' => array(
            //0
            array(
                'field' => 'old_password',
                'rules' => 'required',
                'label' => 'lang:rules_old_password',
            ),
            //1
            array(
                'field' => 'new_password',
                'rules' => 'required',
                'label' => 'lang:rules_new_password',
            ),
            //2
            array(
                'field' => 'confirm_new_password',
                'rules' => 'required|matches[new_password]',
                'label' => 'lang:rules_confirm_new_password',
            ),
        ),
    );

    private $form_fields = array(
        'login' => array(
            //0
            array(
                'id' => 'identity',
                'name' => 'identity',
                'class' => 'form-control',
                'type' => 'email',
                'placeholder' => 'Email',
            ),
            //1
            array(
                'id' => 'password',
                'name' => 'password',
                'class' => 'form-control',
                'type' => 'password',
            ),
        ),
        'register' => array(
            //0
            array(
                'id' => 'username',
                'name' => 'username',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //1
            array(
                'id' => 'password',
                'name' => 'password',
                'class' => 'form-control',
                'type' => 'password',
            ),
            //2
            array(
                'id' => 'confirm_password',
                'name' => 'confirm_password',
                'class' => 'form-control',
                'type' => 'password',
            ),
            //3
            array(
                'id' => 'email',
                'name' => 'email',
                'class' => 'form-control',
                'type' => 'email',
            ),
            //4
            array(
                'id' => 'confirm_email',
                'name' => 'confirm_email',
                'class' => 'form-control',
                'type' => 'email',
            ),
        ),
        'change_password' => array(
            //0
            array(
                'id' => 'old_password',
                'name' => 'old_password',
                'class' => 'form-control',
                'type' => 'password',
            ),
            //1
            array(
                'id' => 'new_password',
                'name' => 'new_password',
                'class' => 'form-control',
                'type' => 'password',
            ),
            //2
            array(
                'id' => 'confirm_new_password',
                'name' => 'confirm_new_password',
                'class' => 'form-control',
                'type' => 'password',
            ),
        ),
        'forgot_password' => array(
            //0
            array(
                'id' => 'identity',
                'name' => 'identity',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
        'reset_password' => array(
            //0
            array(
                'id' => 'new_password',
                'name' => 'new_password',
                'class' => 'form-control',
                'type' => 'password',
            ),
            //1
            array(
                'id' => 'confirm_new_password',
                'name' => 'confirm_new_password',
                'class' => 'form-control',
                'type' => 'password',
            ),
        ),
    );

    /**
     * Register
     *
     * Registers a user.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function register()
    {
        // First make sure the user is not logged in.
        if ( $this->ion_auth->logged_in() === TRUE )
        {
            // Create a message.
            $this->messageci->set( lang('info_logged_in'), 'info' );

            // Redirect.
            redirect( site_url('forums') );
        }

        // Set the form validation rules.
        $this->form_validation->set_rules( $this->validation_rules['register'] );

        // See if the form validation has been run.
        if ( $this->form_validation->run() === FALSE )
        {
            // Define the page title.
            $data['title'] = lang('tle_register');

            // Define the page template.
            $data['template'] = 'pages/users/register';

            // Build the breadcrumbs.
            $this->crumbs->add( lang('crumb_users'), 'users');
            $this->crumbs->add( lang('crumb_register') );

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('users/register') ),
                'form_close' => form_close(),
                // Fields.
                'username_field' => form_input( $this->form_fields['register'][0], set_value( $this->form_fields['register'][0]['name'], $this->input->post('username') ) ),
                'password_field' => form_input( $this->form_fields['register'][1], set_value( $this->form_fields['register'][1]['name'], $this->input->post('password') ) ),
                'confirm_password_field' => form_input( $this->form_fields['register'][2], set_value( $this->form_fields['register'][2]['name'], $this->input->post('confirm_password') ) ),
                'email_field' => form_input( $this->form_fields['register'][3], set_value( $this->form_fields['register'][3]['name'], $this->input->post('email') ) ),
                'confirm_email_field' => form_input( $this->form_fields['register'][4], set_value( $this->form_fields['register'][4]['name'], $this->input->post('confirm_email') ) ),
                // Labels.
                'username_label' => form_label( lang('lbl_users'), $this->form_fields['register'][0]['id']),
                'password_label' => form_label( lang('lbl_password'), $this->form_fields['register'][1]['id']),
                'confirm_password_label' => form_label( lang('lbl_confirm_password'), $this->form_fields['register'][2]['id']),
                'email_label' => form_label( lang('lbl_email'), $this->form_fields['register'][3]['id']),
                'confirm_email_label' => form_label( lang('lbl_confirm_email'), $this->form_fields['register'][4]['id']),
                // Errors.
                'username_error' => form_error($this->form_fields['register'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'password_error' => form_error($this->form_fields['register'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'confirm_password_error' => form_error($this->form_fields['register'][2]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'email_error' => form_error($this->form_fields['register'][3]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'confirm_email_error' => form_error($this->form_fields['register'][4]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'register_button' => form_submit('submit', lang('btn_register'), 'class="btn btn-primary btn-sm"'),
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {
            // The form has been submitted, sanitize the data.
            $username = strip_tags( $this->security->xss_clean( $this->input->post('username') ) );
            $password = strip_tags( $this->security->xss_clean( $this->input->post('password') ) );
            $email = strip_tags( $this->security->xss_clean( $this->input->post('email') ) );

            // Perform the registration.
            $register = $this->ion_auth->register($username, $password, $email);

            if($register)
            {
                // Create a message.
                $this->messageci->set( $this->ion_auth->messages(), 'success' );

                // Redirect.
                redirect( site_url('forums') );
            } else {

                // Create a message.
                $this->messageci->set( $this->ion_auth->errors(), 'error' );

                // Redirect.
                redirect( site_url('forums') );
            }
        }
    }

    /**
     * Login
     *
     * Logs a user into the site.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function login()
    {
        // First make sure the user is not logged in.
        if( $this->ion_auth->logged_in() === TRUE )
        {
            // Create a message.
            $this->messageci->set( lang('info_logged_in'), 'info' );

            // Redirect.
            redirect( site_url('forums') );
        }

        // Set the form validation rules.
        $this->form_validation->set_rules($this->validation_rules['login']);

        // See if the form validation has been run.
        if( $this->form_validation->run() === FALSE )
        {
            // Define the page title.
            $data['title'] = lang('tle_login');

            // Define the page template.
            $data['template'] = 'pages/users/login';

            // Build the page breadcrumbs.
            $this->crumbs->add( lang('crumb_users'), 'users');
            $this->crumbs->add( lang('crumb_login') );

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('users/login') ),
                'form_close' => form_close(),
                // Fields.
                'identity_field' => form_input( $this->form_fields['login'][0], set_value( $this->form_fields['login'][0]['name'], $this->input->post('identity') ) ),
                'password_field' => form_input( $this->form_fields['login'][1] ),
                // Labels.
                'identity_label' => form_label( lang('lbl_email'), $this->form_fields['login'][0]['id'] ),
                'password_label' => form_label( lang('lbl_password'), $this->form_fields['login'][1]['id'] ),
                // Buttons.
                'btn_login' => form_submit( 'submit', lang('btn_login'), 'class="btn btn-primary"'),
                'btn_forgot_password' => anchor( site_url('users/forgot_password'), lang('btn_forgot_password'), array('class' => 'btn btn-danger')),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {

            // Form has been submitted, sanitize the data.
            $identity = strip_tags( $this->security->xss_clean( $this->input->post('identity') ) );
            $password = strip_tags( $this->security->xss_clean( $this->input->post('password') ) );

            // Perform the login.
            $login = $this->ion_auth->login($identity, $password);

            if($login === TRUE)
            {
                // Update the users visit count.
                $user = $this->ion_auth->user()->row();

                $this->forums->update_visit_count($user->id, ++$user->visit_count);

                // Create a message.
                $this->messageci->set( $this->ion_auth->messages(), 'success' );

                // Redirect.
                redirect( site_url('forums') );
            } else {

                // Create a message.
                $this->messageci->set( $this->ion_auth->errors(), 'error' );

                // Redirect.
                redirect( site_url('users/login') );
            }
        }
    }

    /**
     * Logout
     *
     * Logs out the user.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function logout()
    {
        $this->ion_auth->logout();

        // Create a message.
        $this->messageci->set( $this->ion_auth->messages(), 'success' );

        // Redirect.
        redirect( site_url('forums') );
    }

    /**
     * Activate
     *
     * Activates the user.
     *
     * @param       integer     $id
     * @param       bool        $code
     * @author      Ragash
     * @since       0.0.1
     */
    public function activate($id, $code=false)
    {
        if ($code !== false)
        {
            $activation = $this->ion_auth->activate($id, $code);
        }
        else if ($this->ion_auth->is_admin())
        {
            $activation = $this->ion_auth->activate($id);
        }
        if ($activation)
        {
            // Create a message.
            $this->messageci->set( $this->ion_auth->messages(), 'success' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }
        else
        {
            // Create a message.
            $this->messageci->set( $this->ion_auth->errors(), 'error' );

            // Redirect.
            redirect( site_url(), 'refresh' );
        }
    }

    /**
     * Thumbs Up
     *
     * Awards the user a point for been helpful.
     *
     * @param       integer     $user_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function thumbs_up ($user_id)
    {
        /* TODO */
    }

    /**
     * Change Password
     *
     * Allows the user to change their password.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function change_password()
    {
        // First make sure the user is logged in.
        if ( !$this->ion_auth->logged_in() === TRUE )
        {
            // Create a message.
            $this->messageci->set( lang('info_login_required'), 'info' );

            // Redirect.
            redirect( site_url('forums') );
        }

        // Set the form validation rules.
        $this->form_validation->set_rules( $this->validation_rules['change_password'] );

        // See if the form validation has been run.
        if ( $this->form_validation->run() === FALSE )
        {
            // Define the page title.
            $data['title'] = lang('tle_change_password');

            // Define the page template.
            $data['template'] = 'pages/users/change_password';

            // Build the breadcrumbs.
            $this->crumbs->add( lang('crumb_users'), 'users');
            $this->crumbs->add( lang('crumb_change_password') );

            // Get the user.
            $user = $this->ion_auth->user()->row();

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('users/change_password') ),
                'form_close' => form_close(),
                // Fields.
                'old_password_field' => form_input( $this->form_fields['change_password'][0], set_value( $this->form_fields['change_password'][0]['name'], $this->input->post('old_password') ) ),
                'new_password_field' => form_input( $this->form_fields['change_password'][1], set_value( $this->form_fields['change_password'][1]['name'], $this->input->post('new_password') ) ),
                'confirm_new_password_field' => form_input( $this->form_fields['change_password'][2], set_value( $this->form_fields['change_password'][2]['name'], $this->input->post('confirm_new_password') ) ),
                // Labels.
                'old_password_label' => form_label( lang('lbl_old_password'), $this->form_fields['change_password'][0]['id']),
                'new_password_label' => form_label( lang('lbl_new_password'), $this->form_fields['change_password'][1]['id']),
                'confirm_new_password_label' => form_label( lang('lbl_confirm_password'), $this->form_fields['change_password'][2]['id']),
                // Errors.
                'old_password_error' => form_error($this->form_fields['change_password'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'new_password_error' => form_error($this->form_fields['change_password'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'confirm_new_password_error' => form_error($this->form_fields['change_password'][2]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'btn_change_password' => form_submit('submit', lang('btn_change_password'), 'class="btn btn-primary btn-sm"'),
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {
            $identity =  $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));

            if($change)
            {
                // Create a message.
                $this->messageci->set( $this->ion_auth->messages(), 'success');

                // Logout.
                $this->logout();
            } else {
                // Create a message.
                $this->messageci->set( $this->ion_auth->errors(), 'error');

                // Redirect.
                redirect( site_url('forums'), 'refresh');
            }
        }
    }

    /**
     * Forgot Password
     *
     * Allows a user to request a new password.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function forgot_password()
    {
        // Set validation rules by checking if identity is username or email.
        if($this->config->item('identity', 'ion_auth') == 'username' )
        {
            $this->form_validation->set_rules('identity', lang('forgot_password_username_identity_label'), 'required');
        }
        else
        {
            $this->form_validation->set_rules('identity', lang('forgot_password_validation_email_label'), 'required|valid_email');
        }

        if($this->form_validation->run() == FALSE)
        {
            // Define the page title.
            $data['title'] = lang('tle_forgot_password');

            // Define the page template.
            $data['template'] = 'pages/users/forgot_password';

            // Build the page breadcrumbs.
            $this->crumbs->add( lang('crumb_users'), 'users');
            $this->crumbs->add( lang('crumb_forgot_password') );

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('users/forgot_password') ),
                'form_close' => form_close(),
                // Fields.
                'identity_field' => form_input( $this->form_fields['forgot_password'][0], set_value( $this->form_fields['forgot_password'][0]['name'], $this->input->post('identity') ) ),
                // Labels.
                'identity_label' => form_label( lang('lbl_email'), $this->form_fields['forgot_password'][0]['id'] ),
                // Errors.
                'identity_error' => form_error($this->form_fields['forgot_password'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'btn_forgot_password' => form_submit( 'submit', lang('btn_forgot_password'), 'class="btn btn-primary"'),
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {

            // Get identity.
            if($this->config->item('identity', 'ion_auth') == 'username')
            {
                $identity = $this->ion_auth->where('username', strtolower($this->input->post('identity')))->users()->row();
            } else {
                $identity = $this->ion_auth->where('email', strtolower($this->input->post('identity')))->users()->row();
            }

            if(empty($identity))
            {
                if($this->config->item('identity', 'ion_auth') == 'username')
                {
                    $this->ion_auth->set_message('forgot_password_username_not_found');
                } else {
                    $this->ion_auth->set_message('forgot_password_email_not_found');
                }

                // Create a message.
                $this->messageci->set( $this->ion_auth->messages(), 'info');

                // Redirect.
                redirect( site_url('users/forgot_password'), 'refresh');
            }

            // Run the forgotten password method to email a activation code to the user.
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if($forgotten)
            {
                // Create a message.
                $this->messageci->set( $this->ion_auth->messages(), 'success');

                // Redirect.
                redirect( site_url('users/login'), 'refresh');
            } else {
                // Create a message.
                $this->messageci->set( $this->ion_auth->errors(), 'refresh');

                // Redirect.
                redirect( site_url('users/forgot_password'), 'refresh');
            }
        }
    }

    /**
     * Reset Password
     *
     * Final step in the reset password function.
     *
     * @param       integer      $code
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function reset_password($code = NULL)
    {
        if(!$code)
        {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if($user)
        {
            // If the code is valid, show the reset password form.
            $this->form_validation->set_rules('new_password', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[confirm_new_password]');
            $this->form_validation->set_rules('confirm_new_password', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if($this->form_validation->run() === FALSE)
            {
                // Define the page title.
                $data['title'] = lang('tle_reset_password');

                // Define the page template.
                $data['template'] = 'pages/users/reset_password';

                // Build the page breadcrumbs.
                $this->crumbs->add( lang('crumb_users'), 'users');
                $this->crumbs->add( lang('crumb_reset_password') );

                $data['page'] = array(
                    // Form Data.
                    'form_open' => form_open( site_url('users/reset_password/'.$code) ),
                    'form_close' => form_close(),
                    // Fields.
                    'new_password_field' => form_input( $this->form_fields['reset_password'][0], set_value( $this->form_fields['reset_password'][0]['name'], $this->input->post('new_password') ) ),
                    'confirm_new_password_field' => form_input( $this->form_fields['reset_password'][1], set_value( $this->form_fields['reset_password'][1]['name'], $this->input->post('confirm_new_password') ) ),
                    // Labels.
                    'new_password_label' => form_label( lang('lbl_new_password'), $this->form_fields['reset_password'][0]['id'] ),
                    'confirm_new_password_label' => form_label( lang('lbl_confirm_password'), $this->form_fields['reset_password'][1]['id'] ),
                    // Errors.
                    'new_password_error' => form_error($this->form_fields['reset_password'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                    'confirm_new_password_error' => form_error($this->form_fields['reset_password'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                    // Hidden.
                    'user_id_hidden_field' => form_hidden('user_id', $user->id),
                    'csrf_hidden_field' => form_hidden($this->_get_csrf_nonce()),
                    // Buttons.
                    'btn_reset_password' => form_submit( 'submit', lang('btn_reset_password'), 'class="btn btn-primary"'),
                    'breadcrumbs' => $this->crumbs->output(),
                );

                $this->render( element('page', $data), element('title', $data), element('template', $data) );
            }
            else
            {
                // Do we have a valid request.
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
                {
                    // Something is not right.
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error(lang('error_csrf'));
                }
                else
                {
                    // Change the password.
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new_password'));

                    if($change)
                    {
                        // Create a message.
                        $this->messageci->set( $this->ion_auth->messages(), 'success');

                        // Redirect.
                        redirect( site_url('users/login'), 'refresh');
                    } else {
                        // Create a message.
                        $this->messageci->set( $this->ion_auth->errors(), 'error');

                        // Redirect.
                        redirect( site_url('users/reset_password/'.$code), 'refresh');
                    }
                }
            }
        }
        else
        {
            // If the code is invalid, send them back to the forgot password page.
            $this->messageci->set( $this->ion_auth->errors(), 'error');

            // Redirect.
            redirect( site_url('users/forgot_password'), 'refresh');
        }
    }

    /**
     * Settings
     *
     * Allows the user to change their personal settings.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function settings()
    {

    }

    /**
     * Profile
     *
     * Allows the user to view their profile.
     *
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function profile()
    {

    }

    function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);
        return array($key => $value);
    }

    function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
