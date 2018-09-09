<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Admin extends Migration
{
    /**
     * 判断是否存在索引
     * @param $table  表名
     * @param $name 索引名字
     * @return mixed
     */
    private function hasIndex($table, $name)
    {
        $conn = Schema::getConnection();
        $dbSchemaManager = $conn->getDoctrineSchemaManager();
        $doctrineTable = $dbSchemaManager->listTableDetails($table);
        return $doctrineTable->hasIndex($name);
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*//如果当前数据中没有 test表则创建test表
        if(!Schema::hasTable('test')) {
            Schema::create('test', function(Blueprint $table){
                $table->increments('id');
                $table->string('username')->comment('用户名');
                $table->char('password')->comment('密码');
                $table->string('email')->comment('邮箱');
                $table->integer('group_id')->comment('组id');
                $table->string('phone')->comment('手机号');
                //唯一索引
                $table->unique('username');
                //一般索引
                $table->index('email');
                //设置表的引擎
                $table->engine = 'innodb';
            });
        }else{
            //如果表存在的话 调整表结构
            Schema::table('test', function ($table) {
                //添加  -- 李强  2016-10-20
                if(!Schema::hasColumn('test','sex')) {
                    $table->tinyInteger('sex')->comment('性别');
                }
                //检测表字段是否存在
                if(!Schema::hasColumn('test','age')) {
                    $table->integer('age')->default(10);// 李刚  2016-10-23
                }
                if(Schema::hasColumn('test','password')) {
                    //修改字段类型
                    $table->text('password')->change();//李明  2016-10-29
                }
                //李华  2016-11-11
                if(Schema::hasColumn('test','phone')) {
                    $table->dropColumn('phone');
                }

                //创建索引
                // $table->index('group_id');

                //删除索引 //有问题
                // $table->dropPrimary('PRIMARY');

                //删除唯一索引
                if($this->hasIndex('test','test_username_unique')) {
                    $table->dropUnique('test_username_unique');
                }
                if($this->hasIndex('test','test_email_index')) {
                    $table->dropIndex('test_email_index');
                }
            });
        }*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
