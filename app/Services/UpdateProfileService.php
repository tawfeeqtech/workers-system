<?php

namespace App\Services;

use App\Models\Worker;
use Illuminate\Http\UploadedFile;

class UpdateProfileService
{
    protected $model;
    function __construct()
    {
        $this->model = Worker::find(auth()->guard('worker')->id());
    }

    public function password($data)
    {
        $data['password'] = $this->model->password;

        if (request()->has('password')) {
            $data['password'] = bcrypt(request()->password);
        }
       
        return $data;
    }

    public function photo($data)
    {
        $data['photo'] = $this->model->photo;

        if (request()->has('photo')) {
            $data['photo'] = (request()->file('photo') instanceof UploadedFile) ? request()->file('photo')->store('workers') : $this->model->photo;
        }
       
        return $data;
    }

    public function update($request)
    {
        $data = $request->all();
        $data = $this->password($data);
        $data = $this->photo($data);
        $this->model->update($data);
        return response()->json(['message' => 'updated']);
    }
}
