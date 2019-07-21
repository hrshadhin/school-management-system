# school Management System (SMS)
Another School Management System build with laravel and PHP 7.

[![Codeship Status for hrshadhin/school-management-system](https://app.codeship.com/projects/09010350-b97f-0136-1477-5a7589b245e6/status?branch=master)](https://app.codeship.com/projects/312233)
[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)
[![Known Vulnerabilities](https://snyk.io/test/github/hrshadhin/school-management-system/badge.svg?targetFile=package.json)](https://snyk.io/test/github/hrshadhin/school-management-system?targetFile=package.json)


:loudspeaker:
**Notic:**  Now its version [v2.0](https://github.com/hrshadhin/school-management-system/releases/tag/v2.0) (community edition)
. If you need PHP 5 support then use version [v1.0](https://github.com/hrshadhin/school-management-system/releases/tag/v1.0).
For Enterprise edition checkout here [EE](https://github.com/hrshadhin/school-management-system/tree/empty)

# Features
- Academic Year manage
- Academic Calendar Setup
- Institute Setup
- Class & Section
- Subject & Teacher
- Student Admission
- Student Attendance
- Exam & Grading Rules
- Makrs & Result
- Employees Manage
- Employees Attendance
- Employees Leave
- Employees Work Outside
- SMS Gateway Setup 
- Attendance notification email/sms 
- Student & Employee Id-Card mass print with templates
- User & Role manage with permision grid(ACL)
- User wise Dashboard
- Report Settings
- Reports
- Dynamic Front Website
- Website Management Panel
- Photo Gallery
- Event Manage
- Google Analytics
- User Notificateion

# Installation and use

**Dependency**
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- [hrshadhin/laravel-userstamps](https://github.com/hrshadhin/laravel-userstamps.git)
- NodeJS, npm, webpack


```
$ git clone https://github.com/hrshadhin/school-management-system.git

```
```
$ cd school-management-system
```
```
$ cp .env.example .env
```
**Change configuration according to your need in ".env" file and create Database**
```
$ composer install
```
```
$ php artisan migrate
```
```
$ php artisan db:seed
```
**Load demo data**
```
$ php artisan db:seed --class DemoSiteDataSeeder
```
```
$ php artisan db:seed --class DemoAppDataSeeder
```
**Clear cache**
```
$ sudo php artisan cache:clear
```
```
$ npm install
```
```
$ npm run backend-prod
```
```
$ npm run frontend-prod
```
```
$ php artisan storage:link
```
```
$ php artisan serve
```
Now visit and login: [http://localhost:8000](http://localhost:8000) \
username: admin\
password: demo123

**Demo(Community Edition)**\
website url: http://sms.hrshadhin.me \
app login: http://sms.hrshadhin.me/login \
username: admin\
password: demo123

**Demo(Enterprise Edition)**\
website url: http://cloudschoolbd.com \
app login: http://cloudschoolbd.com/login \
username: admin\
password: demo123

**N.B:**
- For sms and email processing you need to run laravel queue worker. `bin` folder has supervisor config for start queue worker with supervisor.

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

# Security Vulnerabilities

If you discover a security vulnerability within SMS, please send an e-mail to H.R. Shadhin via [dev@hrshadhin.me](mailto:dev@hrshadhin.me). All security vulnerabilities will be promptly addressed.

# License

SMS is open-sourced software licensed under the AGPL-3.0 license. Frameworks and libraries has it own licensed.
