<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_m extends CI_Model {

    /**
     * Get categories
     *
     * This function grabs all the categories
     * from the database.
     *
     * @return object
     * @author Chris Baines
     * @since 0.0.1
     */
    public function get_categories ()
    {
        // Query.
        $query = $this->db->select('categories.category_id, categories.discussion_count, categories.comment_count,
        categories.name, categories.slug as category_slug, categories.description, categories.last_discussion_id,
        discussions.name as discussion_name, discussions.slug as discussion_slug, users.id as user_id, users.username, ')
            ->join('discussions', 'discussions.discussion_id = categories.last_discussion_id')
            ->join('users', 'users.id = discussions.last_comment_user_id')
            ->get('categories');

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
     * This function grabs a single category
     * from the database.
     *
     * @var category_slug
     * @return object
     * @author Chris Baines
     * @since 0.0.1
     */
    public function get_singleton ($category_slug)
    {
        // Query.
        $query = $this->db->select('category_id, discussion_count, comment_count, name, slug as category_slug, description')
            ->where('slug', $category_slug)
            ->get('categories');

        // Result.
        if( $query->num_rows() > 0 )
        {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function update ($data=array(), $category_id)
    {
        // Start the transaction.
        $this->db->trans_begin();

        $this->db->where('category_id', $category_id)
            ->update('categories', $data);

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