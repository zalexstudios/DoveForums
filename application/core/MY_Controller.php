<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

    public $version = '0.4.0';

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

        $this->load->database();

        // Load Models.
        //$this->load->model('forums_m', 'forums');
        $this->load->model('discussion_m', 'discussions');
        $this->load->model('category_m', 'categories');
        $this->load->model('comment_m', 'comments');
        $this->load->model('user_m', 'users');
        $this->load->model('language_m', 'language');
        $this->load->model('report_m', 'reports');
        $this->load->model('theme_m', 'themes');

        // Load libraries.
        $this->load->library(array('session', 'parser', 'messageci', 'ion_auth', 'crumbs', 'form_validation', 'gravatar', 'pagination', 'table', 'user_agent', 'settings'));

        // See if a user is logged in, if so set their language preference.
        if ($this->ion_auth->logged_in() === TRUE)
        {
            $user = $this->ion_auth->user()->row();
            $groups = $this->ion_auth->get_users_groups()->result();
            $config['group_id'] = $groups[0]->id;

            // Load the permissions library, but only send the first group ID.
            $this->load->library('permission', $config);

            // Load the achievements library.
            $config['user_id'] = $this->session->userdata('user_id');
            $this->load->library('achievements', $config);

            $language = $user->language;
        } else {

            $config['group_id'] = 1;
            // Load the permissions library.
            $this->load->library('permission', $config);

            $language = $this->config->item('site_language');
        }

        // Load Language Files.
        $this->lang->load('forums', $language);
        $this->lang->load('auth', $language);

        // Override ion_auth default language loading.
        $this->lang->load('ion_auth', $language);
    }
}

class Front_Controller extends MY_Controller{

    private $theme;
    private $site_name;
    public $tables = array();

    public function __construct()
    {
        parent::__construct();

        $this->theme = $this->themes->get_by('name', $this->config->item('theme'));
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
        $categories = $this->categories->get_all();

        if( !empty($categories) )
        {
            foreach( $categories as $row )
            {
                $data['categories'][] = array(
                        'name' => anchor( site_url('categories/'.$row->slug.''), $row->name ),
                        'discussion_count' => $row->discussion_count,
                );
            }

            array_unshift( $data['categories'], array('name' => anchor( site_url('categories'), lang('lnk_all_categories')), 'discussion_count' => $this->discussions->count() ) );
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
                    array( 'link' => anchor( site_url('forums'), lang('lnk_discussions') ) ),
                ),
                'logo' => anchor( site_url(), $this->site_name, array( 'class' => 'navbar-brand' ) ),
                'username' => ucfirst( $this->session->userdata('username') ),
                'logout_link' => anchor( site_url( 'users/logout' ), lang('lnk_logout') ),
                'profile_link' => anchor( site_url( 'users/profile' ), lang('lnk_profile') ),
                'settings_link' => anchor( site_url( 'users/settings' ), lang('lnk_settings') ),
                'change_password_link' => anchor (site_url( 'users/change_password' ), lang('lnk_change_password') ),
                'dashboard_link' => anchor( site_url( 'dashboard' ), lang('lnk_dashboard') ),
                'login_link' => anchor( site_url( 'users/login' ), lang('lnk_login') ),
                'register_link' => anchor( site_url( 'users/register' ), lang('lnk_register') ),
            ),
            // Sidebar.
            'sidebar' => array(
                'categories' => element( 'categories', $data ),
            ),
            // Footer.
            'footer' => array(
                'copy_text' => 'Powered By '.anchor( 'http://www.doveforums.com', 'Dove Forums Lite').' &copy; 2011 - 2015 - Version '.$this->version,
            ),
        );

        // Define the template regions.
        $data['templates'] = array(
            'doctype' => doctype('html5'),
            'theme' => ($this->theme->name !== 'default' ? '<link href="'.$this->theme->url.'" rel="stylesheet">' : ''),
            'css' => array(
                array( 'link' => '<link href="'.base_url('themes/default/css/custom.css').'" rel="stylesheet">' ),
            ),
            'meta' => array(
                array( 'meta' => meta('keywords', $this->config->item('site_keywords')) ),
                array( 'meta' => meta('description', $this->config->item('site_description')) ),
            ),
            'js' => array(
                array( 'script' => '<script src="'.base_url('themes/default/js/plugins/ckeditor.js').'" type="text/javascript"></script>' ),
                array( 'script' => '<script src="'.base_url('themes/default/js/forums.js').'"></script>' ),
            ),
            // Page Title.
            'title' => ''.$this->site_name.' - '.$page_title.'',
            // Navigation.
            'navigation' => $this->parser->parse( 'default/sections/navigation', element( 'navigation', $data ), TRUE ),
            // Sidebar.
            'sidebar' => $this->parser->parse( 'default/sections/sidebar', element( 'sidebar', $data ), TRUE ),
            // Content.
            'content' => $this->parser->parse( 'default/'.$page_template.'', $page_data, TRUE ),
            // Footer.
            'footer' => $this->parser->parse( 'default/sections/footer', element( 'footer', $data ), TRUE ),
        );

        // Send all the data to the layout file.
        $this->parser->parse( 'default/layout', element( 'templates', $data ) );
    }
}

class Admin_Controller extends Front_Controller {

    private $admin_theme;
    private $site_name;
    public $tables = array();

    public function __construct()
    {
        parent::__construct();

        $this->admin_theme      = $this->themes->get_by('name', $this->config->item('admin_theme'));
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
        // See if any reports exist.
        $reports = $this->reports->count_by('zapped', NULL);

        // Build the template data array.
        $data = array(
            // Navigation.
            'navigation' => array(
                'links' => array(
                    array('link' => anchor(site_url('dashboard/categories'), lang('lnk_categories'))),
                    array('link' => anchor(site_url('dashboard/all_users'), lang('lnk_users'))),
                    array('link' => anchor(site_url('dashboard/all_groups'), lang('lnk_groups'))),
                    array('link' => anchor(site_url('dashboard/settings'), lang('lnk_settings'))),
                    array('link' => anchor(site_url('dashboard/achievements'), lang('lnk_achievements'))),
                ),
                'logo' => anchor(site_url(), $this->site_name, array('class' => 'navbar-brand')),
                'username' => ucfirst($this->session->userdata('username')),
                'logout_link' => anchor(site_url('users/logout'), lang('lnk_logout')),
                'home_link' => anchor(site_url('forums'), lang('lnk_visit_site')),
            ),
            // Sidebar.
            'sidebar' => array(
                'all_users' => anchor( site_url('dashboard/all_users'), lang('lnk_users')),
                'add_user' => anchor( site_url('dashboard/add_user'), lang('lnk_add_user')),
                'categories' => anchor( site_url('dashboard/categories'), lang('lnk_categories')),
                'reports' => (empty($reports) ? anchor( site_url('dashboard/reports'), lang('lnk_reports')) : anchor( site_url('dashboard/reports'), ''.lang('lnk_reports').' <span class="pull-right label label-danger">'.$reports.'</span>' )),
                'all_groups' => anchor( site_url('dashboard/all_groups'), lang('lnk_groups')),
                'add_group' => anchor( site_url('dashboard/add_group'), lang('lnk_add_group')),
                'all_settings' => anchor( site_url('dashboard/settings'), lang('lnk_settings')),
                'language_packs' => anchor( site_url('dashboard/language'), lang('lnk_language_packs')),
                'achievements' => anchor( site_url('dashboard/achievements'), lang('lnk_achievements')),
                'achievement_triggers' => anchor( site_url('dashboard/achievement_triggers'), lang('lnk_achievement_triggers')),
                'permissions' => anchor( site_url('dashboard/permissions'), lang('lnk_permissions')),
                'themes' => anchor( site_url('dashboard/themes'), lang('lnk_themes')),
            ),
            // Footer.
            'footer' => array(
                'copy_text' => 'Powered By ' . anchor('http://www.doveforums.com', 'Dove Forums') . ', &copy; 2011 - 2015.',
            ),
        );

        // Define the template regions.
        $data['templates'] = array(
            'doctype' => doctype('html5'),
            'theme' => ($this->admin_theme->name !== 'default' ? '<link href="'.$this->admin_theme->url.'" rel="stylesheet">' : ''),
            'css' => array(
                array( 'link' => '<link href="'.base_url('themes/default/css/custom.css').'" rel="stylesheet">' ),
                array( 'link' => '<link href="'.base_url('themes/default/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css').'" rel="stylesheet" type="text/css" />')
            ),
            'meta' => array(
                array('meta' => meta('keywords', $this->config->item('keywords'))),
            ),
            'js' => array(
                array( 'script' => '<script src="'.base_url('themes/default/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js').'" type="text/javascript"></script>' ),
                array( 'script' => '<script src="'.base_url('themes/default/js/forums.js').'"></script>' ),
            ),
            // Page Title.
            'title' => '' . $this->site_name . ' - ' . $page_title . '',
            // Navigation.
            'navigation' => $this->parser->parse('default/sections/admin_navigation', element('navigation', $data), TRUE),
            // Sidebar.
            'sidebar' => $this->parser->parse('default/sections/admin_sidebar', element('sidebar', $data), TRUE),
            // Content.
            'content' => $this->parser->parse('default/' . $page_template . '', $page_data, TRUE),
            // Footer.
            'footer' => $this->parser->parse('default/sections/footer', element('footer', $data), TRUE),
        );

        // Send all the data to the layout file.
        $this->parser->parse('default/layout', element('templates', $data));
    }
}