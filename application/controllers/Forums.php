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
        $discussions = $this->discussions->get_all();

        // Loop through the discussions.
        if( !empty($discussions) )
        {
            foreach($discussions as $row)
            {
                // Get the category associated with the discussion.
                $cat = $this->categories->get_by('id', $row->category_id);

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
        $this->crumbs->add(lang('crumb_recent_discussions'));

        // Define the page data.
        $data['page'] = array(
            // Buttons
            'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-sm' )),
			// Other
            'discussions' => element('discussions', $data),
            'has_discussions' => (!empty($discussions)) ? 1 : 0,
            'breadcrumbs' => $this->crumbs->output(),
            'pagination' => $this->pagination->create_links(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }
}