# DBGUI
   GUI for database (Laravel 7.x)
# Description
   Manage tables and columns
# Install
 - Install  Laravel 7.*
 
  - Install doctrine/dbal  for managing columns 
 
` composer require doctrine/dbal`

  - Install intervention/image  for process images 
 
` composer require intervention/image`
 
 - Copy  repository
 
 - Update app/Http/Kernel.php, add new middleware to $routeMiddleware array:
   
`'crud' => \App\Http\Middleware\CheckAdmin::class`
    
 - Run migrations
 # Code features
  - Migrations + seeding
  - Custom validation rules
  - Custom middleware  
