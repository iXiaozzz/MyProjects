<?php

namespace app\api\controller;

use think\Db;
use think\Request;
use think\Session;

use app\admin\controller\AdminBase;

use app\common\model\Article as ArticleModel;
use app\common\model\File as FileModel;
use app\common\model\RecruitPosition as RecruitPositionModel;
use app\admin\model\Admin as AdminModel;

class ApiAdmin extends AdminBase
{
    //公司信息
    public function insertCompanyInfo(Request $request)
    {
        $data = $request->post();
        if (isset($data) && !empty($data)) {
            $insertData = [
                'f_website_keywords' => $data['website_keywords'],
                'f_website_description' => $data['website_description'],
                'f_company_name' => $data['companyName'],
                'f_tel' => $data['telPhone'],
                'f_fax' => $data['faxNumber'],
                'f_phone' => $data['mobilePhone'],
                'f_email' => $data['email'],
                'f_website_url' => $data['webUrl'],
                'f_address' => $data['address'],
                'f_company_intro' => $data['companyIntro'],
            ];
            $isHas = Db::name('company_info')->where('f_id', 1)->field('f_id')->find();
            if ($isHas) {
                try {
                    Db::name('company_info')
                        ->where('f_id', 1)
                        ->update($insertData);
                    $res = true;
                } catch (\ErrorException $e) {
                    return respond(1201, '修改数据错误!');
                }
            } else {
                $res = Db::name('company_info')->insert($insertData);//插入数据
            }
            if ($res) {
                return respond(1200, '更新成功!');
            } else {
                return respond(1201, '更新失败!');
            }
        }
    }

    /**文章表和新闻表的接口**/
    //文章的联动获取子menuID
    public function queryMenuInfo(Request $request)
    {
        $pid = intval($request->post('pid'));
        $menuInfo = Db::name('menu')
            ->field('f_menu_id,f_menu_name')
            ->where('f_parent_id', '=', $pid)
            ->order('f_menu_id')
            ->select();
        return respond(1200, '请求成功！', $menuInfo);
    }

    //插入文章的数据
    public function insertArticleData(Request $request)
    {
        $data = $request->post();
        if (isset($data) && !empty($data)) {
            $article = new ArticleModel();
            $menuId = intval($data['f_menu_id']);
            if (!in_array($menuId, [13, 14])) {
                $count = $article->field('count(f_article_id) num')
                    ->where('f_menu_id', '=', $menuId)
                    ->select()[0];
                if (intval($count['num']) > 0) {
                    return respond(1201, '该类型的文章已经新增过了');
                }
            }
            $article->insertData($data);
            return respond(1200, '提交成功!', $data);
        } else {
            return respond(1201, '数据不能为空!', '');
        }
    }


    public function demo()
    {
        $res = Db::name('article')->alias('a')
            ->field('a.f_article_id,m.f_parent_id,m.f_menu_name,a.f_article_title,a.f_article_content,a.f_top,a.f_create_time,a.f_real_time')
            ->join('t_menu m', 'a.f_menu_id=m.f_menu_id', 'left')
            ->where('m.f_parent_id', '=', 3)
            ->where('a.f_menu_id', '=', 13)
            ->where('a.f_menu_id', '<>', 35)
            ->order('a.f_top desc,a.f_real_time desc,a.f_article_id desc')
//            ->limit($offset, $len)
            ->select();
        halt($res);
    }

    //文章列表
    public function queryArticleList(Request $request)
    {
        $page = intval($request->param('page'));
        $len = intval($request->param('limit'));
        if (isset($page) && !empty($page) && isset($len) && !empty($len)) {
            $type = intval($request->param('type'));
            $offset = ($page - 1) * $len;
            if ($type != 3) {
                $total = count(Db::name('article')
                    ->field('f_article_id')
                    ->where('f_menu_id', '<>', 13)
                    ->where('f_menu_id', '<>', 14)
                    ->select()
                );
                $res = Db::name('article')->alias('a')
                    ->field('a.f_article_id,m.f_parent_id,m.f_menu_name,a.f_article_title,a.f_article_content,a.f_top,a.f_create_time,a.f_real_time')
                    ->join('t_menu m', 'a.f_menu_id=m.f_menu_id', 'left')
                    ->where('m.f_parent_id', '<>', 3)
                    ->order('a.f_top desc,a.f_real_time desc,a.f_article_id desc')
                    ->limit($offset, $len)
                    ->select();
            } else {
                $newsType = intval($request->param('newsType'));
                switch ($newsType) {
                    case 0:
                        $total = count(Db::name('article')
                            ->field('f_article_id')
                            ->where('f_menu_id=13 OR f_menu_id=14')
                            ->select()
                        );
                        $res = Db::name('article')->alias('a')
                            ->field('a.f_article_id,m.f_parent_id,m.f_menu_name,a.f_article_title,a.f_article_content,a.f_top,a.f_create_time,a.f_real_time')
                            ->join('t_menu m', 'a.f_menu_id=m.f_menu_id', 'left')
                            ->where('m.f_parent_id', '=', $type)
                            ->where('a.f_menu_id', '<>', 35)
                            ->order('a.f_top desc,a.f_real_time desc,a.f_article_id desc')
                            ->limit($offset, $len)
                            ->select();
                        break;
                    default:
                        $total = count(Db::name('article')
                            ->field('f_article_id')
                            ->where('f_menu_id', '=', $newsType)
                            ->select()
                        );
                        $res = Db::name('article')->alias('a')
                            ->field('a.f_article_id,m.f_parent_id,m.f_menu_name,a.f_article_title,a.f_article_content,a.f_top,a.f_create_time,a.f_real_time')
                            ->join('t_menu m', 'a.f_menu_id=m.f_menu_id', 'left')
                            ->where('m.f_parent_id', '=', $type)
                            ->where('a.f_menu_id', '=', $newsType)
                            ->where('a.f_menu_id', '<>', 35)
                            ->order('a.f_top desc,a.f_real_time desc,a.f_article_id desc')
                            ->limit($offset, $len)
                            ->select();
                        break;
                }

            }
            $pmenu = Db::name('menu')->field('f_parent_id,f_menu_name')->where('f_parent_id', '=', 0)->select();
            foreach ($res as $k => &$v) {
                $v['f_pmenu_name'] = $pmenu[$v['f_parent_id'] - 1]['f_menu_name'];
                $v['f_real_time'] = substr($v['f_real_time'], 0, 10);
                $v['f_create_time'] = substr($v['f_create_time'], 0, 10);
            }
            $res = $res ? $res : [];
            return json([
                "code" => 0,
                "msg" => "请求成功",
                "count" => $total,
                "data" => $res
            ]);
        } else {
            return json([
                "code" => 1,
                "msg" => "参数错误",
                "count" => 0,
                "data" => ''
            ]);
        }
    }

    //更新文章
    public function updateArticleById(Request $request)
    {
        $data = $request->post();
        if (isset($data) && !empty($data)) {
            $article = new ArticleModel();
            $menuId = intval($data['f_menu_id']);
            if (!in_array($menuId, [13, 14])) {
                $numRes = $article->field('f_article_id')
                    ->where('f_menu_id', '=', $menuId)
                    ->select();
                if (count($numRes) > 1) {
                    return respond(1201, '该文章类型已经存在!', '');
                }
            }
            $id = $data['f_article_id'];
            $res = $article->updateById($data, $id);
            if ($res !== false) {
                return respond(1200, '更新成功！', '');
            } else {
                return respond(1201, '插入数据错误!', '');
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    public function updateArticleCrateTime(Request $request)
    {
        $data = $request->post();
        if (isset($data) && !empty($data)) {
            $id = $data['f_article_id'];
            $article = new ArticleModel();
            $res = $article->updateRealTime($id, $data['f_real_time']);
            if ($res !== false) {
                return respond(1200, '更新成功！', '');
            } else {
                return respond(1201, '插入数据错误!', '');
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    //文章批量删除
    public function articleListDeleteById(Request $request)
    {
        $data = $request->post('data');
        if (isset($data) && !empty($data)) {
            $data = json_decode($data, true);
            $article = new ArticleModel();
            $res = $article->deleteListById($data);
            if ($res) {
                return respond(1200, '操作成功！', $res);
            } else {
                return respond(1201, '删除数据错误!', $res);
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    //新闻的推荐
    public function newsSetTop(Request $request)
    {
        $fid = intval($request->param('fid'));
        $top = intval($request->param('f_top'));
        if (isset($fid) && !empty($fid) && isset($top)) {
            $article = new ArticleModel();
            $res = $article->setTopById($fid, $top);
            if ($res) {
                return respond(1200, '更新成功！');
            } else {
                return respond(1201, '更新失败！');
            }
        } else {
            return respond(1201, '参数错误');
        }
    }

    /**文件表的接口**/
    //插入文件数据
    public function insertFileData(Request $request)
    {
        $data = $request->post();
        if (isset($data) && !empty($data)) {
            $file = new FileModel();
            $file->insertData($data);
            return respond(1200, '提交成功!', $data);
        } else {
            return respond(1201, '数据不能为空!', '');
        }
    }

    //更新文件数据
    public function updateFileData(Request $request)
    {
        $data = $request->post();
        if (isset($data) && !empty($data)) {
            $id = $data['f_id'];
            $file = new FileModel();
            if (count($data) > 2) {
                $updateData = [
                    'f_file_title' => $data['f_file_title'],
                    'f_large_file_path' => $data['f_large_file_path'],
                    'f_small_file_path' => $data['f_small_file_path'],
                    'f_large_file_width' => $data['f_large_file_width'],
                    'f_large_file_height' => $data['f_large_file_height'],
                    'f_img_flag' => $data['f_img_flag']
                ];
            } else {
                $updateData = ['f_file_title' => $data['f_file_title']];
            }
            $res = $file->updateData($id, $updateData);
            if ($res) {
                return respond(1200, '更新成功!', $data);
            } else {
                return respond(1201, '更新失败!', $data);
            }
        } else {
            return respond(1201, '数据不能为空!', '');
        }
    }

    //查询列表数据
    public function queryFileListByLimit(Request $request)
    {
        $type = $request->get('type');
        if (isset($type) && !empty($type)) {
            $page = (int)$request->param('page');
            $len = (int)$request->param('limit');
            $offset = ($page - 1) * $len;
            $file = new FileModel();
            $total = count($file->queryDataByMenuId($type));
            $data = $file->queryDataByLimit($offset, $len, $type);
            return json([
                "code" => 0,
                "msg" => "请求成功!",
                "count" => $total,
                "data" => $data
            ]);
        } else {
            return json([
                "code" => 1,
                "msg" => "参数错误",
                "count" => 0,
                "data" => ''
            ]);
        }

    }

    //修改显示排序
    public function fileSetOrder(Request $request)
    {
        $fid = intval($request->post('f_id'));
        $forder = intval($request->post('f_order'));
        if (isset($fid) && !empty($fid) && isset($forder)) {
            $file = new FileModel();
            $res = $file->setOrder($fid, $forder);
            if ($res) {
                return respond(1200, '修改成功!');
            } else {
                return respond(1201, '修改失败!');
            }
        } else {
            return respond(1201, '参数错误');
        }
    }

    //文件批量删除
    public function fileListDeleteById(Request $request)
    {
        $data = $request->post('data');
        if (isset($data) && !empty($data)) {
            $data = json_decode($data, true);
            $file = new FileModel();
            $imgPathArr = tp5ModelTransfer($file->field('f_large_file_path,f_small_file_path')
                ->where('f_id', 'in', $data)
                ->select());
            $res = $file->deleteListById($data);
            if ($res) {
                foreach ($imgPathArr as $key => $value) {
                    deleteFile('./' . $value['f_large_file_path']);
                    deleteFile('./' . $value['f_small_file_path']);
                }
                return respond(1200, '操作成功！', '');
            } else {
                return respond(1201, '删除数据错误!', '');
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    /**职位表的接口**/
    //插入招聘职位数据
    public function insertPosition(Request $request)
    {
        $data = $request->post();
        if (isset($data) && !empty($data)) {
            $position = new RecruitPositionModel();
            $position->insertData($data);
            return respond(1200, '提交成功!', $data);
        } else {
            return respond(1201, '数据不能为空!', '');
        }
    }

    public function positionSetOrder(Request $request)
    {
        $fid = intval($request->post('f_id'));
        $forder = intval($request->post('f_order'));
        if (isset($fid) && !empty($fid) && isset($forder)) {
            $position = new RecruitPositionModel();
            $res = $position->setOrder($fid, $forder);
            if ($res) {
                return respond(1200, '修改成功!');
            } else {
                return respond(1201, '修改失败!');
            }
        } else {
            return respond(1201, '参数错误');
        }
    }

    //列表数据
    public function queryPositionList(Request $request)
    {
        $page = (int)$request->param('page');
        $len = (int)$request->param('limit');
        if (isset($page) && !empty($page) && isset($len) && !empty($len)) {
            $offset = ($page - 1) * $len;
            $position = new RecruitPositionModel();
            $total = $position->queryTotal();
            $res = $position->queryByLimit($offset, $len);
            $res = $res ? $res : [];
            return json([
                "code" => 0,
                "msg" => "更新成功！",
                "count" => $total,
                "data" => $res
            ]);
        } else {
            return json([
                "code" => 1,
                "msg" => "参数错误",
                "count" => 0,
                "data" => ''
            ]);
        }

    }

    //更新
    public function updatePosition(Request $request)
    {
        $data = $request->post();
        if (isset($data) && !empty($data)) {
            $id = $data['f_id'];
            $position = new RecruitPositionModel();
            $res = $position->updateById($data, $id);
            if ($res !== false) {
                return respond(1200, '更新成功！', '');
            } else {
                return respond(1201, '插入数据错误!', '');
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    //批量删除
    public function deleteListPosition(Request $request)
    {
        $data = $request->post('data');
        if (isset($data) && !empty($data)) {
            $data = json_decode($data, true);
            $position = new RecruitPositionModel();
            $res = $position->deleteListById($data);
            if ($res) {
                return respond(1200, '操作成功!', '');
            } else {
                return respond(1201, '删除数据错误!', '');
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    //修改密码
    public function updateInfo(Request $request)
    {
        $newPwd = $request->post('new_pwd');
        $adminPwd = $request->post('admin_pwd');
        if (isset($newPwd) && !empty($newPwd) && isset($adminPwd) && !empty($adminPwd)) {
            $adminId = Session::get('adminInfo', 'admin')['admin_id'];
            $adminModel = new AdminModel();
            $adminInfo = $adminModel->queryDataById($adminId);
            if ($adminInfo->f_admin_pwd != $adminPwd) {
                return respond(1201, '旧密码错误!');
            }
            $res = $adminModel->updateDataById(['f_admin_pwd' => $newPwd], $adminId);
            if ($res) {
                return respond(1200, '修改成功!');
            } else {
                return respond(1201, '修改失败!');
            }
        } else {
            return respond(1201, '非法请求!');
        }
    }

    /**产品及解决方案*/
    public function productionAndSolutionList(Request $request)
    {
        $page = (int)$request->param('page');
        $len = (int)$request->param('limit');
        if (isset($page) && !empty($page) && isset($len) && !empty($len)) {
            $offset = ($page - 1) * $len;
            $total = Db::name('production_solution')->field('COUNT(f_id) sumNum')
                ->find()['sumNum'];
            $res = Db::name('production_solution')->alias('p')
                ->field('p.f_id,m.f_menu_name,p.f_create_time')
                ->join('t_menu m', 'p.f_menu_id=m.f_menu_id', 'LEFT')
                ->where('m.f_parent_id', '=', 5)
                ->limit($offset, $len)
                ->select();
            $res = $res ? $res : [];
            return json([
                "code" => 0,
                "msg" => "更新成功！",
                "count" => $total,
                "data" => $res
            ]);
        } else {
            return json([
                "code" => 1,
                "msg" => "参数错误",
                "count" => 0,
                "data" => ''
            ]);
        }
    }


    public function test()
    {
        $queryPath = Db::name('production_solution')->field('f_disImg_path path')
            ->where('f_id', '=', 1)->find()['path'];
        halt($queryPath);
        $res = Db::name('production_solution')
            ->where('f_id', '=', 1)
            ->update(['f_disImg_path' => '124']);
        halt($res);
        $res = Db::name('production_solution')->field('COUNT(f_id) sumNum')
            ->find()['sumNum'];
        halt($res);
        $res = Db::name('production_solution')->alias('p')
            ->field('p.f_id,m.f_menu_name,p.f_create_time')
            ->join('t_menu m', 'p.f_menu_id=m.f_menu_id', 'LEFT')
            ->where('m.f_parent_id', '=', 5)
//            ->limit($offset, $len)
            ->select();
        halt($res);
        $file = new FileModel();
        $imgPathArr = tp5ModelTransfer($file->field('f_large_file_path,f_small_file_path')
            ->where('f_id', 'in', [3, 6])
            ->select());
        foreach ($imgPathArr as $key => $value) {
            dump($value['f_large_file_path']);
        }
        halt($imgPathArr);
        $total = count(Db::name('article')->field('f_article_id')->where('f_menu_id', '=', 2)->select());
        $res = Db::name('article')->alias('a')
            ->field('a.f_article_id,m.f_parent_id,a.f_menu_id,m.f_menu_name,a.f_article_title,a.f_article_content,a.f_top,a.f_create_time')
            ->join('t_menu m', 'a.f_menu_id=m.f_menu_id', 'left')
            ->where('m.f_parent_id', '=', 2)
//            ->where('a.f_menu_id', '<>', 35)
            ->order('a.f_create_time,a.f_article_id')
            ->limit(0, 10)
            ->select();
        halt($res);
    }
}