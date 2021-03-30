<?php
namespace database\seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=> 'Do Anh Thu',
            'email'=> 'emailrandom@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('123456'),
        ]);
    }
}
