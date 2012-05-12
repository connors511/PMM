<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	'admin/scan/(:num)' => 'admin/scan/$1',
	'admin/(:segment)(/:num)' => 'admin/$1/$2'
);