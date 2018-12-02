layui.define(['layer', 'form', 'flow'], function (exports) {
    var $ = layui.jquery
        , layer = layui.layer
        , flow = layui.flow
        , form = layui.form;
    var obj = {
        /**
         * 验证是否引入layui
         */
        checkLayui: function () {
            if (layui == undefined || layui == null) {
                alert('请引入layui插件');
                return;
            }
        },
        /**
         *  pc： pc端执行的函数
         *  mobile: mobile端执行的函数
         */
        diffDevice: function (pc, mobile) {
            var device = layui.device();
            if (device.ios || device.android || device.weixin) {
                mobile && mobile();
            } else {
                pc && pc();
            }
        },
    };
    exports("commonHome", obj);
});