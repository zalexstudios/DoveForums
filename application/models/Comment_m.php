<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Comments Model
 *
 * Version: 0.4.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  All the functions for the comments.
 *
 * Requirements: PHP5 or above
 *
 */

class Comment_m extends MY_Model {

    public $_table = 'comments';
    public $primary_key = 'id';
    protected $soft_delete = TRUE;

    /**
     * Count Comments
     *
     * Counts all the user comments in the database.
     *
     * @param       int     $user_id
     * @return      int
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function count($user_id = FALSE)
    {
        if($user_id != FALSE)
        {
            $this->db->where('poster', $this->session->userdata('username'));
        }

        // Query.
        $query = $this->db->select('*')
            ->get($this->tables['comments']);

        // Result.
        return $query->num_rows() > 0 ? $query->num_rows() : 0;
    }
}