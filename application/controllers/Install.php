<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load the install model.
        $this->load->model('install_m', 'install');

        // Load some helpers.
        $this->load->helper(array('form', 'cookie', 'url'));

        // Load some libraries.
        $this->load->library(array('form_validation', 'session', 'messageci'));
    }

    public function index()
    {
       // Set some validation rules.
        $this->form_validation->set_rules('first_iteration', 'First Iteration', 'trim|required|alpha_dash|max_length[64]');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('install/header');
            $this->load->view('install/tables');
            $this->load->view('install/footer');
        }
        else
        {
            if ($this->install->create_tables() === TRUE)
            {
                // Everything ok, proceed to the next step.
                redirect( site_url('install/site_settings') );
            }
            else
            {
                // Create a message.
                $this->messageci->set('There was a problem generating the database tables, please try again.');

                // Redirect.
                redirect( site_url('install/create_tables') );
            }
        }
    }

    public function site_settings()
    {

        // Delete the cookie created earlier.
        if(isset($_COOKIE['db_name']))
        {
            setcookie('db_name', '', time() - 3600);
        }

        // Set some validation rules.
        $this->form_validation->set_rules('base_url', 'Base Url', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('site_title', 'Site Title', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('encryption_key', 'Encryption Key', 'required|min_length[32]');
        $this->form_validation->set_rules('admin_username', 'Admin Username', 'trim|required|alpha_dash|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('admin_password', 'Admin Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('admin_password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[admin_password]');
        $this->form_validation->set_rules('admin_email', 'Admin Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('install/header');
            $this->load->view('install/settings');
            $this->load->view('install/footer');

        }
        else
        {
            // Load Ion Auth.
            $this->load->library('ion_auth');

            // Gather the data.
            $base_url = $this->input->post('base_url');
            $site_title = addslashes($this->input->post('site_title'));
            $encryption_key = $this->input->post('encryption_key');
            $username = $this->input->post('admin_username');
            $password = $this->input->post('admin_password');
            $email = $this->input->post('admin_email');
            $group = array('1');
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
            );

            // Create the admin user.
            if ($this->ion_auth->register($username, $password, $email, $additional_data, $group) === FALSE )
            {
                // Create a message.
                $this->messageci->set('There was a problem creating the admin user, please try again!.');

                // Redirect
                redirect( site_url('install/site_settings') );
            }
            else
            {
                // Set the site email settings.
                $find = '$config[\'site_email\'] =';
                $replace = '$config[\'site_email\'] = \''.$email.'\';'."\n";

                if ($this->install->edit_forum_config($find, $replace) !== TRUE)
                {
                    // Create a message.
                    $this->messageci->set('The Forum email address in your forums.php config file cannot be replaced.', 'error');

                    // Redirect.
                    redirect( site_url('install/site_settings') );
                }

                // Change the session driver.
                $find = '$config[\'sess_driver\'] =';
                $replace = '$config[\'sess_driver\'] = \'' . 'database' . '\';' . "\n";

                if ($this->install->edit_main_config($find, $replace) !== TRUE)
                {
                    // Create a message.
                    $this->messageci->set('The session driver in your main config.php file cannot be replaced.', 'error');

                    // Redirect.
                    redirect( site_url('install/site_settings') );
                }

                // Change session path.
                $find = '$config[\'sess_save_path\'] = ';
                $replace = '$config[\'sess_save_path\'] = \'' . 'ci_sessions' . '\';' . "\n";

                if ($this->install->edit_main_config($find, $replace) !== TRUE)
                {
                    // Create a message.
                    $this->messageci->set('The session path in your main config.php file cannot be replaced.', 'error');

                    // Redirect.
                    redirect( site_url('install/site_settings') );
                }

                // Replace base_url.
                $find = '$config[\'base_url\'] =';
                $replace = '$config[\'base_url\'] = \'' . $base_url . '\';' . "\n";

                if ($this->install->edit_main_config($find, $replace) !== TRUE)
                {
                    // Create a message.
                    $this->messageci->set('The base url in the your main config.php file cannot be replaced.', 'error');

                    // Redirect.
                    redirect( site_url('install/site_settings') );
                }

                // Replace the encryption key.
                $find = '$config[\'encryption_key\'] =';
                $replace = '$config[\'encryption_key\'] = \'' . $encryption_key . '\';' . "\n";

                if ($this->install->edit_main_config($find, $replace) !== TRUE)
                {
                    // Create a message.
                    $this->messageci->set('The encryption key in the your main config.php file cannot be replaced.', 'error');

                    // Redirect.
                    redirect( site_url('install/site_settings') );
                }

                // Replace site name.
                $find = '$config[\'site_name\'] =';
                $replace = '$config[\'site_name\'] = \'' . $site_title . '\';' . "\n";

                if ($this->install->edit_forum_config($find, $replace) !== TRUE)
                {
                    // Create a message.
                    $this->messageci->set('The site name in your forum.php config file cannot be replaced.', 'error');

                    // Redirect.
                    redirect( site_url('install/site_settings') );
                }

                // Replace the default route.
                $find = '$route[\'default_controller\'] =';
                $replace = '$route[\'default_controller\'] = \'' . 'forums' . '\';' . "\n";

                if ($this->install->edit_routes_config($find, $replace) !== TRUE)
                {
                    // Create a message.
                    $this->messageci->set('The default route in your routes.php file cannot be replaced.', 'error');

                    // Redirect.
                    redirect( site_url('install/site_settings') );
                }

                // Everything ok, go to the final step.
                redirect( site_url('install/complete') );
            }
        }

    }

    public function complete()
    {
        $this->load->view('install/header');
        $this->load->view('install/finish');
        $this->load->view('install/footer');
    }

    public function delete_files()
    {
        if ($this->install->delete_files())
        {
            redirect( site_url() );
        }
        else
        {
            echo 'Unable to delete installation files, please do it manually.';
        }
    }

}