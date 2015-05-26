<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Forums Model
 *
 * Version: 2.5.2
 *
 * Author:  Chris Baines
 * 		   chris@doveforums.com
 *
 * Location: http://github.com/doveforums/DoveForums
 *
 * Created:  18.05.2015
 *
 * Last Change: 18.05.2015
 *
 * Description:  All the functions for Dove Forums.
 *
 * Requirements: PHP5 or above
 *
 */

class Forums_M extends CI_Model {

    /*****************************************************************************************
     * Category Functions
     *****************************************************************************************/

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
        discussions.name as discussion_name, discussions.slug as discussion_slug, users.id as user_id, users.username')
            ->join($this->tables['discussions'], 'discussions.discussion_id = categories.last_discussion_id')
            ->join($this->tables['users'], 'users.id = discussions.last_comment_user_id')
            ->get($this->tables['categories']);

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    /**
     * Get Category
     *
     * This function grabs a single category
     * from the database.
     *
     * @var category_slug
     * @return object
     * @author Chris Baines
     * @since 0.0.1
     */
    public function get_category ($category_slug)
    {
        // Query.
        $query = $this->db->select('category_id, discussion_count, comment_count, name, slug as category_slug, description')
            ->where('slug', $category_slug)
            ->get($this->tables['categories']);

        // Result.
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    public function get_categories_dropdown()
    {
        // Query.
        $query = $this->db->select('category_id, name')
            ->get($this->tables['categories']);

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    public function delete_category($category_id)
    {
        // Move any discussion in the category to the default category.
        $this->_update('category_id', $category_id, $this->tables['discussions'], array('category_id', 1));

        // Delete the category.
        return $this->_delete('category_id', $category_id, $this->tables['categories']) === TRUE;

    }

    public function add_category($data)
    {
        // Start database transaction.
        $this->db->trans_start();

        // Load the slug library.
        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'table' => 'categories',
            'replacement' => 'underscore'
        );

        $this->load->library('slug', $config);

        $category = array(
            'name' => strip_tags($data['name']),
            'slug' => $this->slug->create_uri(strip_tags($data['name'])),
            'description' => strip_tags($data['description']),
            'insert_user_id' => $this->session->userdata('user_id'),
            'date_inserted' => $this->_date(),
        );

        $this->_insert( $this->tables['categories'], $category);

        // End database transaction.
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();

            return FALSE;
        }
        else
        {
            return TRUE;
        }

    }

    /*****************************************************************************************
     * Discussion Functions
     *****************************************************************************************/

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
    public function get_discussions ($category_id=NULL, $filter=NULL, $order=NULL, $limit=NULL, $offset=NULL)
    {
        // Select and Join.
        $this->db->select('discussions.name as discussion_name, discussions.comment_count,
            discussions.last_comment_date, discussions.last_comment_user_id, discussions.insert_user_id,
            discussions.category_id, discussions.view_count, discussions.slug as discussion_slug,
            users.username, users.id as user_id, categories.name as category_name, categories.slug as category_slug,')
            ->where('discussions.flag', 0)
            ->order_by('discussions.discussion_id', 'desc')
            ->join($this->tables['users'], 'users.id = discussions.last_comment_user_id')
            ->join($this->tables['categories'], 'categories.category_id = discussions.category_id');

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
        $query = $this->db->get($this->tables['discussions']);

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    /**
     * Get Discussion
     *
     * This function grabs a single discussion
     * from the database.
     *
     * @param       string      $discussion_slug
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_discussion ($discussion_slug)
    {
        // Query.
        $query = $this->db->select('discussions.discussion_id, discussions.category_id, discussions.name as discussion_name, discussions.insert_user_id,
        discussions.slug as discussion_slug, discussions.body, discussions.insert_date, discussions.view_count,
        discussions.comment_count, discussions.first_comment_id, categories.name as category_name, categories.slug as category_slug,
        users.username, users.id as user_id, users.email')
            ->where('discussions.slug', $discussion_slug)
            ->where('discussions.flag', 0)
            ->join($this->tables['categories'], 'categories.category_id = discussions.category_id')
            ->join($this->tables['users'], 'users.id = discussions.insert_user_id')
            ->get($this->tables['discussions']);

        // Result.
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Count Discussions
     *
     * Counts all the discussion in the database.
     *
     * @return      int
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function count_discussions()
    {
        // Query.
        $query = $this->db->select('*')
            ->where('flag', '0')
            ->get($this->tables['discussions']);

        // Result.
        return $query->num_rows() > 0 ? $query->num_rows() : 0;
    }

    /**
     * Update Discussion Count
     *
     * Updates the discussion view count.
     *
     * @param       string      $discussion_id
     * @param       string      $view_count
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function update_discussion_count ( $discussion_id, $view_count )
    {
        // Query.
        $this->db->where('discussion_id', $discussion_id)
            ->update($this->tables['discussions'], array('view_count' => $view_count));

        // Result.
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /**
     * Delete Discussions - ** Admin Function **
     *
     * Deletes all the discussions created by a user.
     *
     * @param       string      $user_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_discussions($user_id)
    {
        // Query.
        $this->db->where('insert_user_id', $user_id)
            ->delete($this->tables['discussions']);
    }

    public function delete_discussion($discussion_id)
    {

    }

    public function create_discussion($data)
    {
        // Load the slug library.
        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'table' => 'discussions',
            'replacement' => 'underscore'
        );

        $this->load->library('slug', $config);

        $discussion = array(
            'insert_user_id' => $this->session->userdata('user_id'),
            'name' => $data['name'],
            'body' => $data['body'],
            'category_id' => $data['category'],
            'slug' => $this->slug->create_uri($data['name']),
            'insert_date' => $this->_date(),
            'last_comment_user_id' => $this->session->userdata('user_id'),
            'last_comment_date' => $this->_date(),
        );

        $insert = $this->_insert( $this->tables['discussions'], $discussion);

        // Get the discussion count.
        $discussion_count = $this->_get_row('discussion_count', 'category_id', $data['category'], $this->tables['categories']);

        $category = array(
            'discussion_count' => ++$discussion_count,
            'last_discussion_id' => $insert,
        );

        return $this->_update_category($data['category'], $category) === TRUE ? TRUE : FALSE;
    }

    /*****************************************************************************************
     * Comments Functions
     *****************************************************************************************/

    /**
     * Get Comments
     *
     * Gets all the comments for a discussion from the database.
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
            ->join($this->tables['users'], 'users.id = comments.insert_user_id')
            ->where('comments.discussion_id', $discussion_id)
            ->where('comments.flag', 0)
            ->where('comments.delete_user_id', NULL)
            ->limit($limit, $offset)
            ->get($this->tables['comments']);

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    /**
     * Add Comment
     *
     * @param       array       $data
     * @return      integer
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function add_comment( $data )
    {
        // Start database transaction.
        $this->db->trans_start();

        $comment = array(
            'discussion_id' => $data['discussion_id'],
            'insert_user_id' => $this->session->userdata('user_id'),
            'body' => strip_tags( $this->security->xss_clean ($data['body'])),
            'insert_date' => $this->_date(),
            'insert_ip' => $this->input->ip_address(),
        );

        // Get the last comment ID.
        $comment_id = $this->_insert( $this->tables['comments'], $comment);

        // Get the comment count.
        $comment_count = $this->_get_row('comment_count', 'discussion_id', $data['discussion_id'], $this->tables['discussions']);

        // Update the discussion.
        $discussion = array(
            'last_comment_id' => $comment_id,
            'last_comment_user_id' => $this->session->userdata('user_id'),
            'comment_count' => ++$comment_count,
            'last_comment_date' => $this->_date(),
        );

        $this->_update_discussion( $data['discussion_id'], $discussion );

        // Update the category.
        $comment_count = $this->_get_row( 'comment_count', 'category_id', $data['category_id'], $this->tables['categories'] );

        $category = array(
            'comment_count' => ++ $comment_count,
            'last_comment_id' => $comment_id,
            'last_comment_date' => $this->_date(),
        );

        $this->_update_category( $data['category_id'], $category );

        // End database transaction.
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();

            return FALSE;
        }
        else
        {
            return TRUE;
        }

    }

    public function get_previous_comment( $discussion_id )
    {
        // Query.
        $query = $this->db->select('comment_id')
            ->where('discussion_id', $discussion_id)
            ->order_by('comment_id', 'desc')
            ->limit(1)
            ->get($this->tables['comments']);

        // Result.
        return $query->num_rows() > 0 ? $query->row()->comment_id : NULL;
    }

    /**
     * Delete Comments - ** Admin Function **
     *
     * Deletes all the comments created by a user.
     *
     * @param       string      $user_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_comments($user_id)
    {
        // Query.
        $this->db->where('insert_user_id', $user_id)
            ->delete($this->tables['comments']);
    }

    /*****************************************************************************************
     * User Functions
     *****************************************************************************************/

    /**
     * Update User Visit Count
     *
     * Updates the user visit count.
     *
     * @param       string      $user_id
     * @param       string      $visit_count
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function update_visit_count ( $user_id, $visit_count )
    {
        // Query.
        $this->db->where('id', $user_id)
            ->update($this->tables['users'], array('visit_count' => $visit_count));

        // Result.
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /*****************************************************************************************
     * Misc Functions
     *****************************************************************************************/

    public function get_row( $row, $field, $where, $table )
    {
        return $this->_get_row( $row, $field, $where, $table );
    }

    /*****************************************************************************************
     * Private Functions
     *****************************************************************************************/

    /**
     * Get Row
     *
     * Gets a single field from the database.
     *
     * @param       string      $row
     * @param       string      $field
     * @param       string      $where
     * @param       string      $table
     * @return      mixed
     * @author      Chris Baines
     * @since       0.0.1
     */
    private function _get_row( $row, $field, $where, $table )
    {
        $query = $this->db->select($row)->get_where($table, array($field => $where));

        if($query->num_rows())
        {
            return $query->row()->$row;
        }

        return 0;
    }

    /**
     * Update Discussion
     *
     * Updates a single discussion in the database.
     *
     * @param       string      $discussion_id
     * @param       array       $data
     * @return      bool|null
     * @author      Chris Baines
     * @since       0.0.1
     */
    private function _update_discussion( $discussion_id, $data )
    {
        return $this->_update( 'discussion_id', $discussion_id, $this->tables['discussions'], $data );
    }

    /**
     * Update Category
     *
     * Updates a single category in the database.
     *
     * @param       string      $category_id
     * @param       array       $data
     * @return      bool|null
     * @author      Chris Baines
     * @since       0.0.1
     */
    private function _update_category ( $category_id, $data )
    {
        return $this->_update( 'category_id', $category_id, $this->tables['categories'], $data );
    }

    /**
     * Insert
     *
     * Inserts data into the database.
     *
     * @param       string      $table
     * @param       array       $data
     * @return      int/null
     * @author      Chris Baines
     * @since       0.0.1
     */
    private function _insert( $table, $data )
    {
        $this->db->insert( $table, $data );

        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : NULL;
    }

    /**
     * Update
     *
     * Updates a row in the database.
     *
     * @param       string      $field
     * @param       string      $where
     * @param       string      $table
     * @param       array       $data
     * @return      bool|null
     * @author      Chris Baines
     * @since       0.0.1
     */
    private function _update( $field, $where, $table, $data )
    {
        $this->db->where($field, $where)
            ->update( $table, $data);

        return $this->db->affected_rows() > 0 ? TRUE : NULL;
    }

    /**
     * Date
     *
     * Returns the current timestamp.
     *
     *
     * @return      bool|string
     * @author      Chris Baines
     * @since       0.0.1
     */
    private function _date()
    {
        // Set the timezone.
        date_default_timezone_set ($this->config->item('default_timezone') );

        return date('Y-m-d G:i:s', time());
    }

    private function _delete( $field, $where, $table )
    {
        $this->db->where($field, $where)
            ->delete($table);

        return $this->db->affected_rows() > 0 ? TRUE : NULL;
    }

}

