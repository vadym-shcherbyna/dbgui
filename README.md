# DBGUI
   GUI for database (Laravel 7.x)
# Install
 - Install  Laravel 7.*
 - Copy  repository
 - Update app/Http/Kernel.php, add new middleware to $routeMiddleware array:   
   `'crud' => \App\Http\Middleware\CheckAdmin::class` 
 - Run migrations