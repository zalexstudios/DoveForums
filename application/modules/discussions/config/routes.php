<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['discussions/reply/(:any)/(:any)'] = 'discussions/reply/$1/$2';
$route['discussions/(:any)/(:any)'] = 'discussions/view/$1/$2';
