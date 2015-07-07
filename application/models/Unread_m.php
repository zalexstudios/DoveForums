<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Unread Model
 *
 * Version: 0.4.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  All the functions for the unread.
 *
 * Requirements: PHP5 or above
 *
 */

class Unread_m extends MY_Model {

    public $_table = 'unread';

    public function get_unread()
    {
        // Get any unread data from the unread table
        $unread =  $this->get_many_by('user_id', $this->session->userdata('user_id'));

        if(!empty($unread))
        {
            foreach($unread as $row)
            {
                $data['unread'][] = $row->discussion_id;
            }
        } else {
            $data['unread'] = '';
        }

        return element('unread', $data);
    }

    public function mark_read($discussion_id)
    {
        return $this->delete_by(array('discussion_id' => $discussion_id, 'user_id' => $this->session->userdata('user_id')));
    }

    public function mark_all()
    {
        return $this->delete_by(array('user_id' => $this->session->userdata('user_id')));
    }
}