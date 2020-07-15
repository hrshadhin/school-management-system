/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

window.initDeleteDialog = function () {
    $('form.myAction').submit(function (e) {
        e.preventDefault();
        var that = this;
        swal({
            title: 'Are you sure?',
            text: 'You will not be able to recover this record!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
            that.submit();
        }
    });
    });
};

import Login from './Login';
window.Login = Login;

import Site from './Site';
window.Site = Site;

import Settings from './Settings';
window.Settings = Settings;

import Generic from './Generic';
window.Generic = Generic;

import Administrator from './Administrator';
window.Administrator = Administrator;

import Academic from './Academic';
window.Academic = Academic;

import Reports from './reports';
window.Reports = Reports;

import HRM from './hrm';
window.HRM = HRM;
