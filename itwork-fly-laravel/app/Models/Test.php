<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Test extends Model {

    public static function findOne($id){
        return DB::table('user')->get();
    }
}