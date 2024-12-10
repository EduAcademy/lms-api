<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            //
            'id' => $row[0],
            'username' => $row[1],
            // 'age' => $row[2],
            // 'major' => $row[3],
            // 'level' => $row[4],
            'email' => $row[5],
            'gender' => $row[6],
            'phone' => $row[7],
            'address' => $row[8],
            // 'password' => Hash::make($row[])
        ]);
    }
}
