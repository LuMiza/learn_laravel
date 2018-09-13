<?php

namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    //表名
    protected $table = 'privilege';
    //主键
    protected $primaryKey = 'p_id';

    public  $timestamps = false;

    public function getData($post=[])
    {

        /*$this->where('p_name', 'like', '%管理员%');
        $this->where('p_name', 'like', '%管理员%');
        dd($this->toSql());
        dd($this->get()->toArray());*/

        $post = [
            'name' => '管理员',
//            'id' => 1
        ];
        $obj = \DB::table($this->table);//或  \DB::table('privilege')
        if (isset($post['name'])) {
            $obj->where('p_name', 'like', '%管理员%');
        }
        if (isset($post['id'])) {
            $obj->where('p_id', 1);
        }
//        dd($obj->toSql());
        $result = $obj->get();
        dd($result);
        //        dd($obj->toSql());
        /*\Event::listen('illuminate.query', function($query){
            var_dump($query);
        });
        */
    }
}
