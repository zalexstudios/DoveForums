<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Categories Model
 *
 * Version: 0.4.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  All the functions for the categories.
 *
 * Requirements: PHP5 or above
 *
 */

class Category_m extends MY_Model {

    public $_table = 'categories';
    public $primary_key = 'id';
}