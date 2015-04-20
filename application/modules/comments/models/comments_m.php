<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_m extends CI_Model {

    public function get_comments($discussion_id)
    {
        // Query.
        $query = $this->db->select('comments.body, comments.insert_date, users.id as user_id, users.username, users.email')
            ->join('users', 'users.id = comments.insert_user_id')
            ->where('comments.discussion_id', $discussion_id)
            ->where('comments.flag', 0)
            ->where('comments.delete_user_id', NULL)
            ->get('comments');

        // Result.
        if( $query->num_rows() > 0 )
        {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function insert( $data=array() )
    {
        // Query.
        $this->db->insert('comments', $data);

        if( $this->db->affected_rows() > 0 )
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}