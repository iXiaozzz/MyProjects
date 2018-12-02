SCOPE = {
    "doAdd_url": "/admin/ManageUser/addUser",
    "doAddRoom_url": "/admin/manageRoom/addRoom",
    "doEdit_url": "/admin/ManageUser/editUser",
    "doEditRoom_url": "/admin/ManageRoom/editRoom",
    "doLock_url": "/admin/ManageUser/lockUser",
    "doDelete_url": "/admin/ManageUser/deleteUser",
    //选择模块
    "doBatchModule_url": "/admin/ManageHome/doBatchModule",//批量操作模块
    "configModule_url": "/admin/ManageHome/configModule",//配置模块
};

layui.use(['common', 'icheck'], function () {
    var $ = layui.jquery
        , common = layui.common;

    //加载单选框样式
    $('.layui-table .icheck input').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });
    //阻止冒泡
    $('.layui-table .stopRow').on('click', function (e) {
        layui.stope(e);
    });

    //表格行点击勾选
    $('.layui-table tbody tr').on('click', function () {
        var $this = $(this);
        var $input = $this.children('td').eq(0).find('input');
        $input.on('ifChecked', function (e) {
            $this.css('background-color', '#EEEEEE');
        });
        $input.on('ifUnchecked', function (e) {
            $this.removeAttr('style');
        });
        $input.iCheck('toggle');
    }).find('input').each(function () {
        var $this = $(this);
        $this.on('ifChecked', function (e) {
            $this.parents('tr').css('background-color', '#EEEEEE');
        });
        $this.on('ifUnchecked', function (e) {
            $this.parents('tr').removeAttr('style');
        });
    });
    //全选
    $('#selected-all').on('ifChanged', function (event) {
        var $input = $('.layui-table tbody tr td').find('input');
        $input.iCheck(event.currentTarget.checked ? 'check' : 'uncheck');
    });

    var active = {
        //添加操作
        doAdd: function () {
            var $this = $(this)
                , url = $this.data('href')
                , title = $this.data('title');
            if (url) {
                switch (title) {
                    case "新增用户":
                        common.layerIframeTitle(470, 600, url, title);
                        break;
                    case "新增房型":
                        common.layerIframeTitle(700, 850, url, title);
                        break;
                    case "新增文字":
                        common.layerIframeTitle(470, 450, url, title);
                        break;
                    case "新增活动":
                        common.layerIframeTitle(470, 650, url, title);
                        break;
                    case "新增地方":
                        common.layerIframeTitle(470, 400, url, title);
                        break;
                    case "新增产品":
                        common.layerIframeTitle(470, 550, url, title);
                        break;
                    case "新增背景":
                        common.layerIframeTitle(470, 440, url, title);
                        break;
                    case "新增店家":
                        var callback = function () {
                            window.location.reload();
                        };
                        common.myAjax(url, 'POST', 'json', {"doAction": "addHotel"}, callback);
                        break;
                }
            }

        },
        //编辑操作
        doEdit: function () {
            var $this = $(this)
                , url = $this.data('href')
                , title = $this.data('title');
            if (url) {
                switch (title) {
                    case "编辑用户":
                        common.layerIframeTitle(470, 667, url, title);
                        break;
                    case "编辑房型":
                        common.layerIframeTitle(470, 667, url, title);
                        break;
                    case "编辑文字":
                        common.layerIframeTitle(470, 460, url, title);
                        break;
                    case "编辑活动":
                        common.layerIframeTitle(470, 460, url, title);
                        break;
                    case "编辑地方":
                        common.layerIframeTitle(470, 250, url, title);
                        break;
                    case "编辑产品":
                        common.layerIframeTitle(470, 400, url, title);
                        break;
                    case "编辑背景":
                        common.layerIframeTitle(470, 300, url, title);
                        break;
                }
            }
            else {
                common.layerAlertE('链接错误！', '提示');
            }

        },
        //禁止用户
        doLock: function () {
            var $this = $(this)
            //, url = $this.data('href')
                , url = SCOPE.doLock_url
                , $i = $this.children('i');
            if ($i.hasClass('fa-unlock')) {
                $i.removeClass('fa-unlock').addClass('fa-lock');
            } else {
                $i.removeClass('fa-lock').addClass('fa-unlock');
            }
        },
        //doDelete: function () {
        //    //var url = $(this).data('href');
        //    var url = SCOPE.doDelete_url;
        //    if (url) {
        //        //查出选择的记录
        //        if ($(".layui-table tbody input:checked").size() < 1) {
        //            common.layerAlertE('对不起，请选中您要操作的记录！', '提示');
        //            return false;
        //        }
        //        var ids = "";
        //        var checkObj = $(".layui-table tbody input:checked");
        //        for (var i = 0; i < checkObj.length; i++) {
        //            if (checkObj[i].checked && $(checkObj[i]).attr("disabled") != "disabled")
        //                ids += $(checkObj[i]).attr("ids") + ','; //如果选中，将value添加到变量idlist中
        //        }
        //        var data = {"ids": ids};
        //        common.layerDel('确认删除这些信息？', '此操作不可逆，请再次确认是否要操作。', url, 'post', 'json', data);
        //    }
        //    else {
        //        common.layerAlertE('链接错误！', '提示');
        //    }
        //},
        doBatchDelete: function () {
            var url = $(this).data('href');
            if (url) {
                if ($(".layui-table tbody tr .icheck input:checked").size() < 1) {
                    common.layerAlertE('对不起，请选中您要删除的信息！', '提示');
                    return false;
                }
                var ids = "";
                var checkObj = $(".layui-table tbody tr .icheck input:checked");
                for (var i = 0; i < checkObj.length; i++) {
                    if (checkObj[i].checked && $(checkObj[i]).attr("disabled") != "disabled")
                        ids += $(checkObj[i]).attr("ids") + ','; //如果选中，将value添加到变量idlist中
                }
                var data = {"ids": ids};
                var callback = function (result) {
                    if (result.state == 1) {
                        window.location.reload();
                    } else {
                        obj.layerAlertE(data.message, '提示');
                    }
                };
                common.layerDel('确认删除这些信息？', '此操作不可逆，请再次确认是否要操作。', url, 'post', 'json', data, callback);
            }
            else {
                common.layerAlertE('链接错误！', '提示');
            }
        },
        doDbBak: function () {
            var url = $(this).data('href');
            if (url) {
                common.ajax(url, 'post', 'json', '');
            }
            else {
                common.layerAlertE('链接错误！', '提示');
            }
        },
        doAction: function () {
            var url = $(this).data('href');
            if (url) {
                //查出选择的记录
                if ($(".layui-table tbody input:checked").size() < 1) {
                    common.layerAlertE('对不起，请选中您要操作的记录！', '提示');
                    return false;
                }
                var ids = "";
                var checkObj = $(".layui-table tbody input:checked");
                for (var i = 0; i < checkObj.length; i++) {
                    if (checkObj[i].checked && $(checkObj[i]).attr("disabled") != "disabled")
                        ids += $(checkObj[i]).attr("ids") + ','; //如果选中，将value添加到变量idlist中
                }
                var data = {"ids": ids};
                common.ajax(url, 'post', 'json', data);
            }
            else {
                common.layerAlertE('链接错误！', '提示');
            }
        },
        //批量关闭模块
        doBatchCloseModule: function () {
            var url = SCOPE.doBatchModule_url;
            if (url) {
                //查出选择的记录
                if ($(".layui-table tbody input:checked").size() < 1) {
                    common.layerAlertE('对不起，请选中您要操作的模块！', '提示');
                    return false;
                }
                var ids = "";
                var checkObj = $(".layui-table tbody tr .icheck input:checked");
                for (var i = 0; i < checkObj.length; i++) {
                    if (checkObj[i].checked && $(checkObj[i]).attr("disabled") != "disabled")
                        ids += $(checkObj[i]).attr("ids") + ','; //如果选中，将value添加到变量idlist中
                }
                var data = {"type": "close", "ids": ids};
                var callback = function (result) {
                    if (result.state == 1) {
                        window.location.reload();
                    } else {
                        obj.layerAlertE(data.message, '提示');
                    }
                };
                common.layerDel('提示', '确定要关闭所选模块吗？', url, 'POST', 'json', data, callback);
            }
            else {
                common.layerAlertE('链接错误！', '提示');
            }
        },
        //批量开启模块
        doBatchOpenModule: function () {
            var url = SCOPE.doBatchModule_url;
            if (url) {
                //查出选择的记录
                if ($(".layui-table tbody input:checked").size() < 1) {
                    common.layerAlertE('对不起，请选中您要操作的模块！', '提示');
                    return false;
                }
                var ids = "";
                var checkObj = $(".layui-table tbody tr .icheck input:checked");
                for (var i = 0; i < checkObj.length; i++) {
                    if (checkObj[i].checked && $(checkObj[i]).attr("disabled") != "disabled")
                        ids += $(checkObj[i]).attr("ids") + ','; //如果选中，将value添加到变量idlist中
                }
                var data = {"type": "open", "ids": ids};
                var callback = function (result) {
                    if (result.state == 1) {
                        window.location.reload();
                    } else {
                        obj.layerAlertE(data.message, '提示');
                    }
                };
                common.layerDel('提示', '确定要开启所选模块吗？', url, 'POST', 'json', data, callback);
            }
            else {
                common.layerAlertE('链接错误！', '提示');
            }
        },
    };

    $('.do-action').on('click', function (e) {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
        layui.stope(e);
    });


    //子层 open tab
    $($('.open-tab')).on("click", function () {
        var tab = parent.layui.tab({
            elem: '.layui-tab-card' //设置选项卡容器
        });
        $this = $(this);
        var data = {
            field: {
                href: $this.data('href'),
                icon: $this.data('icon'),
                title: $this.data('title')
            }
        };
        //这是核心代码。
        tab.tabAdd(data.field);
    });
});

