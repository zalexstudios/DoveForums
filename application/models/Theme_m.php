<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Themes Model
 *
 * Version: 0.4.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  All the functions for the themes.
 *
 * Requirements: PHP5 or above
 *
 */

class Theme_m extends MY_Model {

    public $_table = 'themes';
    public $primary_key = 'id';
}