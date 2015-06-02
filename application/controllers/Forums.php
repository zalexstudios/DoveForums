<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forums extends Front_Controller
{
    public function index()
    {
        // Define the page title.
        $data['title'] = lang('tle_recent_discussions');

        // Define the template.
        $data['template'] = 'pages/home/home';

        // Get the discussions from the database.
        $discussions = $this->forums->get_discussions();

        // Loop through the discussions.
        if( !empty($discussions) )
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
        $this->crumbs->add(lang('tle_recent_discussions'));

        // Define the page data.
        $data['page'] = array(
            // Buttons
            'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
            //fixed page element language
			'pg_recent_discussions' => lang('pg_recent_discussions'),
			'pg_no_discussions' => lang('pg_no_discussions'),
			// Other
            'discussions' => element('discussions', $data),
            'has_discussions' => (!empty($discussions)) ? 1 : 0,
            'breadcrumbs' => $this->crumbs->output(),
            'pagination' => $this->pagination->create_links(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }
}