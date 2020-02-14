# DBGUI
   GUI for database (Laravel 6.x)
# Install

Update app/Http/Kernel.php: add an element  'crud' => \App\Http\Middleware\CheckAdmin::class to $routeMiddleware array. 

