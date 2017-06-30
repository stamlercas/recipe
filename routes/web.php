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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', function () {
    if (Auth::check())
    {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', [
    'uses' => 'DashboardController@getDashboard',
    'as' => 'dashboard',
    'middleware' => 'auth'
]);

Route::get('/grocery-lists', [
    'uses' => 'GroceryListController@index',
    'as' => 'grocery_lists'
]);

Route::post('/grocery-list/create', [
    'uses' => 'GroceryListController@create',
    'as' => 'grocery_list.create'
]);

Route::get('/grocery-list/{username}/{grocery_list_slug}', [
    'uses' => 'GroceryListController@get',
    'as' => 'grocery_list.get'
]);

Route::post('/grocery-list/{username}/{grocery_list_slug}/add', [
    'uses' => 'GroceryListController@addIngredient',
    'as' => 'grocery_list.add'
]);

Route::post('/grocery-list/{username}/{grocery_list_slug}/close', [
    'uses' => 'GroceryListController@close',
    'as' => 'grocery_list.close'
]);

Route::get('/inventory', [
	'uses' => 'InventoryController@index',
	'as' => 'inventory',
]);

Route::get('/inventory/delete/{inventory_id}', [
    'uses' => 'InventoryController@delete',
    'as' => 'inventory.delete',
    'middleware' => 'auth'
]);

Route::post('/inventory/add', [
    'uses' => 'InventoryController@add',
    'as' => 'inventory.add',
    'middleware' => 'auth'
]);

Route::post('/inventory/edit', [
    'uses' => 'InventoryController@edit',
    'as' => 'inventory.edit',
    'middleware' => 'auth'
]);

Route::post('/inventory/search', [
    'uses' => 'InventoryController@search',
    'as' => 'inventory.search',
    'middleware' => 'auth'
]);

Route::get('/recipe/{recipe_id}', [
    'uses' => 'RecipeController@get',
    'as' => 'recipe.get',
    'middleware' => 'auth'
]);

Route::get('/search', [
    'uses' => 'RecipeController@index',
    'as' => 'search.index',
    'middleware' => 'auth'
]);

Route::post('/search/results', [
    'uses' => 'RecipeController@search',
    'as' => 'search.results',
    'middleware' => 'auth'
]);

Route::get('/settings', [
    'uses' => 'SettingsController@index',
    'as' => 'settings',
    'middleware' => 'auth'
]);

Route::post('/settings/update', [
    'uses' => 'SettingsController@update',
    'as' => 'settings.update',
    'middleware' => 'auth'
]);