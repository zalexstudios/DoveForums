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
    );

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

                $this->users->update(array('visit_count' => ++$user->visit_count), $user->id);

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