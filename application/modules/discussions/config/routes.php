<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['discussions/(:any)/(:any)'] = 'discussions/view/$1/$2';