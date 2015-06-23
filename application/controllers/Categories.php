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
        $data['title'] = lang('tle_all_categories');

        // Define the page template.
        $data['template'] = 'pages/categories/view';

        // Get all the discussions from the database.
        $discussions = $this->discussions->get_all();

        // Check if we have a valid array.
        if( !empty( $discussions ) )
        {
            // Loop through the results.
            foreach( $discussions as $row )
            {
                // Get the category from the database.
                $cat = $this->categories->get_by('id', $row->category_id);

                $data['discussions'][] = array(
                        'subject' => anchor( site_url('discussions/view/'.$row->id.''), $row->subject),
                        'views' => $row->views,
                        'replies' => $row->replies,
                        'last_comment' => unix_to_human($row->last_comment),
                        'last_poster' => anchor( site_url('users/profile/'.$row->last_poster_id.''), $row->last_poster),
                        'category' => anchor( site_url('categories/'.$cat->id), $cat->name),
                );
            }

        } else {

            // Fill with blank data to prevent errors.
            $data['discussions'] = '';
        }

        // Build the page breadcrumbs.
        $this->crumbs->add(lang('crumb_categories'), 'categories');
        $this->crumbs->add(lang('crumb_all_categories'));

        // Define the page data.
        $data['page'] = array(
            // Buttons
            'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
			// Other
            'discussions' => element('discussions', $data),
            'has_discussions' => (!empty($discussions)) ? 1 : 0,
            'breadcrumbs' => $this->crumbs->output(),
            'name' => lang('tle_all_categories'),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }

    public function view($category_slug)
    {
        // Get the category from the database.
        $cat = $this->categories->get_by('slug', $category_slug);

        // Define the page title.
        $data['title'] = $cat->name;

        // Define the template.
        $data['template'] = 'pages/categories/view';

        // Get the discussions for this category.
        $discussions = $this->discussions->get_many_by('category_id', $cat->id);

        // Loop through the discussions.
        if ( !empty($discussions) )
        {
            foreach($discussions as $row)
            {
                $data['discussions'][] = array(
                        'subject' => anchor( site_url('discussions/view/'.$row->id), $row->subject),
                        'replies' => $row->replies,
                        'views' => $row->views,
                        'last_comment' => unix_to_human($row->last_comment),
                        'last_poster' => anchor( site_url('users/profile/'.$row->last_poster_id), $row->last_poster),
                        'category' => anchor( site_url('categories/'.$cat->slug.''), $cat->name ),
                );
            }

        } else {
            // Fill with blank data to prevent errors.
            $data['discussions'] = '';
        }

        // Build the page breadcrumbs.
        $this->crumbs->add(lang('crumb_categories'), 'categories');
        $this->crumbs->add($cat->name);

        // Define the page data.
        $data['page'] = array(
            // Buttons
            'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
			// Other
            'discussions' => element('discussions', $data),
            'has_discussions' => (!empty($discussions)) ? 1 : 0,
            'breadcrumbs' => $this->crumbs->output(),
            'name' => $cat->name,
            'pagination' => $this->pagination->create_links(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );

    }

}
