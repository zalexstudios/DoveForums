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
     * Get Discussions
     *
     * This function grabs the discussions from the database
     *
     * @param       integer     category_id
     * @param       string      filter
     * @param       string      order
     * @param       integer     limit
     * @param       integer     offset
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_discussions($category_id=NULL, $filter=NULL, $order=NULL, $limit=NULL, $offset=NULL)
    {
        // Select and Join.
        $this->db->select('discussions.name as discussion_name, discussions.comment_count,
            discussions.last_comment_date, discussions.last_comment_user_id, discussions.insert_user_id,
            discussions.category_id, discussions.view_count, discussions.slug as discussion_slug,
            users.username, users.id as user_id, categories.name as category_name, categories.slug as category_slug,')
            ->join('users', 'users.id = discussions.last_comment_user_id')
            ->join('categories', 'categories.category_id = discussions.category_id');

        // Has a category id been passed?
        if( !empty( $category_id ) )
        {
            $this->db->where('discussions.category_id', $category_id);
        }

        // Has a filter and order been set?
        if( !empty( $filter ) )
        {
            $this->db->order_by( $filter, $order );
        }

        // Set the limit and offset.
        $this->db->limit( $limit, $offset );

        // Query.
        $query = $this->db->get('discussions');

        // Result.
        if( $query->num_rows() > 0 )
        {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * Get Singleton
     *
     * @param       string      $discussion_slug
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_singleton($discussion_slug)
    {
        // Query.
        $query = $this->db->select('discussions.discussion_id, discussions.name as discussion_name, discussions.insert_user_id,
        discussions.slug as discussion_slug, discussions.body, discussions.insert_date, discussions.view_count,
        discussions.comment_count, discussions.first_comment_id, categories.name as category_name, categories.slug as category_slug,
        users.username, users.id as user_id, users.email')
            ->where('discussions.slug', $discussion_slug)
            ->join('categories', 'categories.category_id = discussions.category_id')
            ->join('users', 'users.id = discussions.insert_user_id')
            ->get('discussions');

        // Result.
        if( $query->num_rows() > 0 )
        {
            return $query->row();
        } else {
            return FALSE;
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