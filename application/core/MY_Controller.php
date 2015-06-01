<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

    public $version = '0.0.1';

    /**
     * Construct Functions
     *
     * This function is the construct.
     *
     * @author Chris Baines
     * @since 0.0.1
     */
    public function __construct()
    {
        parent::__construct();

        // Load Models.
        $this->load->model('forums_m', 'forums');

        // Load libraries.
		$this->load->database();
        $this->load->library(array('session', 'parser', 'messageci', 'ion_auth', 'crumbs', 'form_validation', 'gravatar', 'pagination', 'table', 'user_agent', 'settings'));

        // Load Language Files.
        $this->lang->load('messages', 'english');
        $this->lang->load('buttons', 'english');
        $this->lang->load('rules', 'english');
        $this->lang->load('tables', 'english');
        $this->lang->load('auth', 'english');

        //$this->output->enable_profiler(TRUE);

    }
}

class Front_Controller extends MY_Controller{

    private $theme;
    private $site_name;
    public $tables = array();

    public function __construct()
    {
        parent::__construct();

        $this->theme = $this->config->item('theme');
        $this->site_name = $this->config->item('site_name');
        $this->tables = $this->config->item('tables');
    }

    /**
     * Render
     *
     * This function is for the template system,
     * it takes all the templates and renders
     * them to the browser.
     *
     * @author Chris Baines
     * @since 0.0.1
     */
    public function render( $page_data=array(), $page_title, $page_template )
    {
        // Get the categories for the sidebar.
        $categories = $this->forums->get_categories();

        if( !empty($categories) )
        {
            foreach( $categories as $row )
            {
                $data['categories'][] = array(
                        'name' => anchor( site_url('categories/'.$row->category_slug.''), $row->name ),
                        'discussion_count' => $row->discussion_count,
                );
            }

            array_unshift( $data['categories'], array('name' => anchor( site_url('categories'), 'All Categories'), 'discussion_count' => $this->forums->count_discussions() ) );
        } else {
            $data['categories'] = array(
                array(
                    'name' => 'No Categories',
                    'discussion_count' => 0,
                ),
            );
        }
        // Build the template data array.
        $data = array(
            // Navigation.
            'navigation' => array(
                'links' => array(
                    array( 'link' => anchor( site_url(), 'Discussions' ) ),
                ),
                'logo' => anchor( site_url(), $this->site_name, array( 'class' => 'navbar-brand' ) ),
                'username' => ucfirst( $this->session->userdata('username') ),
                'logout_link' => anchor( site_url( 'users/logout' ), 'Logout' ),
                'profile_link' => anchor( site_url( 'users/profile' ), 'Profile' ),
                'settings_link' => anchor( site_url( 'users/settings' ), 'Settings' ),
                'change_password_link' => anchor (site_url( 'users/change_password' ), 'Change Password'),
                'dashboard_link' => anchor( site_url( 'dashboard' ), 'Dashboard' ),
                'login_link' => anchor( site_url( 'users/login' ), 'Login' ),
                'register_link' => anchor( site_url( 'users/register' ), 'Register' ),
            ),
            // Sidebar.
            'sidebar' => array(
                'new_discussion_button' => anchor( site_url('discussions/new_discussion'), 'New Discussion', array( 'class' => 'btn btn-success btn-sm' )),
                'categories' => element( 'categories', $data ),
            ),
            // Footer.
            'footer' => array(
                'copy_text' => 'Powered By '.anchor( 'http://www.doveforums.com', 'Dove Forums').' &copy; 2011 - 2015 - Version '.$this->version,
            ),
        );

        // Define the template regions.
        $data['templates'] = array(
            'doctype' => doctype('html5'),
            'css' => array(
                array( 'link' => '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">' ),
                array( 'link' => '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">' ),
                array( 'link' => '<link href="'.base_url('templates/'.$this->theme.'/assets/css/custom.css').'", rel="stylesheet">' ),
                array( 'link' => '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">' ),
                array( 'link' => '<link href="'.base_url('templates//'.$this->theme.'/assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css').'" rel="stylesheet" type="text/css" />')
            ),
            'meta' => array(
                array( 'meta' => meta('keywords', $this->config->item('site_keywords')) ),
                array( 'meta' => meta('description', $this->config->item('site_description')) ),
            ),
            'js' => array(
                array( 'script' => '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>' ),
                array( 'script' => '<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>' ),
                array( 'script' => '<script src="'.base_url('templates/'.$this->theme.'/assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js').'" type="text/javascript"></script>' ),
                array( 'script' => '<script src="'.base_url('templates/'.$this->theme.'/assets/js/forums.js').'"></script>' ),
            ),
            // Page Title.
            'title' => ''.$this->site_name.' - '.$page_title.'',
            // Navigation.
            'navigation' => $this->parser->parse( 'templates/'.$this->theme.'/regions/navigation', element( 'navigation', $data ), TRUE ),
            // Sidebar.
            'sidebar' => $this->parser->parse( 'templates/'.$this->theme.'/regions/sidebar', element( 'sidebar', $data ), TRUE ),
            // Content.
            'content' => $this->parser->parse( 'templates/'.$this->theme.'/'.$page_template.'', $page_data, TRUE ),
            // Footer.
            'footer' => $this->parser->parse( 'templates/'.$this->theme.'/regions/footer', element( 'footer', $data ), TRUE ),
        );

        // Send all the data to the layout file.
        $this->parser->parse( 'templates/'.$this->theme.'/layout', element( 'templates', $data ) );
    }
}

class Admin_Controller extends Front_Controller {

    private $admin_theme;
    private $site_name;
    public $tables = array();

    public function __construct()
    {
        parent::__construct();

        $this->admin_theme      = $this->config->item('admin_theme');
        $this->site_name        = $this->config->item('site_name');
        $this->tables           = $this->config->item('tables');

        // Check if the user is a admin.
        if (!$this->ion_auth->is_admin())
        {
            // Create a message.
            $this->messageci->set( lang('error_admin_required'), 'error');

            // Redirect.
            redirect( site_url(), 'refresh');
        }
    }

    /**
     * Render
     *
     * This function is for the template system,
     * it takes all the templates and renders
     * them to the browser.
     *
     * @author Chris Baines
     * @since 0.0.1
     */
    public function render( $page_data=array(), $page_title, $page_template )
    {
        // Build the template data array.
        $data = array(
            // Navigation.
            'navigation' => array(
                'links' => array(
                    array('link' => anchor(site_url(), 'Discussions')),
                ),
                'logo' => anchor(site_url(), $this->site_name, array('class' => 'navbar-brand')),
                'username' => ucfirst($this->session->userdata('username')),
                'logout_link' => anchor(site_url('users/logout'), 'Logout'),
                'profile_link' => anchor(site_url('users/profile'), 'Profile'),
                'settings_link' => anchor(site_url('users/settings'), 'Settings'),
                'dashboard_link' => anchor(site_url('dashboard'), 'Dashboard'),
                'login_link' => anchor(site_url('users/login'), 'Login'),
                'register_link' => anchor(site_url('users/register'), 'Register'),
            ),
            // Sidebar.
            'sidebar' => array(
                'all_users' => anchor( site_url('dashboard/all_users'), 'All Users'),
                'add_user' => anchor( site_url('dashboard/add_user'), 'Add User'),
                'all_categories' => anchor( site_url('dashboard/all_categories'), 'All Categories'),
                'add_category' => anchor( site_url('dashboard/add_category'), 'Add Category'),
                'all_discussions' => anchor( site_url('dashboard/all_discussions'), 'All Discussions'),
                'all_groups' => anchor( site_url('dashboard/all_groups'), 'All Groups'),
                'add_group' => anchor( site_url('dashboard/add_group'), 'Add Group'),
                'all_settings' => anchor( site_url('dashboard/settings'), 'Settings'),
            ),
            // Footer.
            'footer' => array(
                'copy_text' => 'Powered By ' . anchor('http://www.doveforums.com', 'Dove Forums') . ', &copy; 2011 - 2015.',
            ),
        );

        // Define the template regions.
        $data['templates'] = array(
            'doctype' => doctype('html5'),
            'css' => array(
                array('link' => '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">'),
                array('link' => '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">'),
                array('link' => '<link href="' . base_url('templates/' . $this->admin_theme . '/assets/css/custom.css') . '", rel="stylesheet">'),
                array( 'link' => '<link href="'.base_url('templates//'.$this->admin_theme.'/assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css').'" rel="stylesheet" type="text/css" />')
            ),
            'meta' => array(
                array('meta' => meta('keywords', $this->config->item('keywords'))),
            ),
            'js' => array(
                array('script' => '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>'),
                array('script' => '<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>'),
                array( 'script' => '<script src="'.base_url('templates/'.$this->admin_theme.'/assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js').'" type="text/javascript"></script>' ),
                array('script' => '<script src="' . base_url('templates/' . $this->admin_theme . '/assets/js/forums.js') . '"></script>'),
            ),
            // Page Title.
            'title' => '' . $this->site_name . ' - ' . $page_title . '',
            // Navigation.
            'navigation' => $this->parser->parse('templates/' . $this->admin_theme . '/regions/navigation', element('navigation', $data), TRUE),
            // Sidebar.
            'sidebar' => $this->parser->parse('templates/' . $this->admin_theme . '/regions/admin_sidebar', element('sidebar', $data), TRUE),
            // Content.
            'content' => $this->parser->parse('templates/' . $this->admin_theme . '/' . $page_template . '', $page_data, TRUE),
            // Footer.
            'footer' => $this->parser->parse('templates/' . $this->admin_theme . '/regions/footer', element('footer', $data), TRUE),
        );

        // Send all the data to the layout file.
        $this->parser->parse('templates/' . $this->admin_theme . '/layout', element('templates', $data));
    }
}
