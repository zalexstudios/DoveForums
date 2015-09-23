<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Front_Controller {

    private $validation_rules = array(
        'login' => array(
            //0
            array(
                'field' => 'email',
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
            //3
            array(
                'field' => 'g-recaptcha-response',
                'rules' => 'required',
                'label' => 'lang:rules_captcha',
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
        'settings' => array(
            //0
            array(
                'field' => 'email',
                'rules' => 'required|valid_email',
                'label' => 'lang:rules_email',
            ),
        ),
    );

    private $form_fields = array(
        'login' => array(
            //0
            array(
                'id' => 'email',
                'name' => 'email',
                'class' => 'form-control',
                'type' => 'email',
                'placeholder' => 'Email',
                'tabindex' => 1,
                'autocomplete' => 'email',
            ),
            //1
            array(
                'id' => 'password',
                'name' => 'password',
                'class' => 'form-control',
                'type' => 'password',
                'tabindex' => 2,
            ),
        ),
        'register' => array(
            //0
            array(
                'id' => 'username',
                'name' => 'username',
                'class' => 'form-control',
                'type' => 'text',
                'tabindex' => 1,
                'placeholder' => 'Username'
            ),
            //1
            array(
                'id' => 'email',
                'name' => 'email',
                'class' => 'form-control',
                'type' => 'email',
                'tabindex' => 2,
                'autocomplete' => 'email',
                'placeholder' => 'Email'
            ),
            //2
            array(
                'id' => 'password',
                'name' => 'password',
                'class' => 'form-control',
                'type' => 'password',
                'tabindex' => 3,
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
        'settings' => array(
            //0
            array(
                'id' => 'email',
                'name' => 'email',
                'class' => 'form-control',
                'type' => 'email',
            ),
            //1
            array(
                'id' => 'first_name',
                'name' => 'first_name',
                'class' => 'form-control',
                'type' => 'text',
            ),
            //2
            array(
                'id' => 'last_name',
                'name' => 'last_name',
                'class' => 'form-control',
                'type' => 'text',
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
                'email_field' => form_input( $this->form_fields['register'][1], set_value( $this->form_fields['register'][1]['name'], $this->input->post('email') ) ),
                'password_field' => form_input( $this->form_fields['register'][2], set_value( $this->form_fields['register'][2]['name'], $this->input->post('password') ) ),
                'recaptcha_field' => $this->recaptcha->render(),
                // Labels.
                'username_label' => form_label( lang('lbl_username'), $this->form_fields['register'][0]['id']),
                'email_label' => form_label( lang('lbl_email'), $this->form_fields['register'][1]['id']),
                'password_label' => form_label( lang('lbl_password'), $this->form_fields['register'][2]['id']),
                // Errors.
                'username_error' => form_error($this->form_fields['register'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'email_error' => form_error($this->form_fields['register'][1]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                'password_error' => form_error($this->form_fields['register'][2]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'register_button' => form_submit('submit', lang('btn_register'), 'class="btn btn-primary btn-sm"'),
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {
            // Catch the user's answer
            $captcha_answer = $this->input->post('g-recaptcha-response');

            // Verify user's answer
            $response = $this->recaptcha->verifyResponse($captcha_answer);

            if($response['success'])
            {
                // The form has been submitted, sanitize the data.
                $username = strip_tags( $this->security->xss_clean( $this->input->post('username') ) );
                $password = strip_tags( $this->security->xss_clean( $this->input->post('password') ) );
                $email = strip_tags( $this->security->xss_clean( $this->input->post('email') ) );

                // Perform the registration.
                $register = $this->ion_auth->register($username, $password, $email);

                if($register)
                {
                    // Create success message.
                    $this->messageci->set( $this->ion_auth->messages(), 'success' );

                    // See if the admin wants to receive these emails.
                    if($this->config->item('notify_new_registration') == 1)
                    {
                        // Get the user.
                        $user = $this->users->get_by(array('id' => $register));

                        // Email the sites admin.
                        $data['email'] = array(
                            'username' => $user->username,
                            'subject' => lang('txt_new_user'),
                            'user' => anchor( site_url('users/profile/'.$user->id), 'Here'),
                            'site_author' => $this->site_author,
                            'site_name' => $this->site_name,
                        );

                        $this->send_email($this->config->item('site_email'), 'default/emails/new_user', element('email', $data));

                    }

                } else {
                    // Create error message.
                    $this->messageci->set( $this->ion_auth->errors(), 'error' );
                }
            } else
            {
                $this->messageci->set( lang('error_captcha'), 'error' );
            }

            // Redirect.
            redirect( site_url('users/login') );
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
                'identity_field' => form_input( $this->form_fields['login'][0], set_value( $this->form_fields['login'][0]['name'], $this->input->post('email') ) ),
                'password_field' => form_input( $this->form_fields['login'][1] ),
                // Labels.
                'identity_label' => form_label( lang('lbl_email'), $this->form_fields['login'][0]['id'] ),
                'password_label' => form_label( lang('lbl_password'), $this->form_fields['login'][1]['id'] ),
                // Buttons.
                'btn_login' => form_submit( 'submit', lang('btn_login'), 'class="btn btn-primary btn-sm"'),
                'btn_forgot_password' => anchor( site_url('users/forgot_password'), lang('btn_forgot_password'), array('class' => 'btn btn-danger btn-sm')),
                // Other
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {

            // Form has been submitted, sanitize the data.
            $identity = strip_tags( $this->security->xss_clean( $this->input->post('email') ) );
            $password = strip_tags( $this->security->xss_clean( $this->input->post('password') ) );

            // Perform the login.
            $login = $this->ion_auth->login($identity, $password);

            if($login === TRUE)
            {
                // Update the users visit count.
                $user = $this->ion_auth->user()->row();

                // Get all new discussion since the users last login.
                $last_login = $this->session->userdata('old_last_login');

                if(!empty($last_login))
                {
                    $discussions = $this->discussions->get_many_by('last_comment > '.$last_login.'');
                } else {
                    $discussions = $this->discussions->get_many_by('last_comment > '.(time() - 30 * 24 * 3600).'');
                }

                if(!empty($discussions))
                {
                    foreach($discussions as $row)
                    {
                        $data['unread'][] = array(
                            'discussion_id' => $row->id,
                            'user_id' => $user->id,
                        );
                    }

                    $this->unread->insert_many(element('unread', $data));
                }

                $this->users->update($user->id, array('visit_count' => ++$user->visit_count));

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

        // Mark all the discussions as read.
        $this->unread->mark_all();

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
     * @param       integer     $discussion_id
     * @param       integer     $comment_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function thumbs_up ($user_id, $discussion_id, $comment_id)
    {
        // Get the recipient.
        $recipient = $this->ion_auth->user($user_id)->row();

        // Get the giver.
        $giver = $this->ion_auth->user($this->session->userdata('user_id'))->row();

        // Check that the user is not giving themselves a thumbs up.
        if($recipient->id == $giver->id)
        {
            // Create a error message.
            $this->messageci->set( lang('error_thumb_self'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Check the giver has not already given a thumbs up to this user for this comment.
        $check = $this->thumbs->get_by(array('discussion_id' => $discussion_id, 'comment_id' => $comment_id, 'recipient_user_id' => $recipient->id, 'giver_user_id' => $giver->id));

        if($check)
        {
            // Create a error message.
            $this->messageci->set( lang('error_already_thumbed'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Get the recipients points.
        $points = $recipient->points;

        // Build the data.
        $data = array(
            'discussion_id' => $discussion_id,
            'comment_id' => $comment_id,
            'recipient_user_id' => $recipient->id,
            'recipient_username' => $recipient->username,
            'giver_user_id' => $giver->id,
            'giver_username' => $giver->username,
            'given' => now(),
        );

        $insert = $this->thumbs->insert($data);

        if($insert)
        {
            // Give the user points.
            $data = array(
                'points' => $points+5,
            );

            $this->users->update($recipient->id, $data);

            // Create success message.
            $this->messageci->set( sprintf(lang('success_thumb_up'), $recipient->username), 'success');
        }
        else
        {
            // Create a error message.
            $this->messageci->set( sprintf(lang('error_thumb_up'), $recipient->username), 'error');
        }

        // Redirect.
        redirect( $this->agent->referrer(), 'refresh');
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
        // Check if the user has permission.
        if(!$this->permission->has_permission('change_password'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }
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
        // Check if the user has permission.
        if(!$this->permission->has_permission('edit_user_settings'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Set the form validation rules.
        $this->form_validation->set_rules( $this->validation_rules['settings'] );

        // See if the form validation has been run.
        if ( $this->form_validation->run() === FALSE )
        {
            // Define the page title.
            $data['title'] = lang('tle_settings');

            // Define the page template.
            $data['template'] = 'pages/users/settings';

            // Build the breadcrumbs.
            $this->crumbs->add( lang('crumb_users'), 'users');
            $this->crumbs->add( lang('crumb_settings') );

            // Get all the languages.
            $languages = $this->language->get_all();

            // Build the languages dropdown.
            if(!empty($languages))
            {
                foreach($languages as $row)
                {
                    $language_options[$row->code] = $row->language;
                }
            }

            // Get the user.
            $user = $this->ion_auth->user()->row();

            // Define the page data.
            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('users/settings') ),
                'form_close' => form_close(),
                // Fields.
                'email_field' => form_input( $this->form_fields['settings'][0], set_value( $this->form_fields['settings'][0]['name'], $user->email ) ),
                'first_name_field' => form_input( $this->form_fields['settings'][1], set_value( $this->form_fields['settings'][1]['name'], $user->first_name ) ),
                'last_name_field' => form_input( $this->form_fields['settings'][2], set_value( $this->form_fields['settings'][2]['name'], $user->last_name ) ),
                'language_field' => form_dropdown('language', $language_options, $user->language, 'class="form-control"'),
                'notify_of_replies_field' => form_checkbox('notify_of_replies', 1, set_value('notify_of_replies', $user->notify_of_replies)),
                // Labels.
                'email_label' => form_label( lang('lbl_email'), $this->form_fields['settings'][0]['id']),
                'first_name_label' => form_label( lang('lbl_first_name'), $this->form_fields['settings'][1]['id']),
                'last_name_label' => form_label( lang('lbl_last_name'), $this->form_fields['settings'][2]['id']),
                'language_label' => form_label(lang('lbl_language'), 'language'),
                // Errors.
                'email_error' => form_error($this->form_fields['change_password'][0]['name'], '<p class="text-danger"><i class="fa fa-exclamation-triangle"></i> ', '</p>'),
                // Buttons.
                'btn_update_settings' => form_submit('submit', lang('btn_update_settings'), 'class="btn btn-primary btn-sm"'),
                'breadcrumbs' => $this->crumbs->output(),
            );

            $this->render( element('page', $data), element('title', $data), element('template', $data) );
        }
        else
        {
            // Gather the data.
            $data = array(
                'email' => $this->input->post('email'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'language' => $this->input->post('language'),
                'notify_of_replies' => $this->input->post('notify_of_replies'),
            );

            $update = $this->ion_auth->update($this->session->userdata('user_id'), $data);

            if($update)
            {
                // Create a message.
                $this->messageci->set( $this->ion_auth->messages(), 'success');

                // Logout.
                redirect( site_url('users/settings'), 'refresh');
            } else {
                // Create a message.
                $this->messageci->set( $this->ion_auth->errors(), 'error');

                // Redirect.
                redirect( site_url('users/settings'), 'refresh');
            }
        }
    }

    /**
     * Profile
     *
     * Allows the user to view their profile.
     *
     * @param       integer     $user_id
     * @author      Chris Baines
     * @since       0.2.0
     */
    public function profile($user_id=NULL)
    {
        // Check if the user has permission.
        if(!$this->permission->has_permission('view_profile'))
        {
            // Create a message.
            $this->messageci->set( lang('error_permission_required'), 'error');

            // Redirect.
            redirect( $this->agent->referrer(), 'refresh');
        }

        // Check if a user is logged in, otherwise load the achievements library.
        if($this->ion_auth->logged_in() === FALSE)
        {
            $config['user_id'] = $user_id;
            $this->load->library('achievements', $config);
        }

        // Get the users achievements.
        $achievements = $this->achievements->get_user_achievements();

        if(!empty($achievements))
        {
            foreach($achievements as $row)
            {
                $data['achievements'][] = array(
                    'name' => $row->name,
                    'description' => $row->description,
                    'points' => $row->points,
                );
            }
        }

        // Get the users thumbs.
        $thumbs = $this->thumbs->get_many_by('recipient_user_id', $user_id);

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            '',
            lang('tbl_in_discussion'),
            lang('tbl_given_by'),
            lang('tbl_date'),
            lang('tbl_for_comment')
        );

        if(!empty($thumbs))
        {

            foreach($thumbs as $thumb)
            {
                // Get the discussion.
                $discussion = $this->discussions->get_by('id', $thumb->discussion_id);

                // Get the givers user details.
                $user = $this->ion_auth->user($thumb->giver_user_id)->row();

                // Build the givers avatar.
                $data['avatar'] = array(
                    'src' => $this->gravatar->get_gravatar($user->email, $this->config->item('gravatar_rating'), 20, $this->config->item('gravatar_default_image') ),
                );

                $this->table->add_row(
                    img(element('avatar', $data)),
                    anchor( site_url('discussions/view/'.$thumb->discussion_id), $discussion->subject),
                    anchor( site_url('users/profile/'.$thumb->giver_user_id), ucwords($thumb->giver_username)),
                    unix_to_human($thumb->given),
                    anchor( site_url('discussions/view/'.$thumb->discussion_id.'/#'.$thumb->comment_id), 'View')
                );
            }
        }

        // Get the user from the database.
        if(!$user_id)
        {
            $user = $this->ion_auth->user()->row();
        } else {
            $user = $this->ion_auth->user($user_id)->row();
        }

        // Define the page title.
        $data['title'] = sprintf(lang('tle_profile'), $user->username);

        // Define the page template.
        $data['template'] = 'pages/users/profile';

        // Build the page breadcrumbs.
        $this->crumbs->add( lang('crumb_users'), 'users');
        $this->crumbs->add( sprintf(lang('crumb_profile'), $user->username ));

        // Build the discussion starters avatar.
        $data['avatar'] = array(
            'src' => $this->gravatar->get_gravatar($user->email, $this->config->item('gravatar_rating'), 100, $this->config->item('gravatar_default_image') ),
            'class' => 'media-object img-circle center-block'
        );

        $data['page'] = array(
            // User data.
            'username' => $user->username,
            'joined' => timespan($user->created_on, time()),
            'last_visit' => timespan($user->last_login, time()),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'points' => $user->points,
            'avatar' => img( element('avatar', $data ) ),
            'total_discussions' => $this->discussions->count_by('poster', $user->username),
            'total_comments' => $this->comments->count_by('poster_id', $user->id),
            'online' => ($this->users->user_online($user->id) == TRUE ? '<i class="fa fa-circle online" title="'.lang('txt_online').'"></i>' : '<i class="fa fa-circle offline" title="'.lang('txt_offline').'"></i>'),
            // Achievements.
            'achievements' => element( 'achievements', $data ),
            'tbl_thumbs' => $this->table->generate(),
            'has_achievements' =>  (!empty($achievements)) ? 1 : 0,
            // Buttons.
            'btn_send_pm' => anchor( site_url('messages/send/'.$user->id.''), lang('btn_pm'), array('class' => 'btn btn-default btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => lang('tip_send_user_pm'))),
            'btn_login' => form_submit( 'submit', lang('btn_login'), 'class="btn btn-primary"'),
            'btn_forgot_password' => anchor( site_url('users/forgot_password'), lang('btn_forgot_password'), array('class' => 'btn btn-danger')),
            // Other
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
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
