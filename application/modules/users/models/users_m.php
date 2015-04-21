<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_m extends CI_Model {

    public function update($data=array(), $user_id)
    {
        $this->db->where('id', $user_id)
            ->update('users', $data);
    }

}