var common = {
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
        //    验证是否引入layui
        // this.checkLayui();
        let device = layui.device();
        if (device.ios || device.android || device.weixin) {
            mobile && mobile();
        } else {
            pc && pc();
        }
    },

    getWindowWidth: function () {
        return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    },
    getWindowHeight: function () {
        return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    }
};

