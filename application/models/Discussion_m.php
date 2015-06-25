<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Discussions Model
 *
 * Version: 0.4.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  All the functions for the discussions.
 *
 * Requirements: PHP5 or above
 *
 */

class Discussion_m extends MY_Model {

    public $_table = 'discussions';
    public $primary_key = 'id';
    protected $soft_delete = TRUE;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Count Discussions
     *
     * Counts all the discussion in the database.
     *
     * @param       bool     $user_id
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
            ->get($this->tables['discussions']);

        // Result.
        return $query->num_rows() > 0 ? $query->num_rows() : 0;
    }
}