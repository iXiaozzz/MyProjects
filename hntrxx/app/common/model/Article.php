<?php

namespace app\common\model;


use think\Db;
use think\Model;

class Article extends Model
{
    protected $table = 't_article';

    //插入数据
    public function insertData($arr = [])
    {
        if (!empty($arr) && is_array($arr)) {
            $this->data($arr)->save();
        } else {
            return respond(2001, '请传入参数!');
        }
    }

    //根据ID查询
    public function queryDataByArticleId($articleId)
    {
        if (is_int($articleId) && $articleId) {
            return $this->get($articleId);
        } else {
            return respond(2001, '请传入参数!');
        }
    }

    //分页查询
    public function queryByLimit($offset, $len)
    {
        $res = $this->field('f_id,f_position_name,f_position_place,f_position_num,f_create_time')
            ->limit($offset, $len)
            ->order('f_create_time,f_id')
            ->select();
        return tp5ModelTransfer($res);
    }

    //根据ID更新
    public function updateById($arr, $id)
    {
        if (is_array($arr) && !empty($arr) && isset($id)) {
            return $this->save($arr, ['f_article_id' => $id]);
        } else {
            return false;
        }
    }

    //单个删除
    public function deleteById($id)
    {
        if (isset($id) && !empty($id)) {
            return $this->get($id)->delete();
        } else {
            return false;
        }
    }

    //批量删除
    public function deleteListById($idList = [])
    {
        if (count($idList)) {
            return $this::destroy($idList);
        } else {
            return false;
        }
    }

    //是否推荐
    public function setTopById($id, $top = 0)
    {
        if (!empty($id)) {
            $this->save([
                'f_top' => $top,
            ], ['f_article_id' => $id]);
//            $this->where('f_article_id', '=', $id)
//                ->update(['f_top' => $top]);
            return true;
        } else {
            return false;
        }
    }

    //更新时间
    public function updateRealTime($id, $dateStr)
    {
        if (!empty($id)) {
            $this->save([
                'f_real_time' => $dateStr
            ], ['f_article_id' => $id]);
            return true;
        } else {
            return false;
        }
    }

    //前台显示文章
    public function queryArticleByMenuId($menuId)
    {
        return $this->field('f_article_content')
            ->where('f_menu_id', '=', $menuId)
            ->find();
    }

    //文章左侧导航栏
    public function queryNavLeftByMenuId($menuId)
    {
        return $this->query("SELECT m.f_menu_name FROM t_menu as m WHERE m.f_parent_id IN (SELECT f_parent_id from t_menu WHERE f_menu_id = $menuId)");
    }

}