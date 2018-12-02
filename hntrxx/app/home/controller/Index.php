<?php

namespace app\home\controller;

use think\Db;

class Index extends HomeBase
{
    public function index()
    {
        $newsList = Db::name('article')
            ->field('f_article_id,f_article_title,f_real_time,f_cover_img_path')
            ->where('f_menu_id=13 OR f_menu_id=14')
            ->order('f_top desc,f_real_time desc')
            ->limit(0, 5)
            ->select();
        $jieJue = Db::name('menu')->field('f_menu_name,f_url')
            ->where('f_parent_id=5')
            ->select();
        $yeWu = Db::name('menu')->field('f_menu_name,f_url')
            ->where('f_parent_id=4')
            ->select();
        $imgPath = Db::name('homepage_img')
            ->field('f_img_path')
            ->where('f_id>0 AND f_id < 6')
            ->select();
        $this->assign([
            "companyInfo" => $this->companyInfo,
            "posCurr" => ['f_menu_id' => 1],
            "yeWu" => $yeWu,
            "jieJue" => $jieJue,
            "newsList" => $newsList,
            "title" => '首页',
            "imgPath" => $imgPath,
            "firstImg" => $newsList[0]['f_cover_img_path']
        ]);
        return $this->fetch();
    }

    public function demo()
    {
        $htmlStr = Db::name('article')->field('f_article_content')->where('f_article_id', '=', 45)->find()['f_article_content'];
        $arr = html2imgs($htmlStr);
        halt($arr);
    }

    public function _empty()
    {
        return $this->fetch('./404');
    }
}
