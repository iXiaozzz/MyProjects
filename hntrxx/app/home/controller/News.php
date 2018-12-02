<?php

namespace app\home\controller;

use think\Db;
use think\Request;
use app\common\model\Article as ArticleModel;

class News extends HomeBase
{

    public function index(Request $request)
    {
        $menuId = $request->get('m');
        if (isset($menuId) && !empty($menuId)) {
            $this->_initData($menuId);
            $newsTotal = $this->article->field('count(f_article_id) sum')
                ->where('f_menu_id', '=', $menuId)
                ->find()['sum'];
            $banner = Db::name('menu')
                ->field('f_banner_path')
                ->where('f_menu_id', '=', $menuId)
                ->find()['f_banner_path'];
            $this->assign([
                "companyInfo" => $this->companyInfo,
                "navLeft" => $this->navLeft,
                "navFirst" => "newsAll.html",
                "posCurr" => $this->posCurr,
                "menuId" => $menuId,
                "newsTotal" => $newsTotal,
                'bannerPath' => $banner
            ]);
            return $this->fetch();
        } else {
            return $this->fetch('./404');
        }
    }

    public function newsAll()
    {
        $this->article = new ArticleModel();
        $this->navLeft = $this->article->query('SELECT f_menu_id fid,f_menu_name,f_url FROM t_menu as m WHERE m.f_parent_id = 3');
        $newsTotal = $this->article->field('count(f_article_id) sum')
            ->where('f_menu_id', 'in', [13, 14])
            ->find()['sum'];
        $banner = Db::name('menu')
            ->field('f_banner_path')
            ->where('f_menu_id', '=', 13)
            ->find()['f_banner_path'];
        $this->assign([
            "companyInfo" => $this->companyInfo,
            "navLeft" => $this->navLeft,
            "navFirst" => $this->navFirst,
//            "posCurr" => $this->posCurr,
//            "menuId" => $menuId,
            'bannerPath' => $banner,
            "newsTotal" => $newsTotal
        ]);
        return $this->fetch();
    }

    //新闻详情页面
    public function newsDetail(Request $request)
    {
        $aid = intval($request->get('aid'));
        if (isset($aid) && !empty($aid)) {
            $thisNews = Db::name('article')->where('f_article_id', '=', $aid)->select();
            if (!$thisNews) {
                return $this->fetch('./404');
            }
            $thisNews = $thisNews[0];
//            $thisNews['f_article_content'] = preg_replace('/img src=/', 'img lay-src=', $thisNews['f_article_content']);
            $res = $this->_initData($thisNews['f_menu_id']);
            if (!$res)
                return $this->fetch('./404');
            $tuiJianArticle = Db::name('article')
                ->field('f_article_id,f_article_title,f_real_time')
                ->where('f_menu_id', '=', $thisNews['f_menu_id'])
                ->where('f_article_id', '<>', $aid)
                ->order('f_real_time desc')
                ->limit(0, 5)
                ->select();
            $this->assign([
                "companyInfo" => $this->companyInfo,
                "navLeft" => $this->navLeft,
                "navFirst" => $this->navFirst,
                "posCurr" => $this->posCurr,
                "menuId" => $thisNews['f_menu_id'],
                "thisNews" => $thisNews,
                "tuiJianArticle" => $tuiJianArticle
            ]);
            return $this->fetch('newsDetail');
        } else {
            return $this->fetch('./404');
        }
    }

    public function _empty()
    {
        return $this->fetch('./404');
    }
}
