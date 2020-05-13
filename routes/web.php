<?php

// Index
Route::get('/', function () {
    return redirect()->route('auth.login');
});

# Languages
Route::get('/lang/{code}', 'crud\LangController@lang')->name('lang');

Route::group(['middleware' => ['lang']], function ()
{
    // Auth controllers
    Route::get('auth/login', 'crud\AuthController@loginForm')->name('auth.login');
    Route::post('auth/login', 'crud\AuthController@loginPost');
    Route::get('auth/logout', 'crud\AuthController@logout')->name('auth.logout');

    Route::group(['middleware' => ['crud']], function ()
    {
        // Crud index (list)
        Route::get('crud', 'crud\CRUDController@dashboard')->name('dashboard');

        // Overriding controller for  settings
        Route::get('crud/settings/list', 'crud\SettingController@form')->name('settings.list');
        Route::post('crud/settings/list', 'crud\SettingController@save');
        Route::get('crud/settings/default', 'crud\SettingController@default')->name('settings.default');

        // Overriding controllers for  tables' section
        Route::post('crud/tables/add', 'crud\TableController@tableAddPost');
        Route::post('crud/tables/edit/{id}', 'crud\TableController@tableEditPost');
        Route::get('crud/tables/delete/{id}', 'crud\TableController@tableDelete');

        // Overriding controllers for  fields' section
        Route::post('crud/fields/add', 'crud\FieldController@fieldAddPost');
        Route::post('crud/fields/edit/{id}', 'crud\FieldController@fieldEditPost');
        Route::get('crud/fields/delete/{id}', 'crud\FieldController@fieldDelete');

        // List of  items
        Route::get('crud/{table}/list', 'crud\CRUDController@itemsList')->name('items.list');

        // Add item
        Route::get('crud/{table}/add', 'crud\CRUDController@itemAddGet')->name('items.add');
        Route::post('crud/{table}/add', 'crud\CRUDController@itemAddPost');

        // Edit item
        Route::get('crud/{table}/edit/{id}', 'crud\CRUDController@itemEditGet')->name('items.edit');
        Route::post('crud/{table}/edit/{id}', 'crud\CRUDController@itemEditPost');

        // Delete
        Route::get('crud/{table}/delete/{id}', 'crud\CRUDController@itemDelete')->name('items.delete');

        // Update flags
        Route::get('crud/{table}/flag/{field}/id/{id}', 'crud\CRUDController@itemsListFlag')->name('items.flag');

        // Filters, sorting, pagination
        Route::get('crud/{table}/filter/{field}/value/{value}', 'crud\CRUDController@itemsListFilter')->name('items.filter');
        Route::get('crud/{table}/numrows/{value}', 'crud\CRUDController@itemsListNumRows')->name('items.numrows');
        Route::get('crud/{table}/sort/{field}/direction/{value}', 'crud\CRUDController@itemsListSorting')->name('items.sort');
    });
});