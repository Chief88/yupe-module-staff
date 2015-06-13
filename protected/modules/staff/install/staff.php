<?php

return [
    'module'    => [
        'class' => 'application.modules.staff.StaffModule',
    ],
    'import'    => [],
    'component' => [],
    'rules'     => [
        '/staff/'        => 'staff/staff/index',
        '/staff/<slug>' => 'staff/staff/show',
    ],
];
