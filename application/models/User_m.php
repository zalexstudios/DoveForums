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

    public function update_last_activity($user_id)
    {
        return $this->update_by(array('id' => $user_id), array('last_activity' => now()));
    }
}