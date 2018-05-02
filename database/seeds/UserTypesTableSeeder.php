<?php
use App\UserType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'user_type' => 'Super Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'user_type' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'user_type' => 'Data Entry Operator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'user_type' => 'Employee',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        UserType::insert($users);
    }
}
