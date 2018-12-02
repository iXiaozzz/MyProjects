<?php

namespace app\admin\controller;

use think\Db;
use think\Request;
use app\common\model\Article as ArticleModel;
use app\common\model\File as FileModel;
use app\common\model\RecruitPosition as RecruitPositionModel;

class DoAction extends AdminBase
{
    public function _empty()
    {
        return $this->fetch('./404');
    }

    //职位列表查看
    public function positionCheck(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $position = new RecruitPositionModel();
            $res = $position->queryById($id);
            $this->assign([
                'positionInfo' => $res[0]
            ]);
            return $this->fetch();

        } else {
            return $this->fetch('./404');
        }

    }

    //职位编辑
    public function positionEdit(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $position = new RecruitPositionModel();
            $res = $position->queryById($id);
            $this->assign([
                'positionInfo' => $res[0]
            ]);
            return $this->fetch();

        } else {
            return $this->fetch('./404');
        }
    }

    //删除职位
    public function deletePosition(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $position = new RecruitPositionModel();
            $htmlStr = $position->field('f_position_require')->where('f_id', '=', $id)->find()['f_position_require'];
            $res = $position->deleteById($id);
            if ($res) {
                $imgPathArr = html2imgs($htmlStr);
                if ($imgPathArr) {
                    foreach ($imgPathArr as $key => $value) {
                        deleteFile('.' . $value['src']);
                    }
                }
                return respond(1200, '删除成功！', '');
            } else {
                return respond(1201, '删除数据错误!', '');
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    //文章查看
    public function articleCheck(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $res = $this->_getArticleById($id);
            $this->assign([
                'articleInfo' => $res[0]
            ]);
            return $this->fetch();
        } else {
            return $this->fetch('./404');
        }

    }

    //文章编辑
    public function articleEdit(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $res = $this->_getArticleById($id);
            $parentId = intval($res[0]['f_parent_id']);
            if ($parentId == 3) {
                $isNews = 1;
                $parentMenu = Db::name('menu')
                    ->field('f_menu_id,f_menu_name')
                    ->where('f_menu_id', '=', 3)
                    ->order('f_parent_id')
                    ->select();
            } else {
                $isNews = 0;
                $parentMenu = Db::name('menu')
                    ->field('f_menu_id,f_menu_name')
                    ->where('f_parent_id', '=', 0)
                    ->where('f_menu_id', '<>', 3)
                    ->order('f_parent_id')
                    ->select();
            }
            $childMenu = Db::name('menu')
                ->field('f_menu_id,f_menu_name')
                ->where('f_parent_id', '=', $parentId)
                ->select();

            $this->assign([
                'articleInfo' => $res[0]
                , 'isNews' => $isNews
                , 'parentMenu' => $parentMenu
                , 'childMenu' => $childMenu
            ]);
            return $this->fetch();
        } else {
            return $this->fetch('./404');
        }
    }

    //文章删除
    public function articleDeleteById(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $article = new ArticleModel();
            $articleInfo = $article->field('f_article_content,f_cover_img_path,f_cover_yuantu_path')->where('f_article_id', '=', $id)->find();
            $res = $article->deleteById($id);
            if ($res) {
                $imgPathArr = html2imgs($articleInfo['f_article_content']);
                if ($imgPathArr) {
                    foreach ($imgPathArr as $key => $value) {
                        deleteFile('.' . $value['src']);
                    }
                }
                if ($articleInfo['f_cover_img_path']) {
                    deleteFile($articleInfo['f_cover_img_path']);
                }
                if ($articleInfo['f_cover_yuantu_path']) {
                    deleteFile($articleInfo['f_cover_yuantu_path']);
                }
                return respond(1200, '删除成功!', '');
            } else {
                return respond(1201, '删除数据错误!', '');
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    //修改文章封面图片
    public function articleUpdateCoverImg(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $res = Db::name('article')
                ->field('f_cover_img_path,f_cover_yuantu_path,f_article_id f_id')
                ->where('f_article_id', '=', $id)
                ->find();
            $this->assign([
                'info' => $res
            ]);
            return $this->fetch('updateCoverImg');
        } else {
            return $this->fetch('./404');
        }
    }

    private function _getArticleById($id)
    {
        $res = Db::name('article')->alias('a')
            ->field('a.f_article_id,m.f_parent_id,m.f_menu_id,m.f_menu_name,a.f_article_title,a.f_cover_img_path,a.f_summary,a.f_article_content,a.f_create_time')
            ->join('t_menu m', 'a.f_menu_id=m.f_menu_id', 'left')
            ->where('a.f_article_id', '=', $id)
            ->order('a.f_create_time,a.f_article_id')
            ->select();
        $pmenu = Db::name('menu')->field('f_parent_id,f_menu_name')->where('f_parent_id', '=', 0)->select();
        foreach ($res as $k => &$v) {
            $v['f_pmenu_name'] = $pmenu[$v['f_parent_id'] - 1]['f_menu_name'];
        }
        return $res;
    }

    //文件查看
    public function fileCheck(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $file = new FileModel();
            $res = $file->queryDataByFileId($id);
            $this->assign([
                'fileInfo' => $res
            ]);
            return $this->fetch();
        } else {
            return $this->fetch('./404');
        }
    }

    public function fileEdit(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $file = new FileModel();
            $res = $file->queryDataByFileId($id);
            $this->assign([
                'fileInfo' => $res
            ]);
            return $this->fetch();
        } else {
            return $this->fetch('./404');
        }
    }

    //文件删除
    public function fileDeleteById(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $file = new FileModel();
            $res = $file->get($id);
            deleteFile('./' . $res->f_large_file_path);
            deleteFile('./' . $res->f_small_file_path);
            $res->delete();
            if ($res) {
                return respond(1200, '删除成功！', '');
            } else {
                return respond(1201, '删除数据错误!', '');
            }
        } else {
            return respond(1201, '参数错误!', '');
        }
    }

    //产品及解决方案
    public function productionAndSolutionCheck(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $res = Db::name('production_solution')->alias('p')
                ->field('p.f_id,m.f_menu_name,p.f_disImg_path')
                ->join('t_menu m', 'p.f_menu_id=m.f_menu_id', 'LEFT')
                ->where('p.f_id', '=', $id)
                ->find();
            $this->assign([
                'info' => $res
            ]);
            return $this->fetch('productionCheck');
        } else {
            return $this->fetch('./404');
        }
    }


    public function productionAndSolutionEdit(Request $request)
    {
        $id = $request->get('id');
        if (isset($id) && !empty($id)) {
            $res = Db::name('production_solution')->alias('p')
                ->field('p.f_id,m.f_menu_name,p.f_disImg_path')
                ->join('t_menu m', 'p.f_menu_id=m.f_menu_id', 'LEFT')
                ->where('p.f_id', '=', $id)
                ->find();
            $this->assign([
                'info' => $res
            ]);
            return $this->fetch('productionEdit');
        } else {
            return $this->fetch('./404');
        }
    }
}
