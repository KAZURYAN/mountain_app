<?php

namespace App\Imports;

use App\Member;
use Maatwebsite\Excel\Concerns\ToModel;

class MembersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Member([
          'membership_date'   => $row[0],
          'name'             => $row[1],
          'kana_name'        => $row[2],
          'email'            => $row[3],
          'age'              => $row[4],
          'sex'              => $row[5],
          'car_status'       => $row[6],
          'address'          => $row[7],
          'holiday'          => $row[8],
          'plan_stance'      => $row[9],
          'job'              => $row[10],
          'member_status'    => $row[11],
        ]);
    }
}
