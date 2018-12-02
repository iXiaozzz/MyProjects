//Layui 扩展组件入口
layui.config({
    base: '/static/plus/layui/lay/modules/extendplus/' //自定义layui组件的目录
}).extend({//设定组件别名
    common: 'common',
    navbar: 'navbar/navbar',
    tab: 'navbar/tab',
    icheck: 'icheck/icheck',
    browser: 'browser',
    paging: 'paging',
    myDate: 'myDate',
    mupload: 'mupload',
    listTpl: 'listTpl',
    validator: 'validator'
});

layui.use(['layer', 'element', 'util', 'tab', 'common', 'table'], function () {
    var $ = layui.jquery
        , layer = layui.layer
        , device = layui.device()//设备信息
        , common = layui.common
        , element = layui.element
        , table = layui.table;
    var tab = layui.tab({
        elem: '.layui-tab-card' //设置选项卡容器
    });

    //阻止IE7以下访问
    if (device.ie && device.ie < 8) {
        layer.alert('最低支持ie8，您当前使用的是古老的 IE' + device.ie + '！');
    }

    //手机设备的简单适配
    var treeMobile = $('.site-tree-mobile')
        , shadeMobile = $('.site-mobile-shade');

    treeMobile.on('click', function () {
        $('body').addClass('site-mobile');
    });

    shadeMobile.on('click', function () {
        $('body').removeClass('site-mobile');
    });
    //捐赠
    $('#pay').on('click', function () {
        common.layerDiv($('.shang_box'), 562, 450);
    });
    //weixin、weibo
    $('#git,#weibo,#weixin').on('click', function () {
        layer.tips('暂时没有哦!', this)
    });

    //监听工具条
    table.on('tool(tableList)', function (obj) {
            var data = obj.data
                , $this = $(this)
                , type = $this.data('type');

            switch (obj.event) {
                //查看
                case 'detail':
                    var url = '';
                    switch (type) {
                        case 'position':
                            url = $this.data('url') + data.f_id;
                            common.layerIframeNoReload(500, 360, url, '查看');
                            break;
                        case 'article':
                            url = $this.data('url') + data.f_article_id;
                            common.layerIframeNoReload(500, 360, url, '查看');
                            break;
                        case 'file':
                            url = $this.data('url') + data.f_id;
                            common.layerIframeNoReload(500, 360, url, '查看');
                            break;
                    }
                    break;
                //编辑
                case 'edit':
                    var url = '';
                    switch (type) {
                        case 'position':
                            url = $this.data('url') + data.f_id;
                            common.layerIframeTitle(700, 400, url, '编辑');
                            break;
                        case 'article':
                            url = $this.data('url') + data.f_article_id;
                            common.layerIframeTitle(700, 400, url, '编辑');
                            break;
                        case 'production':
                            url = $this.data('url') + data.f_id;
                            common.layerIframeTitle(690, 350, url, '编辑');
                            break;
                        case 'updateCoverImg':
                            url = $this.data('url') + data.f_article_id;
                            common.layerIframeTitle(500, 400, url, '修改封面');
                            break;
                        case 'file':
                            url = $this.data('url') + data.f_id;
                            common.layerIframeNoReload(540, 380, url, '编辑');
                            break;
                    }

                    break;
                //删除
                case 'del':
                    var url = '';
                    switch (type) {
                        case 'position':
                            url = $this.data('url') + data.f_id;
                            break;
                        case 'article':
                            url = $this.data('url') + data.f_article_id;
                            break;
                        case 'file':
                            url = $this.data('url') + data.f_id;
                            break;
                    }
                    layer.confirm('确定删除吗？', function (index) {
                        common.ajax(url, 'GET', 'JSON', {}, true, function (res) {
                            if (res.code == 1200) {
                                obj.del();
                                common.layerMsg(1, res.msg, 2000, function () {
                                    layer.close(index);
                                });
                            } else {
                                common.layerAlert(2, res.msg, '提示');
                            }
                        });
                    });

                    break;
                default:
                    break;
            }
        }
    );


    var adminGolbalActive = {
        getCheckData: function () { //获取选中数据
            var checkStatus = table.checkStatus('tableList')
                , data = checkStatus.data;
            layer.alert(JSON.stringify(data));
        }
        , getCheckLength: function () { //获取选中数目
            var checkStatus = table.checkStatus('tableList')
                , data = checkStatus.data;
            layer.msg('选中了：' + data.length + ' 个');
        }
        , isAll: function () { //验证是否全选
            var checkStatus = table.checkStatus('tableList');
            layer.msg(checkStatus.isAll ? '全选' : '未全选')
        }
        //批量删除
        , delete: function () {
            var $this = $(this)
                , url = $this.data('url')
                , belong = $this.data('belong')
                , checkStatus = table.checkStatus('tableList')
                , data = checkStatus.data
                , idArr = [];
            if (data.length < 1) {
                layer.msg('请选择要删除的数据!');
                return;
            }
            switch (belong) {
                case 'position':
                    data.forEach(function (item) {
                        idArr.push(item.f_id);
                    });
                    break;
                case 'article':
                    data.forEach(function (item) {
                        idArr.push(item.f_article_id);
                    });
                    break;
                case 'file':
                    data.forEach(function (item) {
                        idArr.push(item.f_id);
                    });
                    break;
            }
            layer.confirm('确定删除吗？', function (index) {
                common.ajax(url, 'POST', 'JSON', {data: JSON.stringify(idArr)}, true, function (res) {
                    if (res.code == 1200) {
                        common.layerMsg(6, res.msg, 2000, function () {
                            window.location.reload();
                        });
                    } else {
                        common.layerAlert(2, res.msg, '提示');
                    }
                });
            });
        }
        //刷新
        , doRefresh: function () {
                window.location.reload();
            }

    };

    $('.demoTable .do-action').on('click', function () {
        var type = $(this).data('type');
        adminGolbalActive[type] ? adminGolbalActive[type].call(this) : '';
    });

});
