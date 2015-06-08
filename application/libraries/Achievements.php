<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Achievements Library
 *
 * Version: 0.3.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  A simple achievements library.
 *
 * Requirements: PHP5 or above
 *
 */

class Achievements {

    private $_ci;
    public $achievement_triggers = array();
    public $user_id;

    public function __construct($config)
    {
        $this->_ci =& get_instance();

        $this->user_id = $config['user_id'];
        $this->achievement_triggers = $this->get_achievement_triggers();
    }

    /**
     * Get Achievement Triggers
     *
     * Gets all the achievements triggers from the database.
     *
     * @return      array|bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_achievement_triggers()
    {
        // Query.
        $query = $this->_ci->db->select('DISTINCT(action)')
            ->get('achievement_triggers');

        // Result
        if($query->num_rows())
        {
            foreach($query->result_array() as $row)
            {
                $triggers[] = $row['action'];
            }

            return $triggers;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Get Triggers
     *
     * Gets all the achievement triggers for the supplied action.
     *
     * @param       string      $action
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_triggers($action)
    {
        // Query.
        $query = $this->_ci->db->where('action', $action)
            ->get('achievement_triggers');

        // Result.
        if($query->num_rows())
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Gets all triggers.
     *
     * Gets all the triggers and linked achievements
     * for the purpose of showing them in the admin panel.
     *
     * @return      object
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_all_triggers()
    {
        // Query.
        $query = $this->_ci->db->select('achievement_triggers.id, achievement_triggers.action, achievement_triggers.condition, achievement_triggers.achievement_id, achievements.name')
        ->join('achievements', 'achievements.id = achievement_triggers.achievement_id')
        ->get('achievement_triggers');

        // Result
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    /**
     * Get Achievement
     *
     * Gets a achievement from the database for the supplied
     * achievement_id
     *
     * @param       integer     $achievement_id
     * @return      array
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_achievement($achievement_id)
    {
        // Query.
        $query = $this->_ci->db->select('*')
            ->where('id', $achievement_id)
            ->limit(1)
            ->get('achievements');

        if($query->num_rows())
        {
            return $query->row_array();
        }
    }

    /**
     * Get Achievements.
     *
     * Gets all the achievements in the database for the
     * purpose of showing them in the admin panel/drop down boxes.
     *
     * @return      object
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function get_achievements()
    {
        // Query.
        $query = $this->_ci->db->get('achievements');

        // Result
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    public function get_user_achievements()
    {

        // Query
        $query = $this->_ci->db->select('achievements.name, achievements.description, achievements.points, user_achievements.date_received')
            ->join('achievements', 'achievements.id = user_achievements.achievement_id')
            ->where('user_achievements.user_id', $this->user_id)
            ->get('user_achievements');

        // Result.
        return $query->num_rows() > 0 ? $query->result() : NULL;
    }

    /**
     * Award Achievement
     *
     * Once the conditions have been met to award a achievement
     * this function handles updating the database and awarding
     * the achievement to the user.
     *
     * @param       array       $achievement
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function award_achievement($achievement)
    {
        // Data.
        $data = array(
            'achievement_id' => $achievement['id'],
            'user_id' => $this->user_id,
            'date_received' => $this->_date(),
        );

        if($this->_ci->db->insert('user_achievements', $data))
        {
            // Update the users score.
            $query = $this->_ci->db->select('points')
                ->where('id', $this->user_id)
                ->limit(1)
                ->get('users');

            // Result.
            if($query->num_rows())
            {
                $old_score = $query->row('points');
                $new_score = $old_score + $achievement['points'];

                $data = array(
                    'points' => $new_score,
                );

                $this->_ci->db->where('id', $this->user_id)
                    ->update('users', $data);

                if($this->_ci->db->affected_rows() > 0)
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            return FALSE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Give Achievement
     *
     * Checks for the supplied action from the triggers, if the action is
     * found it then compares the condition, if we have a match the achievement
     * is awarded.
     *
     * @param       string      $action
     * @param       integer     $condition
     * @return      array|bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function give_achievement($action, $condition)
    {
        if(in_array($action, $this->achievement_triggers))
        {
            // Does the condition match.
            $triggers = $this->get_triggers($action);

            foreach($triggers as $key => $val)
            {
                if(array_key_exists('condition', $val))
                {
                    if($condition == $val['condition'])
                    {
                        // Get the achievement.
                        $achievement = $this->get_achievement($val['achievement_id']);

                        $award = $this->award_achievement($achievement);

                        if($award === TRUE)
                        {
                            return $achievement;
                        }
                        else
                        {
                            return FALSE;
                        }
                    }
                }
                else
                {
                    return FALSE;
                }
            }
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Add Achievement
     *
     * Adds a achievement into the database.
     *
     * @param       array       $data
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function add_achievement($data=array())
    {
        $this->_ci->db->insert('achievements', $data);

        return $this->_ci->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /**
     * Delete Achievement.
     *
     * Removes a achievement from the database by
     * the supplied achievement_id.
     *
     * @param       integer     $achievement_id
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function delete_achievement($achievement_id)
    {
        $this->_ci->db->where('id', $achievement_id)
            ->delete('achievements');

        return $this->_ci->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /**
     * Update Achievement
     *
     * Updates a achievement in the database by the supplied
     * achievement_id.
     *
     * @param       integer     $achievement_id
     * @param       array       $data
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function update_achievement($achievement_id, $data=array())
    {
        $this->db->where('id', $achievement_id)
            ->update( 'achievements', $data);

        return $this->db->affected_rows() > 0 ? TRUE : NULL;
    }

    /**
     * Add Achievement Trigger
     *
     * Adds a achievement trigger into the database.
     *
     * @param       array       $data
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function add_achievement_trigger($data=array())
    {
        $this->_ci->db->insert('achievement_triggers', $data);

        return $this->_ci->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /**
     * Delete Achievement Trigger
     *
     * Removes a achievement trigger from the database
     * by the supplied trigger_id.
     *
     * @param       integer     $trigger_id
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function delete_achievement_trigger($trigger_id)
    {
        $this->_ci->db->where('id', $trigger_id)
            ->delete('achievement_triggers');

        return $this->_ci->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /**
     * Update Achievement Trigger
     *
     * Updates a achievement trigger by the supplied
     * trigger_id.
     *
     * @param       integer     $trigger_id
     * @param       array       $data
     * @return      bool
     * @author      Chris Baines
     * @since       0.3.0
     */
    public function update_achievement_trigger($trigger_id, $data = array())
    {
        $this->db->where('id', $trigger_id)
            ->update( 'achievement_triggers', $data);

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
        date_default_timezone_set ($this->_ci->config->item('default_timezone') );

        return date('Y-m-d G:i:s', time());
    }
}
