<?php

namespace app\common\model;


use think\Model;

class RecruitPosition extends Model
{
    protected $table = 't_recruit_position';

    //获取总条数
    public function queryTotal()
    {
        $res = $this->field('f_id')->select();
        return count($res);
    }

    public function insertData($arr = [])
    {
        if (!empty($arr) && is_array($arr)) {
            $this->data($arr)->save();
        } else {
            return respond(2001, '请传入参数!');
        }
    }

    //
    public function queryByLimit($offset, $len)
    {
        $res = $this->field('f_id,f_position_name,f_position_place,f_position_num,f_order,f_create_time')
            ->order('f_order,f_create_time desc')
            ->limit($offset, $len)
            ->select();
        return tp5ModelTransfer($res);
    }

    public function setOrder($id, $order)
    {
        if (isset($id) && !empty($id)) {
            $this->save([
                'f_order' => $order,
            ], ['f_id' => $id]);
            return true;
        } else {
            return false;
        }
    }

    public function queryById($arr)
    {
        $res = $this->all($arr);
        return tp5ModelTransfer($res);
    }


    public function updateById($arr, $id)
    {
        if (is_array($arr) && !empty($arr) && isset($id)) {
            return $this->save($arr, ['f_id' => $id]);
        } else {
            return false;
        }
    }

    //删除
    public function deleteById($id)
    {
        if (isset($id) && !empty($id)) {
            return $this->get($id)->delete();
        } else {
            return false;
        }
    }

    //批量删除
    public function deleteListById($idArr = [])
    {
        if (count($idArr)) {
            return $this::destroy($idArr);
        } else {
            return false;
        }
    }
}