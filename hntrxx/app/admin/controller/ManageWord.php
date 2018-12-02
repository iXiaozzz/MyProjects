<?php

namespace app\admin\controller;

use think\Request;
use think\Db;

class ManageWord extends AdminBase
{
    //编辑
    public function editWordDis(Request $request)
    {
        $fid = $request->param('fid');
        $info = f_QueryBySql("SELECT f_title,f_content,f_btn_value,f_top FROM ww_config_ad WHERE f_id = $fid")[0];
        $this->assign([
            "fid" => $fid
            , "info" => $info
        ]);
        return $this->fetch();
    }

    public function addWordDis()
    {
        return $this->fetch();
    }

    //新增文字展示接口
    public function addWordDisFormData()
    {
        $data = $_POST['addWordData'];
        if (isset($data) && !empty($data)) {
            if (isset($data['top']) && !empty($data['top'])) {
                $top = 1;
            } else {
                $top = 0;
            }
            try {
                f_ExecSql("INSERT INTO ww_config_ad(f_comkey,f_module_id,f_title,f_content,f_top)
                                   VALUE ($this->comkey,2,'" . $data['title'] . "','" . $data['content'] . "'," . $top . ")");
                return json(["state" => 1, "message" => "新增成功"]);
            } catch (\Exception $e) {
                return json(["state" => 0, "message" => "新增失败"]);
            }
        } else {
            return json(["state" => 0, "message" => "提交数据失败"]);
        }
    }

    //编辑文字展示接口
    public function editWordDisFormData()
    {
        $data = $_POST['wordData'];
        if (isset($data) && !empty($data)) {
            if (isset($data['top']) && !empty($data['top'])) {
                $top = 1;
            } else {
                $top = 0;
            }
            try {
                f_ExecSql("UPDATE ww_config_ad SET f_title='" . $data['title'] . "',f_btn_value='" . $data['btnValue'] . "',f_content='" . $data['content'] . "',f_top=" . $top . " WHERE f_id=" . $data['fid']);
                return json(["state" => 1, "message" => "更新成功"]);
            } catch (\Exception $e) {
                return json(["state" => 0, "message" => "更新失败"]);
            }
        } else {
            return json(["state" => 0, "message" => "提交数据失败"]);
        }
    }

    //文字展示是否推荐
    public function wordDisTop(Request $request)
    {
        $id = $request->param('id');
        $status = $request->param('status');
        $result = f_ExecSql("UPDATE ww_config_ad SET f_top = $status WHERE f_id = $id");
        if ($result) {
            return json(["state" => 1, "message" => "操作成功"]);
        } else {
            return json(["state" => 0, "message" => "操作失败"]);
        }
    }
    //批量删除
    public function doBatchDelete(Request $request)
    {
        $ids = $request->param('ids');
        $idsArr = explode(',', $ids);
        Db::startTrans();
        try {
            for ($i = 0; $i < count($idsArr) - 1; $i++) {
                $id = $idsArr[$i];
                f_ExecSql("DELETE FROM ww_config_ad WHERE f_id = $id AND f_comkey = $this->comkey");
            }
            Db::commit(); // 提交事务
        } catch (\Exception $e) {
            Db::rollback(); // 回滚事务
            return json(["state" => 0, "message" => "操作失败"]);
        }
        return json(["state" => 1, "message" => "操作成功"]);
    }

}