<?php

namespace app\admin\model;


use think\Model;

class Admin extends Model
{
    protected $table = 't_admin';

    public function updateDataById($arr, $id)
    {
        if (is_array($arr) && !empty($arr) && isset($id)) {
            return $this->save($arr, ['f_admin_id' => $id]);
        } else {
            return false;
        }
    }

    public function queryDataById($id)
    {
        if (intval($id)) {
            return $this->get($id);
        } else {
            return false;
        }
    }
}