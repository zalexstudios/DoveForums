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

        // Loop through the discussions.
        if( !empty($discussions) )
        {
            foreach($discussions as $row)
            {
                // Get the user who created the discussion.
                $user = $this->users->get_by('username', $row->poster);

                // Build the users avatar.
                $data['avatar'] = array(
                    'src' => $this->gravatar->get_gravatar($user->email, $this->config->item('gravatar_rating'), $this->config->item('gravatar_size'), $this->config->item('gravatar_default_image') ),
                    'title' => sprintf(lang('txt_profile'), $user->username),
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
                    'subject' => ($unread == TRUE ? anchor( site_url('discussions/view/'.$row->id), '<strong>'.$row->subject.'</strong>') : anchor( site_url('discussions/view/'.$row->id), $row->subject)),
                    'replies' => $row->replies,
                    'views' => $row->views,
                    'last_comment' => unix_to_human($row->last_comment),
                    'last_poster' => anchor( site_url('users/profile/'.$row->last_poster_id), $row->last_poster),
                    'category' => anchor( site_url('categories/'.$cat->slug.''), $cat->name ),
                    'avatar' => anchor( site_url('users/profile/'.$user->id), img( element('avatar', $data) )),
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