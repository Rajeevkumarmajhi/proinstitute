<?php

namespace Database\Seeders;

use App\Models\Shift;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $admin = new User;
        $admin->first_name = "Admin";
        $admin->middle_name = "";
        $admin->last_name = "";
        $admin->father_first_name = "Admin";
        $admin->father_middle_name = "";
        $admin->father_last_name = "";
        $admin->nationality = "Nepalese";
        $admin->profession = "Admin";
        $admin->email = "admin@gmail.com";
        $admin->password = Hash::make('password');
        $admin->save();

        $siteSetting = new SiteSetting();
        $siteSetting->school_name = "Pro Institute";
        $siteSetting->phone = '';
        $siteSetting->address = "Biratnagar";
        $siteSetting->date_system = "AD";
        $siteSetting->save();

        $shift = new Shift;
        $shift->name = "Morning Shift";
        $shift->start_time = "7:00";
        $shift->end_time = "9:00";
        $shift->save();

        $shift = new Shift;
        $shift->name = "Day Shift";
        $shift->start_time = "13:00";
        $shift->end_time = "15:00";
        $shift->save();

        $shift = new Shift;
        $shift->name = "Evening Shift";
        $shift->start_time = "16:00";
        $shift->end_time = "18:00";
        $shift->save();
    }
}