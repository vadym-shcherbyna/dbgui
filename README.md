# DBGUI
GUI for database (Laravel 7.x).
# Description
Graphical user interface for database: creating, editing, deleting  tables and columns. Implementing custom types of data.
# Installation
**1. Install  Laravel 7.***
 
**2. Install doctrine/dbal  for managing columns** 
 
Run ` composer require doctrine/dbal`

**3. Install intervention/image  for process images** 
 
Run ` composer require intervention/image`

In the $providers array add the service providers for this package.
  
`Intervention\Image\ImageServiceProvider::class`

Add the facade of this package to the $aliases array.
  
`'Image' => Intervention\Image\Facades\Image::class`

Add Setting in config/filesystem.php 
 
        'imagelocal' => [
            'driver' => 'local',
            'root' => storage_path('app/public/imagelocal'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
 
 **4. Copy  repository**
 
 **5. Update app/Http/Kernel.php, add new middleware to $routeMiddleware array:**
   
Add `'crud' => \App\Http\Middleware\CheckAdmin::class`
    
**6. Run migrations**

 # Code features
  - Migrations + seeding
  - Custom validation rules
  - Custom middleware  
