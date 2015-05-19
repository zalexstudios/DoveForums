<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussions_m extends CI_Model {

    //-----------------------------------------------------------------------
    // Public functions
    //-----------------------------------------------------------------------

    /**
     * Count All
     *
     * @return      int
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function count_all()
    {
        // Query.
        $query = $this->db->select('*')
            ->get('discussions');

        // Result.
        if( $query->num_rows() > 0 )
        {
            return $query->num_rows();
        } else {
            return 0;
        }
    }



    /**
     * Update
     *
     * @param       string      $field
     * @param       string      $where
     * @param       array       $data
     * @return bool
     */
    public function update( $field, $where, $data )
    {
        $this->db->where( $field, $where )->update( 'discussions', $data );

        if( $this->db->affected_rows() > 0 )
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Update Discussion
     *
     * @param       integer     $discussion_id
     * @param       integer     $comment_id
     * @param       integer     $user_id
     * @return      integer
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function update_discussion( $discussion_id, $comment_id, $user_id )
    {
        // Set the timezone.
        date_default_timezone_set($this->config->item('default_timezone'));

        $comment_count = $this->_get_row( 'comment_count', 'discussion_id', $discussion_id );

        $update['last_comment_id'] = $comment_id;
        $update['last_comment_user_id'] = $user_id;
        $update['comment_count'] = ++$comment_count;
        $update['last_comment_date'] = date('Y-m-d G:i:s', time());

        $this->db->where( 'discussion_id', $discussion_id )->update( 'discussions', $update );

        return $this->db->affected_rows();
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
        $query = $this->db->select($row)->get_where('discussions', array($field => $where));

        if($query->num_rows())
        {
            return $query->row()->$row;
        }

        return 0;
    }
}