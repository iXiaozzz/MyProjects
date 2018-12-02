<?php

namespace app\admin\controller;

use think\Request;
class Index extends AdminBase
{
    public function _empty()
    {
        return $this->fetch('./404');
    }

    public function index()
    {
        $this->assign([
            "adminInfo" => $this->adminInfo
        ]);
        return $this->fetch();
    }

    public function SideMenu(Request $request)
    {
        $fid = $request->get('fid');
        switch ($fid) {
            case 5:
                return json([
                    "state" => 1
                    , "message" => "success"
                    , "data" => [
                        [
                            "title" => '公司信息'
                            , "icon" => "fa fa-tags"
                            , "href" => "/companyInfo.html"
                            , "spread" => true
                            , "children" => []
                        ],
                        [
                            "title" => '所有文章'
                            , "icon" => "fa fa-tags"
                            , "href" => "/postNews.html"
                            , "spread" => false
                            , "children" => [
                            [
                                "title" => '发表文章'
                                , "icon" => "fa fa-tag"
                                , "href" => "/postArticle.html"
                                , "spread" => true
                                , "children" => ''
                            ],
                            [
                                "title" => '管理文章'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/articleList"
                                , "spread" => true
                                , "children" => ''
                            ],
                            [
                                "title" => '新闻中心'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/postNews"
                                , "spread" => true
                                , "children" => ''
                            ], [
                                "title" => '管理新闻'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/newsList"
                                , "spread" => true
                                , "children" => ''
                            ]
                        ]

                        ],
                        [
                            "title" => '企业资质与荣誉'
                            , "icon" => "fa fa-tags"
                            , "href" => ""
                            , "spread" => false
                            , "children" => [
                            [
                                "title" => '企业资质'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/ziZhi"
                                , "spread" => true
                                , "children" => ''
                            ],
                            [
                                "title" => '管理资质'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/ziZhiList"
                                , "spread" => true
                                , "children" => ''
                            ],
                            [
                                "title" => '企业荣誉'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/rongYu"
                                , "spread" => true
                                , "children" => ''
                            ],
                            [
                                "title" => '管理荣誉'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/rongYuList"
                                , "spread" => true
                                , "children" => ''
                            ],
                        ]

                        ],
                        [
                            "title" => '招贤纳士'
                            , "icon" => "fa fa-tags"
                            , "href" => ""
                            , "spread" => false
                            , "children" => [
                            [
                                "title" => '发布招聘'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/position"
                                , "spread" => true
                                , "children" => ''
                            ],
                            [
                                "title" => "管理招聘"
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/positionList"
                                , "spread" => true
                                , "children" => ''
                            ]

                        ]
                        ],
                        [
                            "title" => '产品及解决方案'
                            , "icon" => "fa fa-tags"
                            , "href" => "/admin/content/productionAndSolution"
                            , "spread" => true
                            , "children" => ""
                        ],
                        [
                            "title" => 'banner设置'
                            , "icon" => "fa fa-tags"
                            , "href" => ""
                            , "spread" => false
                            , "children" => [
                            [
                                "title" => '资质'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/bannerZiZhi"
                                , "spread" => true
                                , "children" => ''
                            ],
                            [
                                "title" => '荣誉'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/bannerRongYu"
                                , "spread" => true
                                , "children" => ''
                            ],
                            [
                                "title" => '新闻'
                                , "icon" => "fa fa-tag"
                                , "href" => "/admin/content/bannerNews"
                                , "spread" => true
                                , "children" => ''
                            ],
                        ]
                        ]
                    ]
                ]);
                break;
            case 15:
                return json([
                    "state" => 1
                    , "message" => "success"
                    , "data" => [
                        [
                            "title" => '首页背景图'
                            , "icon" => "fa fa-user-circle-o"
                            , "href" => "/admin/content/manageBg"
                            , "spread" => true
                            , "children" => []
                        ],
                        [
                            "title" => '首页模块图'
                            , "icon" => "fa fa-user-circle-o"
                            , "href" => "/admin/content/manageModuleImg"
                            , "spread" => true
                            , "children" => []
                        ],
                    ]
                ]);
                break;
            case 25:
                return json([
                    "state" => 1
                    , "message" => "success"
                    , "data" => [
                        [
                            "title" => '用户管理'
                            , "icon" => "fa fa-user-circle-o"
                            , "href" => ""
                            , "spread" => false
                            , "children" => [
                            [
                                "title" => "普通用户",
                                "icon" => "fa fa-user-o",
                                "href" => "/admin/content/account",
                                "spread" => true,
                                "children" => null
                            ]
                            , [
                                "title" => "会员用户",
                                "icon" => "fa fa-user-o",
                                "href" => "/admin/content/account",
                                "spread" => true,
                                "children" => null
                            ]
                        ]
                        ]
                        , [
                            "title" => '管理员管理'
                            , "icon" => "fa fa-user-circle-o"
                            , "href" => "/admin/content/account"
                            , "spread" => true
                        ]
                    ]
                ]);
                break;
        }
    }
}
