# DBGUI
   GUI for database (Laravel 7.x)
# Install
 - Install  Laravel 7.*
 - Copy  repository
 - Update app/Http/Kernel.php: add an element  'crud' => \App\Http\Middleware\CheckAdmin::class to $routeMiddleware array. 
 - Run migrations
