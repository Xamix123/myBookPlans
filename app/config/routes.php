<?php
return [
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',

    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',

    'library/addBook' => 'library/addBook',
    'library/updateBook/([0-9]+)' => 'library/updateBook/$1',
    'library/book/([0-9]+)' => 'library/book/$1',
    'library/deleteBook/([0-9]+)' => 'library/deleteBook/$1',
    'library/page-([0-9]+)' => 'library/index/$1',
    'library' => 'library/index',

    'contacts' => 'site/contact',
    '' => 'site/index',
];
