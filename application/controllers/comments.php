<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends Front_Controller {

    /**
     * Delete Comment
     *
     * @param       integer     $comment_id
     * @param       string      $category_slug
     * @param       string      $discussion_slug
     * @return      bool
     * @author      Chris Baines
     * @since       0.0.1
     */
    public function delete_comment( $comment_id, $category_slug, $discussion_slug )
    {
        // Start the database transaction.
        $this->db->trans_start();

        // Get the discussion ID.
        $discussion_id = $this->comments->get_row( 'discussion_id', 'comment_id', $comment_id );
        $category_id = $this->discussions->get_row( 'category_id', 'discussion_id', $discussion_id );
        $comment_count = $this->discussions->get_row( 'comment_count', 'discussion_id', $discussion_id);

        // Delete the comment.
        $this->comments->delete_comment( $comment_id );

        // Get all the comments for the discussion.
        $last_comment_id = $this->comments->get_previous_comment( $discussion_id );

        // Update for discussions.
        $update = array(
            'comment_count' => --$comment_count,
            'last_comment_id' => $last_comment_id,
        );

        // Update the discussion.
        $this->discussions->update( 'discussion_id', $discussion_id, $update );

        // Update for categories.
        $update = array(
            'comment_count' => --$comment_count,
            'last_comment_id' => $last_comment_id,
        );

        // Update the category.
        $this->categories->update( 'category_id', $category_id, $update );

        // End the database transaction.
        $this->db->trans_complete();

        if( $this->db->trans_status() === FALSE )
        {
            $this->db->trans_rollback();

            // Create a message.
            $this->messageci->set( lang('error_delete_comment'), 'error' );

            // Redirect.
            redirect( 'discussions/'.$category_slug.'/'.$discussion_slug.'' );
        }
        else
        {
            // Create a message.
            $this->messageci->set( lang('success_delete_comment'), 'success' );

            // Redirect.
            redirect( 'discussions/'.$category_slug.'/'.$discussion_slug.'' );
        }
    }
}