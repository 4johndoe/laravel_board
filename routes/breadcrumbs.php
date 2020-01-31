<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;

Breadcrumbs::register('cabinet', function(Crumbs $crumbs) {
    $crumbs->push('Home', route('cabinet'));
});

Breadcrumbs::register('home', function(Crumbs $crumbs) {
    $crumbs->push('Home', route('home'));
});

Breadcrumbs::register('login', function(Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Login', route('login'));
});

Breadcrumbs::register('register', function(Crumbs $crumbs) {
    $crumbs->parent('login');
    $crumbs->push('Register', route('register'));
});

Breadcrumbs::register('password.request', function(Crumbs $crumbs) {
    $crumbs->parent('login');
    $crumbs->push('Reset Password', route('password.request'));
});
