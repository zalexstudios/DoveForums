<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

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

        /* TODO - Build the users page. */

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function add_user()
    {
        // Define the page title.
        $data['title'] = 'Add User';

        // Define the page template.
        $data['template'] = 'pages/dashboard/add_user';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard', 'dashboard');
        $this->crumbs->add('Add User');

        /* TODO - Build the add user page. */

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function edit_user($user_id)
    {
        // Define the page title.
        $data['title'] = 'Edit User';

        // Define the page template.
        $data['template'] = 'pages/dashboard/edit_user';

        // Build the breadcrumbs.
        $this->crumbs->add('Dashboard', 'dashboard');
        $this->crumbs->add('Edit User');

        /* TODO - Build the edit user page. */

        // Define the page data.
        $data['page'] = array(
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function delete_user($user_id)
    {
        /* TODO - Build the delete user function.*/
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
        /* TODO */
    }

    /*****************************************************************************************
     * Comment Functions
     *****************************************************************************************/

    /*****************************************************************************************
     * Settings Functions
     *****************************************************************************************/


}