<?php return [
    'plugin' => [
        'name' => 'Config',
        'description' => 'Configuration modules to handle Global Rates and Timeslot settings',
    ],
    'rate' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'value' => 'Rates(S$)',
        'description' => 'Description',
        'user_id' => 'User ID',
        'created_at' => 'Created Date',
        'updated_at' => 'Updated Date',
        'manage_rate' => 'Manage Rates',
        'rates' => 'Rates',
        'operator' => 'Operator',
        'operator_comment' => 'Operator to use for any changes to inventory (e.g. Inbound = Add)'
    ],
    'timeslot' => [
        'day' => 'Day',
        'time_from' => 'From',
        'time_from_comment' => 'A time slot start time (e.g. 9:00 AM)',
        'time_slot' => 'Timeslots',
        'time_to' => 'To',
        'capacity' => 'Capacity',
        'manage_timeslot' => 'Manage Timeslot',
        'new_timeslot' => 'New Timeslot',
        'timeslot_update' => 'Update timeslot',
    ],
    'blocked_dates' => [
        'date_start' => 'Start',
        'date_end' => 'End',
        'remarks' => 'Remarks',
        'remarks_comment' => 'Additional info on blocked date (e.g. National Day)',
        'manage_blocked_dates' => 'Manage Blocked Dates',
        'blocked_dates' => 'Blocked Dates',
    ],
    'config' => [
        'manage_config' => 'Manage Config',
        'customer' => 'Customer',
        'rate' => 'Rate',
    ],
];