<?php


namespace app\api\model;

use think\Model;
use think\Db;

class User extends Model
{
    protected $table = "t_user";

    public static function userLogin($account, $password)
    {
        $res = Db::name('user')->field('f_id,f_account,f_token')
            ->where("f_account='$account'AND f_password='$password'")
            ->find();
        return $res ? $res : false;
    }

    public function userRegister($arr = [])
    {
        if (!empty($arr) && is_array($arr)) {
            return $this->data($arr)->save();
        } else {
            return false;
        }
    }

    public function userCheck($account, $password)
    {
        $res = Db::name('user')
            ->field('f_id,f_token')
            ->where("f_account='$account' AND f_password='$password'")
            ->find();
        return $res ? $res['f_id'] : false;
    }

    public function queryUserInfoByToken($token){
        $res = Db::name('user')
            ->field('f_id,f_token')->where('f_token',$token)
            ->find();
        return $res ? $res : false;
    }
}