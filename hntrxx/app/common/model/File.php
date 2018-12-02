<?php

namespace app\common\model;


use think\Model;

class File extends Model
{
    protected $table = 't_file';

    public function insertData($arr = [])
    {
        if (!empty($arr) && is_array($arr)) {
            $this->data($arr)->save();
        } else {
            return respond(2001, '请传入参数!');
        }
    }

    public function updateData($id,$arr = []){
        if (isset($id) && !empty($id)) {
            $this->save($arr, ['f_id' => $id]);
            return true;
        } else {
            return false;
        }
    }

    public function queryDataByFileId($fileId)
    {
        if (isset($fileId) && !empty($fileId)) {
            return $this->get($fileId);
        } else {
            return respond(2001, '请传入参数!');
        }
    }

    public function queryDataByMenuId($type)
    {
        return $this->field('f_id')
            ->where('f_menu_id', '=', $type)
            ->select();
    }

    public function queryDataByLimit($offset, $len, $type)
    {
        return $this->field('f_id,f_file_title,f_order,f_create_time')
            ->where('f_menu_id', '=', $type)
            ->order('f_order,f_id desc,f_create_time desc')
            ->limit($offset, $len)
            ->select();
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

    public function deleteById($id)
    {
        if (isset($id) && !empty($id)) {
            return $this->get($id)->delete();
        } else {
            return false;
        }
    }

    public function deleteListById($idList = [])
    {
        if (count($idList)) {
            return $this::destroy($idList);
        } else {
            return false;
        }
    }

}