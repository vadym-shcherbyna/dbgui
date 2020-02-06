<?php
	
	// Index
	
	Route::get('/', function () {
		
		return redirect()->route('login');
		
	});
	
	// Auth
	
	Route::get('auth/login', 'auth\AuthController@loginForm')->name('login');
	
	Route::post('auth/login', 'auth\AuthController@loginPost');
	
	Route::get('auth/logout', 'auth\AuthController@logout')->name('logout');
	
	// Tables
	
	Route::post('crud/tables/add', 'crud\TableController@itemAddPost')->middleware('crud');
	
	Route::post('crud/tables/edit/{id}', 'crud\TableController@itemEditPost')->middleware('crud');
	
	Route::get('crud/tables/delete/{id}', 'crud\TableController@itemDelete')->middleware('crud'); 
	
	// Fields
	
	Route::post('crud/fields/add', 'crud\FieldController@itemAddPost')->middleware('crud');
	
	Route::post('crud/fields/edit/{id}', 'crud\FieldController@itemEditPost')->middleware('crud');
	
	Route::get('crud/fields/delete/{id}', 'crud\FieldController@itemDelete')->middleware('crud');
	
	// Crud
	
	Route::get('crud', 'crud\CRUDController@index')->name('crud')->middleware('crud');
	
	// List
	
	Route::get('crud/{table}', 'crud\CRUDController@itemsList')->middleware('crud');
	
	Route::get('crud/{table}/list', 'crud\CRUDController@itemsList')->middleware('crud');
	
	// List filter
	
	Route::get('crud/{table}/filter/{field}/value/{value}', 'crud\CRUDController@itemsListFilter')->middleware('crud');
	
	// Sorting
	
	Route::get('crud/{table}/sort/{field}/direction/{value}', 'crud\CRUDController@itemsListSorting')->middleware('crud');
		
	// Flag
	
	Route::get('crud/{table}/flag/{field}/id/{id}', 'crud\CRUDController@itemsListFlag')->middleware('crud');	
	
	// Pagination
	
	Route::get('crud/{table}/pagination/{value}', 'crud\CRUDController@itemsListPagination')->middleware('crud');
	
	// Add
	
	Route::get('crud/{table}/add', 'crud\CRUDController@itemAddGet')->middleware('crud');
	
	Route::post('crud/{table}/add', 'crud\CRUDController@itemAddPost')->middleware('crud');
	
	// Edit
	
	Route::get('crud/{table}/edit/{id}', 'crud\CRUDController@itemEditGet')->middleware('crud');
	
	Route::post('crud/{table}/edit/{id}', 'crud\CRUDController@itemEditPost')->middleware('crud');
	
	// Delete
	
	Route::get('crud/{table}/delete/{id}', 'crud\CRUDController@itemDelete')->middleware('crud');