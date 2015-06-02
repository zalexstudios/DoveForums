<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends Front_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load helpers.
        $this->load->helper('xml');
        $this->load->helper('text');
    }

    public function index()
    {
        // Define the page title.
        $data['title'] = lang('tle_all_discussions');

        // Define the page template.
        $data['template'] = 'pages/categories/all';

        // Get all the categories from the database.
        $categories = $this->forums->get_categories();

        // Check if we have a valid array.
        if( !empty( $categories ) )
        {
            // Loop through the results.
            foreach( $categories as $row )
            {
                $data['categories'][] = array(
                        'name' => anchor( site_url('categories/'.$row->category_slug.''), $row->name),
                        'description' => $row->description,
                        'discussion_count' => $row->discussion_count,
                        'comment_count' => $row->comment_count,
                        'latest_discussion' => anchor( site_url('discussions/'.$row->category_slug.'/'.$row->discussion_slug.''), $row->discussion_name),
                        'last_comment_by' => anchor( site_url('users/profile/'.$row->user_id.''), $row->username),
                );
            }

        } else {

            // Fill with blank data to prevent errors.
            $data['categories'] = '';
        }

        // Build the page breadcrumbs.
        $this->crumbs->add(lang('crumb_categories'), 'categories');
        $this->crumbs->add(lang('crumb_all_categories'));

        // Define the page data.
        $data['page'] = array(
            // Buttons
            'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
            //fixed page element language
			'tle_all_categories' => lang('tle_all_categories'),
			'pg_no_discussions' => lang('pg_no_discussions'),
			// Other
            'categories' => element('categories', $data),
            'has_categories' => (!empty($categories)) ? 1 : 0,
            'breadcrumbs' => $this->crumbs->output(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function view($category_slug)
    {
        // Get the category from the database.
        $category = $this->forums->get_category($category_slug);

        // Define the page title.
        $data['title'] = $category->name;

        // Define the template.
        $data['template'] = 'pages/categories/view';

        // Get the discussions for this category.
        $discussions = $this->forums->get_discussions($category->category_id);

        // Loop through the discussions.
        if ( !empty($discussions) )
        {
            foreach($discussions as $row)
            {
                $data['discussions'][] = array(
                        'name' => anchor( site_url('discussions/'.$row->category_slug.'/'.$row->discussion_slug.''), $row->discussion_name),
                        'comment_count' => $row->comment_count,
                        'view_count' => $row->view_count,
                        'last_comment_date' => date("jS M Y - h:i:s A", strtotime( $row->last_comment_date) ),
                        'last_comment_username' => anchor( site_url('users/profile/'.$row->user_id), $row->username ),
                        'category_name' => anchor( site_url('categories/'.$row->category_slug.''), $row->category_name ),
                );
            }

        } else {
            // Fill with blank data to prevent errors.
            $data['discussions'] = '';
        }

        // Build the page breadcrumbs.
        $this->crumbs->add($category->name);

        // Define the page data.
        $data['page'] = array(
            // Buttons
            'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
             //fixed page element language
			'pg_no_discussions' => lang('pg_no_discussions'),
			// Other
            'discussions' => element('discussions', $data),
            'has_discussions' => (!empty($discussions)) ? 1 : 0,
            'breadcrumbs' => $this->crumbs->output(),
            'name' => $category->name,
            'description' => $category->description,
            'pagination' => $this->pagination->create_links(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );

    }

}
