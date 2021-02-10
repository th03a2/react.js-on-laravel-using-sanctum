<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
          [
            'role_id' => 1,
            'name'   => 'Thom-thom',
            'fname'   => 'Thomas Emmanuel',
            'mname'   => 'Romero',
            'lname' => 'Pajarillaga',
            'suffix'=> 'III',
            'email_verified_at' => '2020-05-16',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password')
          ],
          [
            'role_id'  => 2,
            'name'     => 'Randi',
            'fname'    => 'Randi',
            'mname'    => null,
            'lname'    => 'Waters',
            'suffix'   => null,
            'email_verified_at' => '2020-05-16',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password')
          ],
          [
            'role_id'  => 3,
            'name'     => 'Jenny',
            'fname'    => 'Jennyfer',
            'mname'    => null,
            'lname'    => 'Stanton',
            'suffix'   => null,
            'email_verified_at' => '2020-05-16',
            'email'    => 'studentadmission@gmail.com',
            'password' => Hash::make('password')
          ],
           [
            'role_id'  => 3,
            'name'     => 'Rand',
            'fname'    => 'ricky',
            'mname'    => null,
            'lname'    => 'Bautista',
            'suffix'   => null,
            'email_verified_at' => '2020-05-16',
            'email'    => 'studentAssesment@gmail.com',
            'password' => Hash::make('password')
          ],
          [
            'role_id'  => 4,
            'name'     => 'Stanly',
            'fname'    => 'Stanly',
            'mname'    => null,
            'lname'    => 'Stanton',
            'suffix'   => null,
            'email_verified_at' => '2020-05-16',
            'email'    => 'adviser2@gmail.com',
            'password' => Hash::make('password')
          ],
          [
            'role_id'  => 2,
            'name'     => 'Randi',
            'fname'    => 'kumag',
            'mname'    => 'kaliwat',
            'lname'    => 'Waters',
            'suffix'   => null,
            'email_verified_at' => '2020-05-16',
            'email'    => 'admins@gmail.com',
            'password' => Hash::make('password')
          ],
          [
            'role_id'  => 3,
            'name'     => 'Jenny',
            'fname'    => 'Jennyfer',
            'mname'    => null,
            'lname'    => 'Stanton',
            'suffix'   => null,
            'email_verified_at' => '2020-05-16',
            'email'    => 'Jennyfer@gmail.com',
            'password' => Hash::make('password')
          ],
           [
            'role_id'  => 3,
            'name'     => 'Randiy',
            'fname'    => 'Feasta',
            'mname'    => null,
            'lname'    => 'Waters',
            'suffix'   => null,
            'email_verified_at' => '2020-05-16',
            'email'    => 'Feasta@gmail.com',
            'password' => Hash::make('password')
          ],
          [
            'role_id'  => 4,
            'name'     => 'Jhon',
            'fname'    => 'Mark Jhon',
            'mname'    => 'Bungal',
            'lname'    => 'Reguyal',
            'suffix'   => null,
            'email_verified_at' => '2020-05-16',
            'email'    => 'Reguyal@gmail.com',
            'password' => Hash::make('password')
          ]
        ]);
    }
}
