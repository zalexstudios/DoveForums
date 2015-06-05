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

        $this->user_id = $config['group_id'];
        $this->achievement_triggers = $this->get_achievement_triggers();
    }

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

    public function get_triggers($action)
    {
        // Query.
        $query = $this->_ci->db->select('*')
            ->where('action', $action)
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

    public function award_achievement($achievement)
    {
        // Data.
        $data = array(
            'achievement_id' => $achievement['id'],
            'user_id' => $this->user_id,
            'date_received' => time(),
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
                    if($val['condition'] == $condition)
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
                    else
                    {
                        return FALSE;
                    }
                } else
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
