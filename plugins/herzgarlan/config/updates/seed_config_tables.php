<?php namespace HerzGarlan\Config\Updates;

use HerzGarlan\Config\Models\Rate;
use HerzGarlan\Config\Models\Timeslot;
use HerzGarlan\Config\Models\BlockedDates;
use October\Rain\Database\Updates\Seeder;

class SeedConfigTables extends Seeder
{
    public function run()
    {
        Rate::create(['name' => 'Unstuff Container', 'slug' => str_slug('Unstuff Container'), 'value' => 0]);
        Rate::create(['name' => 'Warehousing Storage', 'slug' => str_slug('Warehousing Storage'), 'value' => 0]);
        Rate::create(['name' => 'Inbound', 'slug' => str_slug('Inbound'), 'value' => 0]);
        Rate::create(['name' => 'Outbound', 'slug' => str_slug('Outbound'), 'value' => 0]);
        Rate::create(['name' => 'Sorting',  'slug' => str_slug('Storing'), 'value' => 0]);
        Rate::create(['name' => 'Labour',  'slug' => str_slug('Labour'), 'value' => 0]);
        Rate::create(['name' => 'Pick-up', 'slug' => str_slug('Pick-up'), 'value' => 0]);
        Rate::create(['name' => 'Pick & Pack', 'slug' => str_slug('Pick & Pack'), 'value' => 0]);
        Rate::create(['name' => 'Delivery(Van)', 'slug' => str_slug('Delivery(Van)'), 'value' => 0]);
        Rate::create(['name' => 'Delivery(14ft cover truck)', 'slug' => str_slug('Delivery(14ft cover truck)'), 'value' => 0]);
        Rate::create(['name' => 'Delivery(24ft cover truck)', 'slug' => str_slug('Delivery(24ft cover truck)'), 'value' => 0]);
    }
}
