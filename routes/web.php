<?php

// Index
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth controllers
Route::get('auth/login', 'auth\AuthController@loginForm')->name('login');
Route::post('auth/login', 'auth\AuthController@loginPost');
Route::get('auth/logout', 'auth\AuthController@logout')->name('logout');

// Overriding controller for  settings
Route::get('crud/settings', 'crud\SettingController@form')->middleware('crud');
Route::get('crud/settings/list', 'crud\SettingController@form')->middleware('crud');
Route::post('crud/settings', 'crud\SettingController@save')->middleware('crud');

// Overriding controllers for  tables' section
Route::post('crud/tables/add', 'crud\TableController@tableAddPost')->middleware('crud');
Route::post('crud/tables/edit/{id}', 'crud\TableController@tableEditPost')->middleware('crud');
Route::get('crud/tables/delete/{id}', 'crud\TableController@tableDelete')->middleware('crud');

// Overriding controllers for  fields' section
Route::post('crud/fields/add', 'crud\FieldController@fieldAddPost')->middleware('crud');
Route::post('crud/fields/edit/{id}', 'crud\FieldController@fieldEditPost')->middleware('crud');
Route::get('crud/fields/delete/{id}', 'crud\FieldController@fieldDelete')->middleware('crud');

// Crud index (list)
Route::get('crud', 'crud\CRUDController@index')->name('crud')->middleware('crud');

// List of  items
Route::get('crud/{table}', 'crud\CRUDController@itemsList')->middleware('crud');
Route::get('crud/{table}/list', 'crud\CRUDController@itemsList')->middleware('crud');

// Set filter
Route::get('crud/{table}/filter/{field}/value/{value}', 'crud\CRUDController@itemsListFilter')->middleware('crud');

// Pagination
Route::get('crud/{table}/numrows/{value}', 'crud\CRUDController@itemsListNumRows')->middleware('crud');

// Sorting
Route::get('crud/{table}/sort/{field}/direction/{value}', 'crud\CRUDController@itemsListSorting')->middleware('crud');

// Set flags
Route::get('crud/{table}/flag/{field}/id/{id}', 'crud\CRUDController@itemsListFlag')->middleware('crud');

// Add item
Route::get('crud/{table}/add', 'crud\CRUDController@itemAddGet')->middleware('crud');
Route::post('crud/{table}/add', 'crud\CRUDController@itemAddPost')->middleware('crud');

// Edit item
Route::get('crud/{table}/edit/{id}', 'crud\CRUDController@itemEditGet')->middleware('crud');
Route::post('crud/{table}/edit/{id}', 'crud\CRUDController@itemEditPost')->middleware('crud');

// Delete item
Route::get('crud/{table}/delete/{id}', 'crud\CRUDController@itemDelete')->middleware('crud');