layui.define(['icheck', 'common'], function (exports) {
    var $ = layui.jquery,
        common = layui.common;
    var obj = {
        inputStyle: function () {
            //加载单选框样式
            $('.layui-table .icheck input').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        },
        chooseAll: function () {
            //全选
            $('#selected-all').on('ifChanged', function (event) {
                var $input = $('.layui-table tbody tr td').find('input');
                $input.iCheck(event.currentTarget.checked ? 'check' : 'uncheck');
            });
        },
        chooseOne: function () {
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
        },
        stopE: function () {
            $('.layui-table .stopRow').on('click', function (e) {
                layui.stope(e);
            });
        },
        //doAction: function () {
        //    //编辑  删除事件
        //    $('.doAction').on('click', function () {
        //        var $this = $(this)
        //            , type = $this.data('type')
        //            , url = $this.data('href');
        //        switch (type) {
        //            case 'edit':
        //                common.layerIframeTitle2(920, 660, url, "编辑文章");
        //                break;
        //            case 'delete':
        //                var callback = function (result) {
        //                    if (result.state == 1)
        //                        window.location.reload();
        //                    else
        //                        common.layerAlertE(result.message, '提示');
        //                };
        //                common.layerDel('确认删除这些信息？', '此操作不可逆，请再次确认是否要操作。', url, 'post', 'json', {"action": "Delete"}, callback);
        //                break;
        //            case 'preview':
        //                common.layerIframe(320, 568, url);
        //                break;
        //        }
        //    });
        //},
    };
    exports("listTpl", obj);
});
