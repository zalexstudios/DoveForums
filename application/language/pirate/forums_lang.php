<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Name:  Forums Language
 * Language: English Pirate
 *
 * Version: 0.0.1
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  English Pirate language file..
 *
 * Requirements: PHP5 or above
 *
 */

// Buttons
$lang['btn_new_discussion'] = '<i class="fa fa-check"></i> Start a new Discussion';
$lang['btn_reply_discussion'] = '<i class="fa fa-quote-left"></i> Reply to `tis Discussion';
$lang['btn_thumbs_up'] = '<i class="fa fa-thumbs-o-up"></i>';
$lang['btn_send_pm'] = '<i class="fa fa-envelope-o"></i> PM';
$lang['btn_report'] = '<i class="fa fa-bullhorn"></i> Report';
$lang['btn_post_comment'] = 'Post Reply';
$lang['btn_register'] = 'Register';
$lang['btn_send_pm'] = 'Send PM';
$lang['btn_edit_discussion'] = '<i class="fa fa-pencil"></i> Edit';
$lang['btn_delete_discussion'] = '<i class="fa fa-trash-o"></i> Delete';
$lang['btn_edit_comment'] = '<i class="fa fa-pencil"></i> Edit';
$lang['btn_delete_comment'] = '<i class="fa fa-trash-o"></i> Delete';
$lang['btn_add_user'] = 'Add User';
$lang['btn_edit'] = '<i class="fa fa-pencil"></i>';
$lang['btn_delete'] = '<i class="fa fa-trash-o"></i>';
$lang['btn_password'] = '<i class="fa fa-key"></i>';
$lang['btn_update_user'] = 'Update User';
$lang['btn_create_discussion'] = 'Create Discussion';
$lang['btn_add_category'] = 'Add Category';
$lang['btn_update_category'] = 'Update Category';
$lang['btn_view'] = '<i class="fa fa-eye"></i>';
$lang['btn_update_discussion'] = 'Update Discussion';
$lang['btn_update_comment'] = 'Update Comment';
$lang['btn_report_discussion'] = 'Report Discussion';
$lang['btn_report_comment'] = 'Report Comment';
$lang['btn_change_password'] = 'Change Password';
$lang['btn_reset_password'] = 'Reset Password';
$lang['btn_login'] = 'Login';
$lang['btn_forgot_password'] = 'Forgot Password';
$lang['btn_add_group'] = 'Add Group';
$lang['btn_edit_group'] = 'Edit Group';
$lang['btn_update_settings'] = 'Update Settings';
$lang['btn_add_language'] = 'Add Language';

// Success Messages.
$lang['success_login'] = 'Yarr, welcome aboard!';
$lang['success_logout'] = 'Be Seeying ya Matey';
$lang['success_creating_comment'] = 'Your comment has been created.';
$lang['success_register'] = 'Ahoy, Welcome Aboard Landlubber!';
$lang['success_delete_comment'] = 'The comment has been deleted.';
$lang['success_user_activation'] = 'The user has been activated.';
$lang['success_user_deactivation'] = 'The user has been deactivated';
$lang['success_add_user'] = 'The user <strong>%s</strong> has been created.';
$lang['success_update_user'] = 'The user <strong>%s</strong> has been updated.';
$lang['success_delete_user'] = 'Pirate <strong>%s</strong> Sent to Davy Jones\' Locker';
$lang['success_create_discussion'] = 'Your discussion has been created.';
$lang['success_delete_category'] = 'The category has been deleted.';
$lang['success_add_category'] = 'The category <strong>%s</strong> has been created.';
$lang['success_update_category'] = 'The category <strong>%s</strong> has been updated.';
$lang['success_delete_discussion'] = 'The discussion has been removed.';
$lang['success_update_discussion'] = 'The discussion <strong>%s</strong> has been updated.';
$lang['success_update_comment'] = 'The comment has been updated.';
$lang['success_delete_comment'] = 'The comment has been removed.';
$lang['success_report_discussion'] = 'The discussion has been reported.';
$lang['success_report_comment'] = 'The comment has been reported.';
$lang['success_update_settings'] = 'The settings have been updated.';
$lang['success_add_language'] = 'The language pack has been added.';

// Error Messages
$lang['error_slug'] = 'There was no slug supplied, please try again!';
$lang['error_login'] = 'There has been a problem logging you in, please try again!';
$lang['error_creating_comment'] = 'There has been a problem creating the comment, please try again!';
$lang['error_updating_discussions'] = 'There has been a problem updating the discussions table.';
$lang['error_posting_comment'] = 'There has been a problem entering the comment into the comments table.';
$lang['error_register'] = 'Avast, Unable to Commandeer Ship';
$lang['error_login_required'] = 'Sorry, you need to be logged in to perform this action!.';
$lang['error_delete_comment'] = 'There has been a problem deleting the comment!.';
$lang['error_invalid_id'] = 'Invalid ID supplied!.';
$lang['error_admin_required'] = 'You are not a Administrator!';
$lang['error_user_activation'] = 'There was a problem activating the user.';
$lang['error_user_deactivation'] = 'There was a problem deactivating the user.';
$lang['error_add_user'] = 'There was a problem creating the user.';
$lang['error_update_user'] = 'There was a problem updating the user <strong>%s</strong>.';
$lang['error_delete_user'] = 'Avast, The Pirate <strong>%s</strong> be Still Alive';
$lang['error_create_discussion'] = 'There was a problem creating your discussion.';
$lang['error_not_deletable'] = 'This item is not deletable.';
$lang['error_delete_category'] = 'There was a problem removing the category.';
$lang['error_add_category'] = 'There was a problem creating the category.';
$lang['error_update_category'] = 'There was a problem updating the category <strong>%s</strong>.';
$lang['error_discussion_owner'] = 'You are not the owner of this discussion!.';
$lang['error_delete_discussion'] = 'There was a problem removing the discussion.';
$lang['error_update_discussion'] = 'There was a problem updating the discussion <strong>%s</strong>.';
$lang['error_update_comment'] = 'There was a problem updating the comment.';
$lang['error_delete_comment'] = 'There was a problem removing the comment.';
$lang['error_report_discussion'] = 'There was a problem reporting the discussion.';
$lang['error_report_comment'] = 'There was a problem reporting the comment.';
$lang['error_update_settings'] = 'There was a problem updating the settings.';
$lang['error_add_language'] = 'There was a problem adding the language pack.';

// Form Rules
$lang['rules_comment'] = 'Comment';
$lang['rules_email'] = 'Email';
$lang['rules_password'] = 'Password';
$lang['rules_username'] = 'Username';
$lang['rules_confirm_password'] = 'Confirm Password';
$lang['rules_confirm_email'] = 'Confirm Email';
$lang['rules_subject'] = 'Subject';
$lang['rules_message'] = 'Message';
$lang['rules_body'] = 'Body';
$lang['rules_category'] = 'Category';
$lang['rules_name'] = 'Name';
$lang['rules_description'] = 'Description';
$lang['rules_reason'] = 'Report Reason';
$lang['rules_old_password'] = 'Old Password';
$lang['rules_new_password'] = 'New Password';
$lang['rules_confirm_new_password'] = 'Confirm New Password';
$lang['rules_site_name'] = 'Site Name';
$lang['rules_site_email'] = 'Site Email';
$lang['rules_site_keywords'] = 'Site Keywords';
$lang['rules_site_description'] = 'Site Description';

// Table Headers
$lang['tbl_username'] = 'Username';
$lang['tbl_first_name'] = 'First Name';
$lang['tbl_last_name'] = 'Last Name';
$lang['tbl_status'] = 'Status';
$lang['tbl_action'] = 'Action';
$lang['tbl_name'] = 'Name';
$lang['tbl_discussion_count'] = 'Discussions';
$lang['tbl_comment_count'] = 'Comments';
$lang['tbl_slug'] = 'Slug';
$lang['tbl_description'] = 'Description';
$lang['tbl_language'] = 'Language';
$lang['tbl_code'] = 'Code';
$lang['tbl_icon'] = 'Icon';