<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Users Model
 *
 * Version: 0.4.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  All the additional functions for the users.
 *
 * Requirements: PHP5 or above
 *
 */

class User_m extends MY_Model {

    public $_table = 'users';
    public $primary_key = 'id';

    public function update_last_activity()
    {
        return $this->update_by(array('id' => $this->session->userdata('user_id')), array('last_activity' => now()));
    }

    public function user($user_id = NULL)
    {
        return $this->ion_auth->user($user_id)->row();
    }

    public function users_online()
    {
        $data = '';

        $users = $this->get_all();

        foreach($users as $user)
        {
            if($user->last_activity > now() - 5 * 60)
            {
                $data[] = array(
                    'user' => ''.anchor( site_url('users/profile/'.$user->id), $user->username).',&nbsp;',
                );
            }
        }

        return $data;
    }

    public function user_online($user_id)
    {
        // Get the user.
        $user = $this->user($user_id);

        // Has the user been active in the last 5 minutes.
        if($user->last_activity > now() - 5 * 60)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}