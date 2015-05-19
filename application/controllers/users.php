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
    );

    private $form_fields = array(
        'login' => array(
            //0
            array(
                'id' => 'email',
                'name' => 'email',
                'class' => 'form-control',
                'type' => 'text',
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
                'type' => 'text',
            ),
            //4
            array(
                'id' => 'confirm_email',
                'name' => 'confirm_email',
                'class' => 'form-control',
                'type' => 'text',
            ),
        ),
    );

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
            $data['title'] = 'Register';

            // Define the page template.
            $data['template'] = 'pages/users/register';

            // Build the breadcrumbs.
            $this->crumbs->add('Users', 'users');
            $this->crumbs->add('Register');

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
                'username_label' => form_label('Username:', $this->form_fields['register'][0]['id']),
                'password_label' => form_label('Password:', $this->form_fields['register'][1]['id']),
                'confirm_password_label' => form_label('Confirm Password:', $this->form_fields['register'][2]['id']),
                'email_label' => form_label('Email:', $this->form_fields['register'][3]['id']),
                'confirm_email_label' => form_label('Confirm Email:', $this->form_fields['register'][4]['id']),
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
                $this->messageci->set( lang('register_success'), 'success' );

                // Redirect.
                redirect( site_url('forums') );
            } else {

                // Create a message.
                $this->messageci->set( lang('register_error'), 'error' );

                // Redirect.
                redirect( site_url('forums') );
            }
        }
    }

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
            $data['title'] = 'Login';

            // Define the page template.
            $data['template'] = 'pages/users/login';

            // Build the page breadcrumbs.
            $this->crumbs->add('Users', 'users');
            $this->crumbs->add('Login');

            $data['page'] = array(
                // Form Data.
                'form_open' => form_open( site_url('users/login') ),
                'form_close' => form_close(),
                // Fields.
                'email_field' => form_input( $this->form_fields['login'][0], set_value( $this->form_fields['login'][0]['name'], $this->input->post('email') ) ),
                'password_field' => form_input( $this->form_fields['login'][1] ),
                // Labels.
                'email_label' => form_label( 'Email:', $this->form_fields['login'][0]['id'] ),
                'password_label' => form_label( 'Password:', $this->form_fields['login'][1]['id'] ),
                // Buttons.
                'login_button' => form_submit( 'submit', 'Login', 'class="btn btn-primary"'),
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

                $this->forums->update_visit_count($user->id, ++$user->visit_count);

                // Create a message.
                $this->messageci->set( lang('success_login'), 'success' );

                // Redirect.
                redirect( site_url('forums') );
            } else {

                // Create a message.
                $this->messageci->set( lang('error_login'), 'error' );

                // Redirect.
                redirect( site_url('users/login') );
            }
        }
    }

    public function logout()
    {
        $this->ion_auth->logout();

        // Create a message.
        $this->messageci->set( lang('success_logout'), 'success' );

        // Redirect.
        redirect( site_url('forums') );
    }
}