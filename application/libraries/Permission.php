<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Permission Library
 *
 * Version: 0.3.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  A simple permission library for setting group permissions..
 *
 * Requirements: PHP5 or above
 *
 */

class Permission {

    // Set some variables.
    private $_ci;
    public $group_id;
    public $permissions = array();

    /**
     * Construct Function
     *
     * The construct functions, requires a config to be set.
     *
     * @param       array       $config
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function __construct($config)
    {
        $this->_ci =& get_instance();

        $this->group_id = (!empty($config['group_id']) ? $config['group_id'] : 1);

        $this->permissions = $this->get_user_permissions($this->group_id);
    }

    /**
     * Get User Permissions
     *
     * Gets the permissions for the supplied group_id.
     *
     * @param       integer     $group_id
     * @return      array|bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_user_permissions($group_id)
    {
        // Get the keys from the database.
        $query = $this->_ci->db->select('key')
            ->join('permissions', 'permissions.permission_id = permission_map.permission_id')
            ->where('group_id', $group_id)
            ->get('permission_map');

        // Create the permissions array and return.
        if ($query->num_rows() )
        {
            foreach($query->result_array() as $row)
            {
                $permissions[] = $row['key'];
            }

            return $permissions;
        } else {
            return FALSE;
        }
    }

    /**
     * Get Permissions
     *
     * Gets all the permissions or permissions from a group for the purpose of
     * listing in a form.
     *
     * @param       integer        $group_id
     * @return      array
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_permissions($group_id = NULL)
    {
        $this->_ci->db->select('*');

        // If a group id is supplied select for that group.
        if (!empty($group_id))
        {
            $this->_ci->db->where_in('key', $this->get_user_permissions($group_id));
        }

        // Set the order.
        $this->_ci->db->order_by('category', 'asc');

        // Query
        $query = $this->_ci->db->get('permissions');

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    /**
     * Get Perms From Cat
     *
     * Gets all the permissions from a category name, for the purpose of
     * listing in a form.
     *
     * @param       string       $category
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_perms_from_cat($category = NULL)
    {
        if(!empty($category))
        {
            $this->_ci->db->where('category', $category);
        }

        // Query.
        $query = $this->_ci->db->get('permissions');

        // Result.
        return ($query->num_rows() > 0 ? $query->result() : FALSE);
    }

    /**
     * Get Permission Map
     *
     * Gets the map of keys for the supplied group_id.
     *
     * @param       integer     $group_id
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_permission_map($group_id)
    {
        // Get the keys.
        $query = $this->_ci->db->select('permission_id')
            ->where('group_id', $group_id)
            ->get('permission_map');

        return ($query->num_rows() > 0 ? $query->result() : FALSE);
    }

    /**
     * Add Permissions
     *
     * Adds permissions for a group.
     *
     *
     * @param       integer     $group_id
     * @param       array       $data
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function add_permissions($group_id, $data=array())
    {
        // Delete all permissions for this group first.
        $this->_ci->db->where('group_id', $group_id)
            ->delete('permission_map');

        foreach($data as $key => $value)
        {
            if(preg_match('/^perm([0-9]+)/i', $key, $matches))
            {
                $this->_ci->db->set('group_id', $group_id)
                    ->set('permission_id', $matches[1])
                    ->insert('permission_map');
            }
        }

        return TRUE;
    }

    /**
     * Has Permission.
     *
     * Checks if the user has permission.
     *
     * @param       string      $key
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function has_permission($key)
    {
        if(!empty($this->permissions))
        {
            return (!in_array($key, $this->permissions) ? FALSE : TRUE);
        }

        return FALSE;
    }
}