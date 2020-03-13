# DBGUI
   GUI for database (Laravel 7.1.1)
# Install
Update app/Http/Kernel.php: add an element  'crud' => \App\Http\Middleware\CheckAdmin::class to $routeMiddleware array. 

