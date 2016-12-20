# ProVision/Pages Module

[ProVision Administration](https://github.com/ProVisionBG/administration) Pages module

# Installation

`composer require provision/pages`

then include provider to config/app.php

 `\ProVision\Pages\Providers\ModuleServiceProvider::class`

and run migration

`php artisan admin:migrate`
