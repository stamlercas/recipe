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

Route::get('/{username}/saved', [
    'uses' => 'UserController@saved',
    'as' => 'user.saved',
    'middleware' => 'auth'
]);

Route::get('/{username}/activity', [
    'uses' => 'UserController@getActivity',
    'as' => 'user.activity',
    'middleware' => 'auth'
]);

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

Route::get('/pantry', [
	'uses' => 'PantryController@index',
	'as' => 'pantry',
]);

Route::get('/pantry/delete/{pantry_id}', [
    'uses' => 'PantryController@delete',
    'as' => 'pantry.delete',
    'middleware' => 'auth'
]);

Route::post('/pantry/add', [
    'uses' => 'PantryController@add',
    'as' => 'pantry.add',
    'middleware' => 'auth'
]);

Route::post('/pantry/edit', [
    'uses' => 'PantryController@edit',
    'as' => 'pantry.edit',
    'middleware' => 'auth'
]);

Route::post('/pantry/search', [
    'uses' => 'PantryController@search',
    'as' => 'pantry.search',
    'middleware' => 'auth'
]);

Route::get('/recipe/{recipe_id}', [
    'uses' => 'RecipeController@get',
    'as' => 'recipe.get',
    'middleware' => 'auth'
]);

Route::post('/recipe/made', [
    'uses' => 'RecipeController@made',
    'as' => 'recipe.made'
]);

Route::post('/recipe/save', [
    'uses' => 'RecipeController@save',
    'as' => 'recipe.save'
]);

Route::get('/search', [
    'uses' => 'RecipeController@index',
    'as' => 'search.index',
    'middleware' => 'auth'
]);

Route::get('/search/results', [
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