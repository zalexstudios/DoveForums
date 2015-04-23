<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_m extends CI_Model {

    /**
     * Get Comments
     *
     * @param       integer     $discussion_id
     * @param       integer     $limit
     * @param       integer     $offset
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_comments($discussion_id, $limit=NULL, $offset=NULL)
    {
        // Query.
        $query = $this->db->select('comments.comment_id, comments.body, comments.insert_date, users.id as user_id, users.username, users.email')
            ->join('users', 'users.id = comments.insert_user_id')
            ->where('comments.discussion_id', $discussion_id)
            ->where('comments.flag', 0)
            ->where('comments.delete_user_id', NULL)
            ->limit($limit, $offset)
            ->get('comments');

        // Result.
        if( $query->num_rows() > 0 )
        {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_previous_comment( $discussion_id )
    {
        // Query.
        $query = $this->db->select('comment_id')
            ->where('discussion_id', $discussion_id)
            ->order_by('comment_id', 'desc')
            ->limit(1)
            ->get('comments');

        // Result.
        if($query->num_rows() > 0)
        {
            return $query->row()->comment_id;
        } else {
            return FALSE;
        }

    }

    /**
     * Insert
     *
     * @param       array       $data
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function insert( $data=array() )
    {
        // Query.
        $this->db->insert('comments', $data);

        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Add Comment
     *
     * @param       integer     $discussion_id
     * @param       integer     $user_id
     * @param       string      $body
     * @param       string      $insert_ip
     * @return      integer
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function add_comment( $discussion_id, $user_id, $body, $insert_ip )
    {
        // Set the timezone.
        date_default_timezone_set($this->config->item('default_timezone'));

        $insert['discussion_id'] = $discussion_id;
        $insert['insert_user_id'] = $user_id;
        $insert['body'] = $body;
        $insert['insert_date'] = date('Y-m-d G:i:s', time());
        $insert['insert_ip'] = $insert_ip;

        $insert_id = $this->db->insert('comments', $insert );

        return $this->db->insert_id();
    }

    /**
     * Delete Comment
     *
     * @param       integer     $comment_id
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_comment( $comment_id )
    {
        // Perform the delete.
        $delete = $this->_delete_row( 'comment_id', $comment_id );

        if( $delete === TRUE )
        {
            return TRUE;
        }

        return FALSE;
    }

    public function get_row( $row, $field, $where )
    {
        return $this->_get_row( $row, $field, $where );
    }

    //-----------------------------------------------------------------------
    // Private functions
    //-----------------------------------------------------------------------

    /**
     * Get Row
     *
     * @param       string      $row
     * @param       string      $field
     * @param       string      $where
     * @return      mixed
     */
    private function _get_row( $row, $field, $where )
    {
        $query = $this->db->select($row)->get_where('comments', array($field => $where));

        if($query->num_rows())
        {
            return $query->row()->$row;
        }

        return 0;
    }

    private function _delete_row( $field, $where )
    {

        $this->db->where( $field, $where )->delete('comments');

        if( $this->db->affected_rows() > 0 )
        {
            return TRUE;
        }

        return FALSE;
    }
}