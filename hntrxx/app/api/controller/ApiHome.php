<?php

namespace app\api\controller;


use app\home\controller\HomeBase;
use think\Db;
use think\Request;

class ApiHome extends HomeBase
{
    private $menuArr = [13, 14];
    private $menuFile = [11, 12];

    public function getNewsListByLimit(Request $request)
    {
        $menuId = intval($request->param('menuId'));
        if (in_array($menuId, $this->menuArr)) {
            $page = $request->post('page');
            $len = $request->post('pageSize');
            $offset = ($page - 1) * $len;
            $newsList = Db::name('article')
                ->field('f_article_id,f_cover_img_path,f_summary,f_real_time,f_article_title')
                ->where('f_menu_id', '=', $menuId)
                ->order('f_real_time desc')
                ->limit($offset, $len)
                ->select();
            if ($newsList) {
                foreach ($newsList as &$item) {
                    $item['f_cover_img_path'] = substr($item['f_cover_img_path'], 1);
//                    $item['f_article_content'] = substr(clear_all($item['f_article_content']), 0, 500);
//                    $item['f_article_content'] = mb_substr(clear_all($item['f_article_content']), 0, 200, 'utf-8');
                    $item['f_real_time'] = substr($item['f_real_time'], 0, 10);
                }
            }
            return respond(1200, '请求成功', $newsList);
        } else {
            return respond(1201, '非法请求');
        }
    }

    public function getNewsAllListByLimit(Request $request)
    {
        $menuId = $request->param('menuId');
        if ($menuId === 'all') {
            $page = $request->post('page');
            $len = $request->post('pageSize');
            $offset = ($page - 1) * $len;
            $newsList = Db::name('article')
                ->field('f_article_id,f_cover_img_path,f_summary,f_real_time,f_article_title')
                ->where('f_menu_id=13 OR f_menu_id=14')
                ->order('f_real_time desc')
                ->limit($offset, $len)
                ->select();
            if ($newsList) {
                foreach ($newsList as &$item) {
                    $item['f_cover_img_path'] = substr($item['f_cover_img_path'], 1);
//                    $item['f_article_content'] = substr(clear_all($item['f_article_content']), 0, 500);
//                    $item['f_article_content'] = mb_substr(clear_all($item['f_article_content']), 0, 200, 'utf-8');
                    $item['f_real_time'] = substr($item['f_real_time'], 0, 10);
                }
            }
            return respond(1200, '请求成功', $newsList);
        } else {
            return respond(1201, '非法请求');
        }
    }

    public function getFileListByLimit(Request $request)
    {
        $menuId = intval($request->post('menuId'));
        if (in_array($menuId, $this->menuFile)) {
            $page = $request->post('page');
            $len = $request->post('pageSize');
            $offset = ($page - 1) * $len;
            $fileList = Db::name('file')
                ->field('f_id,f_file_title,f_large_file_path,f_small_file_path,f_large_file_width,f_large_file_height,f_img_flag')
                ->where('f_menu_id', '=', $menuId)
                ->order('f_img_flag desc,f_order,f_create_time desc')
                ->limit($offset, $len)
                ->select();
            return respond(1200, '请求成功', $fileList);
        } else {
            return respond(1201, '非法请求');
        }
    }

    public function getProductionAndSolutionInfo(Request $request)
    {
        $action = $request->param('action');
        if ($action === 'production') {
            $page = $request->post('page');
            $len = $request->post('pageSize');
            $offset = ($page - 1) * $len;
            $res = Db::query("SELECT m.f_menu_name,m.f_url,p.f_disImg_path
                                FROM t_menu m RIGHT JOIN t_production_solution p
                                ON m.f_menu_id=p.f_menu_id
                                WHERE m.f_parent_id =5 LIMIT $offset,$len");
            return respond(1200, '请求成功!', $res);
        } else {
            return respond(1201, '非法请求');
        }
    }
}
