# CloudSchool
Another School Management System build with laravel and PHP 7

[![Codeship Status for hrshadhin/school-management-system](https://app.codeship.com/projects/09010350-b97f-0136-1477-5a7589b245e6/status?branch=master)](https://app.codeship.com/projects/312233)
[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)
[![Known Vulnerabilities](https://snyk.io/test/github/hrshadhin/school-management-system/badge.svg?targetFile=package.json)](https://snyk.io/test/github/hrshadhin/school-management-system?targetFile=package.json)


:loudspeaker:
**Notic:**  Now its version [v3.0.0](https://github.com/hrshadhin/school-management-system/releases/tag/v3.0.0) (community edition)
. If you need PHP 5 support then use version [v1.0](https://github.com/hrshadhin/school-management-system/releases/tag/v1.0)
For Enterprise edition checkout here [EE](https://github.com/hrshadhin/school-management-system/tree/empty)

# Join Our Discord Server
:mega:[CloudSchool](https://discord.gg/7rXyuu8):mega:


# Help/Bug Report
- If you discover a security vulnerability within CloudSchool app, please send an e-mail to [hello@hrshadhin.me](mailto:hello@hrshadhin.me) or [sos@cloudschoolbd.com](mailto:sos@cloudschoolbd.com). All security vulnerabilities will be promptly addressed.
- If you faced any problems, first check previous issue list. If doesn't exists then create a new one.
- For any help or bug report please create a issue here with proper details. i.e:
    - Which version of the app you are using?
    - What is your environment
        - Operating System
        - PHP, MySQL/MariaDB, NodeJS, Apache/Nginx version
        - Environment Dev/Production
        - Hosting Local/Cpanel/VPS
    - Screenshot of the application interface where found problem or need help
    - If its an error then paste full error log in issue details. i.e:
        ```
       The Mix manifest does not exist.
       (View: C:\xampp\htdocs\school-management-system\resources\views\backend\layouts\front_master.blade.php) 
      (View: C:\xampp\htdocs\school-management-system\resources\views\backend\layouts\front_master.blade.php)
        ```

# Features
|   Community Edition   |   Enterprise Edition   |
|-----------------------|:-------------------------:|
| Academic Year manage  | Academic Year manage   |
| Academic Calendar Setup | Academic Calendar Setup |
| Institute Setup | Institute Setup |
| Class & Section Manage | Class & Section Manage |
| Subject & Teacher Manage | Subject & Teacher Manage |
| Student Admission | Student Admission |
| Student Attendance |  Student Attendance |
| Exam & Grading Rules | Exam & Grading Rules |
| Makrs & Result | Easy Makrs Entry & Result Manage |
| Employees Manage | Employees Manage |
| Employees Attendance | Employees Attendance | 
| Employees Leave | Employees Leave |
| Employees Work Outside | Employees Work Outside |
| SMS Gateway Setup  | SMS Gateway Setup |
| Email & SMS Templating  | Email & SMS Templating |
| Attendance notification email/sms  | Attendance notification email/sms |
| Id Card templates Manage | Id Card templates Manage |
| Employee & Student id card print | Employee & Student id card print |
| User & Role manage with permision grid(ACL) | User & Role manage with permision grid(ACL) |
| User wise Dashboard | User wise Dashboard
| Report Settings | Report Settings |
| Only 5 Reports | **40+** Reports |
| Dynamic Front Website | Dynamic Front Website |
| Website Management Panel |  Website Management Panel
| Photo Gallery | Photo Gallery | 
| Event Manage | Event Manage |
| Google Analytics | Google Analytics |
| User Notification | User Notification |
|                   | Online Admission |
|                   | Online Admit Card & Payslip |
|                   | Student Promotion |
|                   | Notice Board |
|                   | Student & Employee Id card bulk/mass print |
|                   | Account Manage |
|                   | Budget Manage |
|                   | Account Heads |
|                   | Student Invoice |
|                   | Income / Expense Manage |
|                   | Payroll |
|                   | Salary Template |
|                   | Employee Salary Payment |
|                   | Hostel & Collection Manage |
|                   | Library Manage |
|                   | Issue book and fine collection |
|                   | Academic Calendar Print |
|                   | Bulk SMS and Email Sending |
|                   | **40+** Reports |

# Installation and use

**Dependency**
- PHP >= 7.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- MySQL >= 5.6 `OR` MariaDB >= 10.1
- [hrshadhin/laravel-userstamps](https://github.com/hrshadhin/laravel-userstamps.git)
- NodeJS, npm, webpack

**Installation**
 - Clone the repo
    ```
    $ git clone https://github.com/hrshadhin/school-management-system.git cloudschool
    ```
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
    ```
    $ php artisan storage:link
    ```
    ```
    $ php artisan key:generate --ansi
    ```
- Create database tables and load essential data
    ```
    $ php artisan migrate
    ```
    ```
    $ php artisan db:seed
    ```
- Load demo data
    ```
    $ php artisan db:seed --class DemoSiteDataSeeder
    ```
    ```
    $ php artisan db:seed --class DemoAppDataSeeder
    ```
- Clear cache
    ```
    $ sudo php artisan cache:clear
    ```
- Install frontend(css,js) dependency libraries and bundle them
    ```
    $ npm install
    ```
    ```
    $ npm run backend-prod
    ```
    ```
    $ npm run frontend-prod
    ```
- Start development server
    ```
    $ php artisan serve
    ```
- Use the app
    - Website: [http://localhost:8000](http://localhost:8000)
    - App login: [http://localhost:8000/login](http://localhost:8000/login)
    - username: admin
    - password: demo123

:loudspeaker: **N.B:**
- For sms and email processing you need to run laravel queue worker. `bin` folder has supervisor config for start queue worker with supervisor.

**Demo Community Edition (CE)**
- Website: [http://ce.cloudschoolbd.com](http://ce.cloudschoolbd.com)
- App login: [http://ce.cloudschoolbd.com/login](http://ce.cloudschoolbd.com/login)
- username: admin
- password: demo123

**Demo Enterprise Edition (EE)**
- Website: [http://ee.cloudschoolbd.com](http://ee.cloudschoolbd.com)
- App login: [http://ee.cloudschoolbd.com/login](http://ee.cloudschoolbd.com/login)
- username: admin
- password: demo123
- username: superadmin
- password: super99

# Screenshot
<img src="./screenshot/ce/dashboard.png" >
<img src="./screenshot/site-dashboard.png" >
<img src="./screenshot/ce/menu.png" >
<img src="./screenshot/list.png" >
<img src="./screenshot/ce/profile-st.png" >
<img src="./screenshot/id-2.png" >
<img src="./screenshot/attendance.jpg" >
<img src="./screenshot/grade.png" >
<img src="./screenshot/rules.png" >
<img src="./screenshot/marksheet.jpg" >
<img src="./screenshot/home.png" >

# Contributors
- [H.R. Shadhin](https://github.com/hrshadhin)
- [Ashutosh Das](https://github.com/pyprism)
- [order4adwriter](https://github.com/order4adwriter)
- [Zahid Irfan](https://github.com/zahidirfan)
- [Oshane Bailey](https://github.com/b4oshany)

# License

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

**As it is a free(free as in freedom) and open-source software. To keep the credit for this works, you should
not remove application footer information text**

**Why AGPL [Read Here](https://www.gnu.org/licenses/why-affero-gpl.html)**
