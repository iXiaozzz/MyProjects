<?php

namespace app\home\controller;


use think\Db;
use think\Request;
use app\common\model\Article as ArticleModel;

class Article extends HomeBase
{

    public function index(Request $request)
    {
        $menuId = $request->get('m');
        if (isset($menuId) && !empty($menuId)) {
            $res = $this->_initData($menuId);
            if (!$res)
                return $this->fetch('./404');
            $articleData = $this->article->queryArticleByMenuId($menuId);
            $this->assign([
                "companyInfo" => $this->companyInfo,
                "articleData" => $articleData,
                "navLeft" => $this->navLeft,
                "posCurr" => $this->posCurr,
                "navFirst"=> $this->navFirst,
                "menuId" => $menuId
            ]);
            return $this->fetch();
        } else {
            return $this->fetch('./404');
        }
    }

    public function contact(Request $request)
    {
        $menuId = $request->get('m');
        if (isset($menuId) && !empty($menuId)) {
            $res = $this->_initData($menuId);
            if (!$res)
                return $this->fetch('./404');
            $this->assign([
                "companyInfo" => $this->companyInfo,
                "navLeft" => $this->navLeft,
                "posCurr" => $this->posCurr,
                "navFirst"=> $this->navFirst,
                "menuId" => $menuId
            ]);
            return $this->fetch('contact');
        } else {
            return $this->fetch('./404');
        }

    }

    //资质和荣誉
    public function articleFile(Request $request)
    {
        $menuId = $request->get('m');
        if (isset($menuId) && !empty($menuId)) {
            $res = $this->_initData($menuId);
            if (!$res)
                return $this->fetch('./404');
            $fileTotal = Db::name('file')->field('count(f_id) sum')
                ->where('f_menu_id', '=', $menuId)
                ->select()[0];
            $banner = Db::name('menu')
                ->field('f_banner_path')
                ->where('f_menu_id', '=', $menuId)
                ->find()['f_banner_path'];
            $this->assign([
                "companyInfo" => $this->companyInfo,
                "navLeft" => $this->navLeft,
                "posCurr" => $this->posCurr,
                "navFirst"=> $this->navFirst,
                "menuId" => $menuId,
                "fileTotal" => $fileTotal['sum'],
                'bannerPath' => $banner
            ]);
            return $this->fetch('articleFile');
        } else {
            return $this->fetch('./404');
        }
    }

    public function recruitPosition(Request $request)
    {
        $menuId = $request->get('m');
        if (isset($menuId) && !empty($menuId)) {
            $res = $this->_initData($menuId);
            if (!$res)
                return $this->fetch('./404');
            $allPosition = Db::name('recruit_position')
                ->order('f_order,f_create_time desc')
                ->select();
            $this->assign([
                "companyInfo" => $this->companyInfo,
                "navLeft" => $this->navLeft,
                "navFirst"=> $this->navFirst,
                "posCurr" => $this->posCurr,
                "menuId" => $menuId,
                "allPosition" => $allPosition,
//                'empty', '<span class="article-blank">暂时无招聘信息...</span>'
            ]);
            return $this->fetch('recruitPosition');
        } else {
            return $this->fetch('./404');
        }
    }

    public function productAndSolution()
    {
        $this->article = new ArticleModel();
        $this->navLeft = $this->article->query('SELECT f_menu_id fid,f_menu_name,f_url FROM t_menu AS m WHERE m.f_parent_id = 5');
        $newsTotal = Db::name('production_solution')->field('count(f_id) sum')->find()['sum'];
        $this->assign([
            "companyInfo" => $this->companyInfo,
            "navLeft" => $this->navLeft,
            "navFirst"=> $this->navFirst,
//            "posCurr" => $this->posCurr,
//            "menuId" => $menuId,
            "newsTotal" => $newsTotal
        ]);
        return $this->fetch('productAndSolution');
    }

    public function _empty()
    {
        return $this->fetch('./404');
    }
}
