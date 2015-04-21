<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussions_m extends CI_Model {

    /**
     * Count All
     *
     * This function counts all the discussions
     * in the database.
     *
     * @return int
     * @author Chris Baines
     * @since 0.0.1
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
     * @var category_id
     * @var filter
     * @var order
     * @var limit
     * @var offset
     * @return object
     * @author Chris Baines
     * @since 0.0.1
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

    public function get_singleton($discussion_slug)
    {
        // Query.
        $query = $this->db->select('discussions.discussion_id, discussions.name as discussion_name,
        discussions.slug as discussion_slug, discussions.body, discussions.insert_date, discussions.view_count,
        discussions.comment_count, categories.name as category_name, categories.slug as category_slug,
        users.username, users.id as user_id, users.email')
            ->where('discussions.slug', $discussion_slug)
            ->join('categories', 'categories.category_id = discussions.category_id')
            ->join('users', 'users.id = discussions.insert_user_id')
            ->get('discussions');

        // Result.
        if( $query->num_rows() > 0 )
        {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function update($data=array(), $discussion_id)
    {
        // Start the transaction.
        $this->db->trans_begin();

        $this->db->where('discussion_id', $discussion_id)
            ->update('discussions', $data);

        if ($this->db->trans_status() === FALSE)
        {
            // Roll back the changes.
            $this->db->trans_rollback();
            return FALSE;
        } else {
            // Commit the changes.
            $this->db->trans_commit();
            return TRUE;
        }
    }
}