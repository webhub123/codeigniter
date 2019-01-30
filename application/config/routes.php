<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['query/(:any)'] = 'query_controller/query/$1';
$route['dashboard'] = 'welcome/dashboard';
$route['log_checker'] = 'welcome/log_checker';
$route['change_password'] = 'welcome/change_password';
$route['late_report'] = 'welcome/late_report';
$route['export_rpt/(:any)/(:any)/(:any)'] = 'query_controller/export_rpt/$1/$2/$3';


$route['register'] = 'welcome/register';
$route['login'] = 'welcome/login';

