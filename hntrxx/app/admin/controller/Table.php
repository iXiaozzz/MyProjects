<?php

namespace app\admin\controller;


use think\Controller;
use think\Request;

class Table extends Controller
{

    public function user(Request $request)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');
        $offset = ($page-1)*$limit;//起始位置
        $data = [
            [
                'id' => 1,
                'username' => 'user1',
                'sex' => '男',
                'city' => '上海',
                'sign' => 'ixaozzz',
                'experience' => 10000,
                'score' => 3224,
                'classify' => '销售',
                'wealth' => 1000000
            ], [
                'id' => 2,
                'username' => 'user2',
                'sex' => '男',
                'city' => '长沙',
                'sign' => 'user2',
                'experience' => 8000,
                'score' => 4324,
                'classify' => '运营',
                'wealth' => 10000
            ], [
                'id' => 3,
                'username' => 'user3',
                'sex' => '男',
                'city' => '上海',
                'sign' => 'user3',
                'experience' => 23942,
                'score' => 23435,
                'classify' => 'IT',
                'wealth' => 34534323
            ],[
                'id' => 4,
                'username' => 'user3',
                'sex' => '男',
                'city' => '上海',
                'sign' => 'user3',
                'experience' => 23942,
                'score' => 23435,
                'classify' => 'IT',
                'wealth' => 34534323
            ],[
                'id' => 5,
                'username' => 'user3',
                'sex' => '男',
                'city' => '上海',
                'sign' => 'user3',
                'experience' => 23942,
                'score' => 23435,
                'classify' => 'IT',
                'wealth' => 34534323
            ],[
                'id' => 6,
                'username' => 'user3',
                'sex' => '男',
                'city' => '上海',
                'sign' => 'user3',
                'experience' => 23942,
                'score' => 23435,
                'classify' => 'IT',
                'wealth' => 34534323
            ],[
                'id' => 7,
                'username' => 'user3',
                'sex' => '男',
                'city' => '上海',
                'sign' => 'user3',
                'experience' => 23942,
                'score' => 23435,
                'classify' => 'IT',
                'wealth' => 34534323
            ],[
                'id' => 8,
                'username' => 'user3',
                'sex' => '男',
                'city' => '上海',
                'sign' => 'user3',
                'experience' => 23942,
                'score' => 23435,
                'classify' => 'IT',
                'wealth' => 34534323
            ],[
                'id' => 9,
                'username' => 'user3',
                'sex' => '男',
                'city' => '上海',
                'sign' => 'user3',
                'experience' => 23942,
                'score' => 23435,
                'classify' => 'IT',
                'wealth' => 34534323
            ],

        ];
        return json([
            "code" => 0,
            "msg" => "请求成功",
            "count" => count($data),
            "data" => array_slice($data,$offset,$limit)
        ]);
    }
}