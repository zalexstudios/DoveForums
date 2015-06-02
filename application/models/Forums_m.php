<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Forums Model
 *
 * Version: 0.0.1
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
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
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
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
     * @param       string      category_slug
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
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

    /**
     * Get Categories Dropdown
     *
     * Gets the categories for the dropdown field.
     *
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_categories_dropdown()
    {
        // Query.
        $query = $this->db->select('category_id, name')
            ->get($this->tables['categories']);

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    /**
     * Get Categories - ** Admin Function **
     *
     * Gets the categories for the admin panel with no joins.
     *
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_categories_admin()
    {
        // Query.
        $query = $this->db->select('*')
            ->get($this->tables['categories']);

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    /**
     * Get Category - ** Admin Function **
     *
     * This function grabs a single category
     * from the database.
     *
     * @param       integer      category_id
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_category_admin ($category_id)
    {
        // Query.
        $query = $this->db->select('*')
            ->where('category_id', $category_id)
            ->get($this->tables['categories']);

        // Result.
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Delete Category
     *
     * Deletes the category and moves any discussions to the default
     * category.
     *
     * @param       integer     $category_id
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_category($category_id)
    {
        // Get the discussion count for the category we are removing.
        $discussion_count = $this->_get_row('discussion_count', 'category_id', $category_id, $this->tables['categories']);

        // Get the comment count for the category we are removing.
        $comment_count = $this->_get_row('comment_count', 'category_id', $category_id, $this->tables['categories']);

        // Get the discussion count for the default category.
        $default_discussion_count = $this->_get_row('discussion_count', 'category_id', 1, $this->tables['categories']);

        // Get the comment count for the default category.
        $default_comment_count = $this->_get_row('comment_count', 'category_id', 1, $this->tables['categories']);

        // Build the data for the update.
        $discussion = array(
            'category_id' => 1,
        );

        // Move any discussion in the category to the default category.
        $this->_update('category_id', $category_id, $this->tables['discussions'], $discussion);

        // Build the data for the update.
        $category = array(
            'discussion_count' => $default_discussion_count + $discussion_count,
            'comment_count' => $default_comment_count + $comment_count,
        );

        // Update the default category.
        $this->_update('category_id', 1, $this->tables['categories'], $category);

        // Delete the category.
        return $this->_delete('category_id', $category_id, $this->tables['categories']) === TRUE;

    }

    /**
     * Add Category
     *
     * Adds a new category to the database.
     *
     * @param       array       $data
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
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

    public function update_category( $category_id, $data )
    {
        // Load the slug library.
        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'id' => 'category_id',
            'table' => 'categories',
            'replacement' => 'underscore'
        );

        $this->load->library('slug', $config);

        $category = array(
            'name' => strip_tags($data['name']),
            'slug' => $this->slug->create_uri(strip_tags($data['name']), $category_id),
            'description' => strip_tags($data['description']),
            'update_user_id' => $this->session->userdata('user_id'),
            'date_updated' => $this->_date(),
        );

        return $this->_update_category( $category_id, $category) ? TRUE : FALSE;
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
     * Get Discussion
     *
     * This function grabs a single discussion
     * from the database.
     *
     * @param       integer      $discussion_id
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_discussion_by_id ($discussion_id)
    {
        // Query.
        $query = $this->db->select('discussions.discussion_id, discussions.category_id, discussions.name as discussion_name, discussions.insert_user_id,
        discussions.slug as discussion_slug, discussions.body, discussions.insert_date, discussions.view_count,
        discussions.comment_count, discussions.first_comment_id, categories.name as category_name, categories.slug as category_slug,
        users.username, users.id as user_id, users.email')
            ->where('discussions.discussion_id', $discussion_id)
            ->where('discussions.flag', 0)
            ->join($this->tables['categories'], 'categories.category_id = discussions.category_id')
            ->join($this->tables['users'], 'users.id = discussions.insert_user_id')
            ->get($this->tables['discussions']);

        // Result.
        return $query->num_rows() > 0 ? $query->row() : NULL;
    }

    /**
     * Get Discussions ** Admin Function **
     *
     * This function grabs all discussions
     * from the database.
     *
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_discussions_admin ()
    {
        // Query.
        $query = $this->db->select('discussions.discussion_id, discussions.category_id, discussions.name as discussion_name, discussions.insert_user_id,
        discussions.slug as discussion_slug, discussions.body, discussions.insert_date, discussions.view_count,
        discussions.comment_count, discussions.first_comment_id, discussions.flag, discussions.report_reason, discussions.report_date, discussions.report_user_id,
        categories.name as category_name, categories.slug as category_slug,
        users.username, users.id as user_id, users.email')
            ->join($this->tables['categories'], 'categories.category_id = discussions.category_id')
            ->join($this->tables['users'], 'users.id = discussions.insert_user_id')
            ->order_by('discussions.flag', 'desc')
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
     * Count User Discussions
     *
     * Counts all the users discussions that have not been flagged.
     *
     * @param       integer     $user_id
     * @return      int
     * @author      Chris Baines
     * @since       0.2.0
     */
    public function count_user_discussions($user_id)
    {
        //Query.
        $query = $this->db->select('*')
            ->where('flag', '0')
            ->where('insert_user_id', $user_id)
            ->get($this->tables['discussions']);

        // Result
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

    public function get_previous_discussion( $category_id )
    {
        // Query.
        $query = $this->db->select('discussion_id')
            ->where('category_id', $category_id)
            ->order_by('discussion_id', 'desc')
            ->limit(1)
            ->get($this->tables['discussions']);

        // Result.
        return $query->num_rows() > 0 ? $query->row()->discussion_id : NULL;
    }

    /**
     * Delete Discussion
     *
     * Deletes the supplied discussion from the database.
     *
     * @param       integer     $discussion_id
     * @return      mixed
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_discussion($discussion_id)
    {
        // Get the discussion from the database.
        $discussion = $this->get_discussion_by_id($discussion_id);

        // Count all comments.
        $comments = count($this->get_comments($discussion_id));

        // Delete all the comments associated with this discussion.
        $this->delete_comments_by_discussion_id($discussion_id);

        // Get the current comment count from the category.
        $comment_count = $this->_get_row('comment_count', 'category_id', $discussion->category_id, $this->tables['categories']);

        // Get the current discussion count from the category.
        $discussion_count = $this->_get_row('discussion_count', 'category_id', $discussion->category_id, $this->tables['categories']);

        // Delete the discussion.
        $this->_delete('discussion_id', $discussion_id, $this->tables['discussions']);

        // Update the category to reflect the changes.
        $category = array(
            'comment_count' => $comment_count - $comments,
            'discussion_count' => --$discussion_count,
            'last_discussion_id' => $this->get_previous_discussion($discussion->category_id),
        );

        return $this->_update_category($discussion->category_id, $category) ? TRUE : FALSE;
    }

    /**
     * Create Discussion.
     *
     * Adds a new discussion to the database.
     *
     * @param       array       $data
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
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

    /**
     * Update Discussion
     *
     * Updates the supplied discussion.
     *
     * @param       integer     $discussion_id
     * @param       array       $data
     * @return      mixed
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function update_discussion( $discussion_id, $data )
    {
        // Load the slug library.
        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'id' => 'discussion_id',
            'table' => 'discussions',
            'replacement' => 'underscore'
        );

        $this->load->library('slug', $config);

        $discussion = array(
            'name' => strip_tags($data['name']),
            'slug' => $this->slug->create_uri(strip_tags($data['name']), $discussion_id),
            'body' => $data['body'],
            'category_id' => $data['category'],
            'update_user_id' => $this->session->userdata('user_id'),
            'update_date' => $this->_date(),
            'update_ip' => $this->input->ip_address(),
        );

        return $this->_update_discussion( $discussion_id, $discussion) ? TRUE : FALSE;
    }

    /**
     * Report Discussion.
     *
     * Allows a user to report a discussion.
     *
     * @param       integer     $discussion_id
     * @param       array       $data
     * @return      mixed
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function report_discussion($discussion_id, $data)
    {
        // Build the data.
        $data = array(
            'flag' => 1,
            'report_reason' => $data['reason'],
            'report_date' => $this->_date(),
            'report_user_id' => $this->session->userdata('user_id'),
        );

        return ($this->_update_discussion($discussion_id, $data) === TRUE) ? TRUE : FALSE;
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
        $query = $this->db->select('comments.comment_id, comments.body, comments.insert_date, comments.insert_user_id, users.id as user_id, users.username, users.email')
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
     * Get Comment By ID
     *
     * Gets a single comment by the supplied ID.
     *
     * @param       integer     $comment_id
     * @return      mixed
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function get_comment_by_id($comment_id)
    {
        // Query.
        $query = $this->db->select('*')
            ->where('comment_id', $comment_id)
            ->limit(1)
            ->get($this->tables['comments']);

        // Result.
        return $query->num_rows() > 0 ? $query->row() : NULL;
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

    /**
     * Get Previous comment from the database,
     * part of the delete comment code.
     *
     * @param       integer     $discussion_id
     * @return      object
     * @author      Chris Baines
     * @since       0.0.1
     */
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

    /**
     * Delete Comments By Discussion ID
     *
     * Deletes all the comments with the supplied discussion ID.
     *
     * @param       integer     $discussion_id
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_comments_by_discussion_id($discussion_id)
    {
        // Query.
        $this->db->where('discussion_id', $discussion_id)
            ->delete($this->tables['comments']);
    }

    /**
     * Delete Comment
     *
     * Deletes the comment by the supplied comment ID.
     *
     * @param       integer     $comment_id
     * @return      mixed
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_comment($comment_id)
    {
        // Get the comment from the database.
        $comment = $this->get_comment_by_id($comment_id);

        // Get the discussion Id.
        $discussion_id = $comment->discussion_id;

        // Get the category ID.
        $category_id = $this->_get_row('category_id', 'discussion_id', $discussion_id, $this->tables['discussions']);

        // Get the comment count.
        $discussion_comment_count = $this->_get_row('comment_count', 'discussion_id', $discussion_id, $this->tables['discussions']);
        $category_comment_count = $this->_get_row('comment_count', 'category_id', $category_id, $this->tables['categories']);

        // Delete the comment.
        $this->_delete('comment_id', $comment_id, $this->tables['comments']);

        // Get the previous comment.
        $previous_comment_id = $this->get_previous_comment($discussion_id);

        // Get the last comment date.
        $previous_comment_date = $this->_get_row('insert_date', 'comment_id', $previous_comment_id, $this->tables['comments']);

        // Build the update information.
        $discussion_update = array(
            'comment_count' => --$discussion_comment_count,
            'last_comment_id' => (empty($previous_comment_id) ? 0 : $previous_comment_id),
            'last_comment_date' => (empty($previous_comment_date) ? NULL : $previous_comment_date),
        );

        $category_update = array(
            'comment_count' => --$category_comment_count,
            'last_comment_id' => (empty($previous_comment_id) ? 0 : $previous_comment_id),
            'last_comment_date' => (empty($previous_comment_date) ? NULL : $previous_comment_date),
        );

        // Update the discussion.
        $discussion = $this->_update_discussion($discussion_id, $discussion_update);

        // Update the category.
        $category = $this->_update_category($category_id, $category_update);

        return ($discussion && $category === TRUE) ? TRUE : FALSE;

    }

    /**
     * Update Comment
     *
     * Updates the supplied comment.
     *
     * @param       integer     $comment_id
     * @param       array       $data
     * @return      mixed
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function update_comment( $comment_id, $data )
    {
        $comment = array(
            'body' => strip_tags($data['body']),
            'update_user_id' => $this->session->userdata('user_id'),
            'update_date' => $this->_date(),
            'update_ip' => $this->input->ip_address(),
        );

        return $this->_update_comment( $comment_id, $comment) ? TRUE : FALSE;
    }

    /**
     * Report Comment.
     *
     * Allows a user to report a comment.
     *
     * @param       integer     $comment_id
     * @param       array       $data
     * @return      mixed
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function report_comment($comment_id, $data)
    {
        // Build the data.
        $data = array(
            'flag' => 1,
            'report_reason' => $data['reason'],
            'report_date' => $this->_date(),
            'report_user_id' => $this->session->userdata('user_id'),
        );

        return ($this->_update_comment($comment_id, $data) === TRUE) ? TRUE : FALSE;
    }

    /**
     * Count User Comments
     *
     * Counts all the users comments that have not been flagged.
     *
     * @param       integer     $user_id
     * @return      int
     * @author      Chris Baines
     * @since       0.2.0
     */
    public function count_user_comments($user_id)
    {
        //Query.
        $query = $this->db->select('*')
            ->where('flag', '0')
            ->where('insert_user_id', $user_id)
            ->get($this->tables['comments']);

        // Result
        return $query->num_rows() > 0 ? $query->num_rows() : 0;
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

    /**
     * Report User.
     *
     * Allows a user to report another user..
     *
     * @param       integer     $user_id
     * @param       array       $data
     * @return      mixed
     * @author      Chris Baines
     * @since       0.2.0
     */
    public function report_user($user_id, $data)
    {
        // Build the data.
        $data = array(
            'reported' => 1,
            'report_reason' => $data['reason'],
            'report_date' => $this->_date(),
            'report_user_id' => $this->session->userdata('user_id'),
        );

        return ($this->ion_auth->update($user_id, $data) === TRUE) ? TRUE : FALSE;
    }

    /*****************************************************************************************
     * Misc Functions
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
    public function get_row( $row, $field, $where, $table )
    {
        return $this->_get_row( $row, $field, $where, $table );
    }

    /*****************************************************************************************
     * Language Functions
     *****************************************************************************************/
    public function get_languages()
    {
        // Query.
        $query = $this->db->select('*')
            ->get($this->tables['languages']);

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    public function add_language($data = array())
    {
        return $this->_insert($this->tables['languages'], $data);
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

    private function _update_comment( $comment_id, $data )
    {
        return $this->_update( 'comment_id', $comment_id, $this->tables['comments'], $data );
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

    /**
     * Delete
     *
     * Deletes information from the database.
     *
     * @param       string      $field
     * @param       string      $where
     * @param       string      $table
     * @return      bool|null
     * @author      Chris Baines
     * @since       0.0.1
     *
     */
    private function _delete( $field, $where, $table )
    {
        $this->db->where($field, $where)
            ->delete($table);

        return $this->db->affected_rows() > 0 ? TRUE : NULL;
    }

}

