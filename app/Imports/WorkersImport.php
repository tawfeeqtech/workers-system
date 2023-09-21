<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;

class WorkersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
    //    dd($rows);

        $post = new Post([
            'worker_id' => $row[0],
            'content'   => $row[1],
            'price'     => $row[2],
        ]);
        return $post;
    }
}
