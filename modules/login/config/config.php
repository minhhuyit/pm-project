<?php

return  [
    'components' => [        
        'urlManager' => [
            'rules' => [
                '<module:login>' => '<module>/user/login',
                'reset-password' => 'login/user/reset-password',
            ],
        ],
      ]
];

