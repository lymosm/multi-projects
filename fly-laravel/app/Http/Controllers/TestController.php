<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Test;


class TestController extends Controller{

    public function test($id = 0){
        return view('test.profile', [
            'user' => Test::findOne($id)
        ]);
    }
}