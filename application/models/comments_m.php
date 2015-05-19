<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_m extends CI_Model {



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