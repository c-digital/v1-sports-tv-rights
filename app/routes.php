<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register routes for your application. These
| routes are loaded by the RoutingServiceProvider. Now create something great!
|
*/

// Home
$route->get('/', [HomeController::class, 'index']);

// Auth
$route->auth();

// Dashboard
$route->get('/dashboard', [DashboardController::class, 'index']);

$route->get('/bolivia/liga', [BoliviaController::class, 'liga']);
$route->get('/bolivia/copa', [BoliviaController::class, 'copa']);

$route->get('/españa/liga', [EspañaController::class, 'liga']);
$route->get('/españa/copa', [EspañaController::class, 'copa']);

$route->get('/inglaterra/liga', [InglaterraController::class, 'liga']);

$route->get('/europa/champions', [EuropaController::class, 'champions']);
$route->get('/europa/europa', [EuropaController::class, 'europa']);

$route->get('/italia/liga', [ItaliaController::class, 'liga']);
$route->get('/argentina/liga', [ArgentinaController::class, 'liga']);
$route->get('/francia/liga', [FranciaController::class, 'liga']);
$route->get('/alemania/liga', [AlemaniaController::class, 'liga']);

$route->get('/export', [ExportController::class, 'index']);
$route->post('/export', [ExportController::class, 'export']);

$route->get('/export/standings/{league}', [ExportController::class, 'standings']);
$route->get('/export/fixture/{league}/{round}', [ExportController::class, 'fixture']);
$route->get('/export/lineups/{fixture}', [ExportController::class, 'lineups']);
$route->get('/export/stats/{fixture?}', [ExportController::class, 'stats']);
$route->get('/export/score/{fixture}', [ExportController::class, 'score']);
$route->get('/export/referees/{fixture}', [ExportController::class, 'referees']);

// Users
$route->resource('/dashboard/users', UserController::class);
