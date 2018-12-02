<?php

namespace app\home\controller;


use think\Controller;
use think\Db;
use app\common\model\Article as ArticleModel;

class HomeBase extends Controller
{
    protected $companyInfo;
    protected $article;
    protected $navLeft;
    protected $navFirst;
    protected $posCurr;
    protected $parentId;

    public function __construct()
    {
        parent::__construct();
        $this->companyInfo = $this->getCompanyInfo();
    }


    protected function _initData($menuId)
    {
        $this->article = new ArticleModel();
        $this->navLeft = $this->article->query('SELECT f_menu_id fid,f_menu_name,f_url,f_parent_id FROM t_menu as m WHERE m.f_parent_id = (SELECT f_parent_id from t_menu WHERE f_menu_id =' . $menuId . ')');
        $this->posCurr = $this->article->query('SELECT m.f_menu_id,m.f_menu_name as pmenu_name,n.f_menu_name as smenu_name FROM t_menu as m JOIN t_menu as n ON m.f_menu_id = n.f_parent_id WHERE n.f_menu_id=' . $menuId);
        if (isset($this->navLeft) && !empty($this->navLeft) && isset($this->posCurr) && !empty($this->posCurr)) {
            $this->posCurr = $this->posCurr[0];
            $this->parentId = intval($this->navLeft[0]['f_parent_id']);
            switch ($this->parentId) {
                case 3:
                    $this->navFirst = 'newsAll.html';
                    break;
                case 5:
                    $this->navFirst = 'productAndSolution.html';
                    break;
                case 6:
                    $this->navFirst = 'contact.html?m=34';
                    break;
                default:
                    $this->navFirst = $this->navLeft[0]['f_url'];
                    break;
            }
            return true;
        } else {
            return false;
        }
    }

    protected function getCompanyInfo()
    {
        return Db::name('company_info')->where('f_id', '=', 1)->find();
    }

    public function _empty()
    {
        return $this->fetch('./404');
    }
}
