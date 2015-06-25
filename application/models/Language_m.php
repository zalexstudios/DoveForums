<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Language Model
 *
 * Version: 0.4.0
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  All the functions for the languages.
 *
 * Requirements: PHP5 or above
 *
 */

class Language_m extends MY_Model {

    public $_table = 'language_packs';
    public $primary_key = 'id';
}