# DBGUI
   GUI for database (Laravel 7.x)
# Desscription
   Manage tables and columns
# Install
 - Install  Laravel 7.*
 
  - Install doctrine/dbal  for managing columns 
 
` composer require doctrine/dbal`
 
 - Copy  repository
 
 - Update app/Http/Kernel.php, add new middleware to $routeMiddleware array:
   
`'crud' => \App\Http\Middleware\CheckAdmin::class`
    
 - Run migrations
 # Code features
  - Migrations + seeding
  - Custom validation rules
  - Custom middleware  
