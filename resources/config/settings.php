<?php

use Wirelab\SharesPlugin\Command\GetNetworks;

$networks      = GetNetworks::all();
$default_value = range(0, count($networks)-1);

return [
    'facebook_app_id' => [
        'type'     => 'anomaly.field_type.text'
    ],
    'networks' => [
        'type'   => 'anomaly.field_type.checkboxes',
        'config' => [
        	'default_value' => $default_value,
        	'options'       => $networks,
        ]
    ],
];
