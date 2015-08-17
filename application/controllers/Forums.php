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
        $discussions = $this->discussions->order_by(array('sticky' => 'DESC', 'posted' => 'DESC'))->get_all();

        // Set the table template.
        $data['tmpl'] = array (
            'table_open' => '<table class="table table-hover">',
        );

        $this->table->set_template(element('tmpl', $data));

        // Set the table headings.
        $this->table->set_heading(
            '',
            'Discussion',
            'Users',
            'Replies',
            'Views',
            'Activity'
        );

        // Loop through the discussions.
        if( !empty($discussions) )
        {
            foreach($discussions as $row)
            {
                // Get the user who created the discussion.
                $poster = $this->users->get_by('username', $row->poster);
                $last_poster = $this->users->get_by('username', $row->last_poster);

                // Build the posters avatar.
                $data['avatar'] = array(
                    'src' => $this->gravatar->get_gravatar($poster->email, $this->config->item('gravatar_rating'), $this->config->item('gravatar_size'), $this->config->item('gravatar_default_image') ),
                    'title' => ''.$poster->username.' - Discussion Creator',
                );

                // Get the category associated with the discussion.
                $cat = $this->categories->get_by('id', $row->category_id);

                if(!empty($this->_unread))
                {
                    if(in_array($row->id, $this->_unread))
                    {
                        $unread = true;
                    }
                    else
                    {
                        $unread = false;
                    }
                } else {
                    $unread = false;
                }

                $data['discussions'][] = array(
                    'subject' => ($unread == TRUE ? anchor( site_url('discussions/view/'.$row->id), '<i class="fa fa-lightbulb-o"></i>&nbsp;<strong>'.$row->subject.'</strong>') : anchor( site_url('discussions/view/'.$row->id), $row->subject)),
                    'replies' => $row->replies,
                    'views' => $row->views,
                    'last_comment' => timespan($row->last_comment, time()),
                    'last_poster' => anchor( site_url('users/profile/'.$row->last_poster_id), $row->last_poster),
                    'category' => anchor( site_url('categories/'.$cat->slug.''), $cat->name ),
                    'avatar' => anchor( site_url('users/profile/'.$poster->id), img( element('avatar', $data) )),
                    'avatar_last_poster' => anchor( site_url('users/profile/'.$last_poster->id), img( element('avatar_last_poster', $data))),
                    'sticky' => ($row->sticky == 1 ? '<span class="label label-success"><i class="fa fa-thumb-tack"></i></span>&nbsp;' : ''),
                    'closed' => ($row->closed == 1 ? '<span class="label label-danger"><i class="fa fa-lock"></i></span>&nbsp;' : ''),
                    'unread' => (in_array($row->id, $this->_unread) ? 'unread' : ''),
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
            'btn_new_discussion' => anchor( site_url('discussions/new_discussion'), lang('btn_new_discussion'), array( 'class' => 'btn btn-default btn-xs' )),
            // Links
            'lnk_mark_all' => anchor( site_url('discussions/mark_all'), lang('lnk_mark_all')),
			// Other
            'discussions' => element('discussions', $data),
            'has_discussions' => (!empty($discussions)) ? 1 : 0,
            'breadcrumbs' => $this->crumbs->output(),
            'pagination' => $this->pagination->create_links(),
        );

        $this->render( element('page', $data), element('title', $data), element('template', $data) );
    }
}