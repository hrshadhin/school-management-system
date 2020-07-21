## CloudSchool

[![license](https://img.shields.io/badge/license-AGPL-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)
[![php](https://img.shields.io/badge/php-7.2-brightgreen.svg?logo=php)](https://www.php.net)
[![laravel](https://img.shields.io/badge/laravel-6.x-orange.svg?logo=laravel)](https://laravel.com)

Another School Management System build with Laravel and PHP 7

## Index

- [Query](#have-a-query)
- [Demo](#demo)
- [Features](#features)
- [Installation](#installation)
    - [Installing dependencies](#installing-dependencies)
    - [Download and setup](#download-and-setup)
    - [Use the app](#use-the-app)
- [Documentation](#documentation)
- [Changelog/Timeline](#timeline)
- [Screenshot](#screenshot)
- [Issues](#issues)
- [License](#license)

## Have a query
[:arrow_up: Back to top](#index)

:mega: Join our discord channel: [CloudSchool](https://discord.gg/7rXyuu8):mega:

:mega: Send us an email: [info@cloudschoolbd.com](mailto:info@cloudschoolbd.com):mega:

## Demo
[:arrow_up: Back to top](#index)

- Website: [http://ce.cloudschoolbd.com](http://ce.cloudschoolbd.com)
- App login: [http://ce.cloudschoolbd.com/login](http://ce.cloudschoolbd.com/login)

    Username    | Password
    ------------|:-----------
    superadmin  | super99
    admin       | demo123

## Features
[:arrow_up: Back to top](#index)

- Academic Year manage 
- Academic Calendar Setup
- Institute Setup
- Class & Section Manage
- Subject & Teacher Manage
- Student Admission
- Student Attendance
- Exam & Grading Rules
- Marks & Result
- Student Promotion
- Employees Manage
- Employees Attendance
- Employees Leave
- User & Role manage with permission grid(ACL)
- User wise Dashboard
- Report Settings
- Only 5 Reports
- Dynamic Front Website
- Website Management Panel
- Photo Gallery
- Event Manage
- Google Analytics
- User Notification



## Installation
[:arrow_up: Back to top](#index)

#### Installing dependencies

- PHP >= 7.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- MySQL >= 5.6 `OR` MariaDB >= 10.1
- [hrshadhin/laravel-userstamps](https://github.com/hrshadhin/laravel-userstamps.git) [**Already Installed**]
- NodeJS, npm, webpack

#### Download and setup

- Download source code

- change directory
    ```
    $ cd cloudschool
    ```
- Copy sample `env` file and change configuration according to your need in ".env" file and create Database
    ```
    $ cp .env.example .env
    ```
- Install php libraries
    ```
    $ composer install
    ```
 - Setup application 
    - Method 1: By one command
         ```
         # setup cloudschool with out demo data
         $ php artisan fresh-install
       
         # setup cloudschool with demo data
         $ php artisan fresh-install --with-data
          # OR
         $ php artisan fresh-install -d
         ```
    - Method 2: Step by step
        ```
        $ php artisan storage:link
        $ php artisan key:generate --ansi
      
        # Create database tables and load essential data
        $ php artisan migrate
        $ php artisan db:seed
      
        # Load demo data
        $ php artisan db:seed --class DemoSiteDataSeeder
        $ php artisan db:seed --class DemoAppDataSeeder
      
        # Clear all caches
        $ php artisan view:clear
        $ php artisan route:clear
        $ php artisan config:clear
        $ php artisan cache:clear
        ```
- Install frontend(css,js) dependency libraries and bundle them
    ```
    $ npm install
    $ npm run backend-prod
    $ npm run frontend-prod
    ```
- Start development server
    ```
    $ php artisan serve
    ```

#### Use the app
[:arrow_up: Back to top](#index)

- Website: [http://localhost:8000](http://localhost:8000)
- App login: [http://localhost:8000/login](http://localhost:8000/login)

    Username    | Password
    ------------|:-----------
    superadmin  | super99
    admin       | demo123

## Documentation

[Check Here](http://ugc.cloudschoolbd.com)

## Timeline
[Check Here](CHANGELOG.md)

## Screenshot
[:arrow_up: Back to top](#index)

- ![Dashboard](../assets/screenshots/ce/dashboard.png?raw=true)
- **[More...](../assets/screenshots/ce/showme.md)**


## Issues
[:arrow_up: Back to top](#index)

If you discover bug or security vulnerability within CloudSchool app, please send an e-mail to [sos@cloudschoolbd.com](mailto:sos@cloudschoolbd.com). All security vulnerabilities will be promptly addressed.

## License
[:arrow_up: Back to top](#index)

Copyright (c) the respective developers and maintainers, as shown by the AUTHORS file.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published
by the Free Software Foundation, either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

All Frameworks and libraries are distributed with it's own license.

**As it is a free(free as in freedom) software. To keep the credit for this works, you should
not remove application footer information text**

**Why AGPL? [Read Here](https://www.gnu.org/licenses/why-affero-gpl.html)**