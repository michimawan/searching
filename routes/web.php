<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as' => 'solr.index', 'uses' => 'SolrsController@index']);
Route::get('/ping', ['as' => 'solr.ping', 'uses' => 'SolrsController@ping']);
Route::get('/search', ['as' => 'solr.search', 'uses' => 'SolrsController@search']);
Route::get('/create', ['as' => 'solr.create', 'uses' => 'SolrsController@create']);
Route::post('/store', ['as' => 'solr.store', 'uses' => 'SolrsController@store']);
