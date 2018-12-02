<?php

namespace app\admin\controller;

use think\Request;
use think\Db;

class Content extends AdminBase
{

    //空方法
    public function _empty()
    {
        return $this->fetch('./404');
    }

    /**需要的***/
    public function companyInfo()
    {
        $res = Db::name('company_info')->where('f_id', 1)->find();
        $this->assign('companyInfo', $res);
        return $this->fetch();
    }

    //发表文章
    public function postArticle()
    {
//        $menuInfo = Db::name('menu')
//            ->field('f_menu_id,f_menu_name,f_parent_id')
//            ->where('f_parent_id', '<>', 0)
//            ->where('f_parent_id', '<>', 3)
//            ->where('f_parent_id', '<>', 6)
//            ->where('f_menu_id', '<>', 11)
//            ->where('f_menu_id', '<>', 12)
//            ->where('f_menu_id', '<>', 35)
////            ->group('f_parent_id')
//            ->order('f_parent_id')
//            ->select();
        $parentMenu = Db::name('menu')
            ->field('f_menu_id,f_menu_name')
            ->where('f_parent_id', '=', 0)
            ->order('f_parent_id')
            ->select();
        $this->assign([
//            'menuInfo' => $menuInfo,
            'parentMenu' => $parentMenu
        ]);
        return $this->fetch();
    }

    //文章列表
    public function ArticleList()
    {
        return $this->fetch();
    }

    //发表文章
    public function postNews()
    {
        $parentMenu = Db::name('menu')
            ->field('f_menu_id,f_menu_name')
            ->where('f_parent_id', '=', 0)
            ->order('f_parent_id')
            ->select();
        $this->assign([
//            'menuInfo' => $menuInfo,
            'parentMenu' => $parentMenu
        ]);
        return $this->fetch();
    }

    //管理新闻
    public function newsList()
    {
        return $this->fetch();
    }

    //管理资质
    public function ziZhi()
    {
        return $this->fetch('zizhi');
    }

    //资质列表
    public function ziZhiList()
    {
        return $this->fetch('zizhiList');
    }

    //荣誉证书
    public function rongYu()
    {
        return $this->fetch();
    }

    //荣誉证书列表
    public function rongYuList()
    {
        return $this->fetch();
    }

    //职位
    public function position()
    {
        return $this->fetch();
    }

    //职位列表
    public function positionList()
    {
        return $this->fetch();
    }

    public function productionAndSolution()
    {
        return $this->fetch();
    }

    //banner设置
    public function bannerZiZhi()
    {
        $banner = Db::name('menu')
            ->field('f_banner_path')
            ->where('f_menu_id', '=', 11)
            ->find()['f_banner_path'];
        $this->assign([
            'bannerPath' => $banner
        ]);
        return $this->fetch();
    }

    public function bannerRongYu()
    {
        $banner = Db::name('menu')
            ->field('f_banner_path')
            ->where('f_menu_id', '=', 12)
            ->find()['f_banner_path'];
        $this->assign([
            'bannerPath' => $banner
        ]);
        return $this->fetch();
    }

    public function bannerNews()
    {
        $banner = Db::name('menu')
            ->field('f_banner_path')
            ->where('f_menu_id', '=', 13)
            ->find()['f_banner_path'];
        $this->assign([
            'bannerPath' => $banner
        ]);
        return $this->fetch();
    }

    public function manageBg()
    {
        $imgPath = Db::name('homepage_img')
            ->field('f_img_path')
            ->where('f_id=1')
            ->find();
        $this->assign([
            'imgPath' => substr($imgPath['f_img_path'],1)
        ]);
        return $this->fetch('manageBg');
    }

    public function manageModuleImg()
    {
        $imgPath = Db::name('homepage_img')
            ->field('f_img_path')
            ->where('f_id>1 AND f_id < 6')
            ->select();
        $this->assign([
            'imgPath' => $imgPath
        ]);
        return $this->fetch('manageModuleImg');
    }


    /**其它*/
    public function center()
    {
        return $this->fetch();
    }

    public function account()
    {
        return $this->fetch();
    }

    public function navList()
    {
        return $this->fetch();
    }

    public function manaLogs()
    {
        return $this->fetch();
    }

    public function personal()
    {
        return $this->fetch();
    }

    public function updateInfo()
    {
        return $this->fetch();
    }
}
