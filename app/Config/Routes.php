<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('calendar', 'CalendarController::index');
$routes->post('calendar/crear', 'CalendarController::crear');
$routes->get('calendar/getevents', 'CalendarController::getevents');
$routes->get('calendar/eliminar/(:any)', 'CalendarController::eliminar/$1');
$routes->post('calendar/drop', 'CalendarController::drop');

