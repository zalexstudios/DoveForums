<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Thumbs Model
 *
 * Version: 0.4.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  All the functions for the thumbs functions.
 *
 * Requirements: PHP5 or above
 *
 */

class Thumb_m extends MY_Model {

    public $_table = 'thumbs';
    public $primary_key = 'id';
}