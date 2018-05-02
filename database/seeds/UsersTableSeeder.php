<?php
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                'name' => 'Chiranjib Dey',
                'email' => 'chiranjib.dey@7io.co',
                'password' => bcrypt('123456'),
                'user_type_id' => 2,
                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sood Lahiri',
                'email' => 'sood@7io.co',
                'password' => bcrypt('123456'),
                'user_type_id' => 2,
                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Amit Upadhyay',
                'email' => 'amit@7io.co',
                'password' => bcrypt('123456'),
                'user_type_id' => 2,
                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Samrat Roy',
                'email' => 'samrat@7io.co',
                'password' => bcrypt('123456'),
                'user_type_id' => 2,
                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        User::insert($users);
    }
}
