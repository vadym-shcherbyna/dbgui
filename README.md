# DBGUI
Data Management System based on Laravel 7.x.
# Description
Data set management: create sets, edit and delete data. 
Searching, sorting and filtering data. 
Different types of fields: string, number, date, flag, image (local storage and AWS S3).
# Installation
**1. Install  Laravel 7.***
 
 **2. Copy  repository**
 
 **3. Install migrations**
 
 Run `php artisan migrate`
 
**4. Install doctrine/dbal  for managing columns** 
 
Run ` composer require doctrine/dbal`

**5. Install intervention/image for processing local images** 
 
Run ` composer require intervention/image`

After you have installed Intervention Image, open your Laravel config file `config/app.php` and add the following lines.

In the $providers array add the service providers for this package.
  
`Intervention\Image\ImageServiceProvider::class`

Add the facade of this package to the $aliases array.
  
`'Intervention' => Intervention\Image\Facades\Image::class`
 
 **6. Add custom middleware**
   
Update `app/Http/Kernel.php`, add new middlewares to `$routeMiddleware` array:   
   
`'crud' => \App\Http\Middleware\CheckAdmin::class,`

`'lang' => \App\Http\Middleware\SetLang::class,`		    

 **7. Login into system**
 
Start page http://{your_domain}/auth/login

Login with any email and password. First log in will create admin account with your credentials.

 # Code features
  - Migration + seeding
  - Custom validation rules
  - Custom middleware  
  - Localization
