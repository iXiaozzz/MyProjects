layui.define(['layer', 'form', 'flow'], function (exports) {
    var $ = layui.jquery
        , layer = layui.layer
        , flow = layui.flow
        , form = layui.form;
    /*****
     * 返回状态码
     * 1200   请求成功
     * 1201   请求失败
     */
    var obj = {
        /**ajax的封装**/
        ajax: function (url, type, dataType, data, async, callback) {
            async = async || true;
            $.ajax({
                url: url,
                type: type,
                dataType: dataType,
                data: data,
                async: async,
                success: function (respond) {
                    callback && callback(respond);
                },
                error: function () {
                    obj.layerAlert(2, '网络异常，请重试！', '提示');
                }
            });
        },
        /**弹出层**/
        layerDel: function (title, text, url, type, dataType, data, callback) {
            layer.confirm(text, {
                title: title,
                btnAlign: 'c',
                resize: false,
                icon: 3,
                btn: ['确定删除', '容我想想'],
                yes: function (index) {
                    layer.close(index);
                    obj.ajaxCallback(url, type, dataType, data, callback);
                }
            });
        },
        //开启和关闭模块的操作
        layerModule: function (title, text, url, type, dataType, data, callback) {
            layer.confirm(text, {
                title: title,
                btnAlign: 'c',
                resize: false,
                icon: 3,
                btn: ['确定', '容我想想'],
                yes: function () {
                    obj.ajaxCallback(url, type, dataType, data, callback);
                }
            });
        },
        /**
         * 抛出一个异常错误信息
         * @param {String} msg
         */
        throwError: function (msg) {
            throw new Error(msg);
            return;
        },
        /**
         * 提示
         * @param icon 图标 1.正确 2.错误
         * @param text 内容
         * @param title 标题
         * @param time  时间
         */
        layerAlert: function (icon, text, title, time) {
            time = time || 6000;
            title = title || '提示';
            layer.alert(text, {
                title: title
                , icon: icon
                , time: time
                , resize: false
                , zIndex: layer.zIndex
                , anim: Math.ceil(Math.random() * 6)
            })
        },
        layerAfterDo: function (icon, text, title, time, done) {
            time = time || 6000;
            title = title || '提示';
            layer.open({
                title: title
                , icon: icon
                , content: text
                , time: time
                , resize: false
                , zIndex: layer.zIndex
                , anim: Math.ceil(Math.random() * 6)
                , yes: function (index) {
                    layer.close(index);
                    done && done();
                }
            });
        },
        //小的信息框
        layerMsg: function (icon, text, time, done) {
            time = time || 3000;
            layer.msg(text, {
                icon: icon
                , time: time
                , zIndex: layer.zIndex
            }, function (index) {
                done && done();
            });
        },

        //询问框
        layerConfirm: function (text, btny, btnn, yCallback) {
            btny = btny || '确定';
            btnn = btnn || '取消';
            layer.confirm(text, {
                icon: 3
                , btn: [btny, btnn] //按钮
                , zIndex: layer.zIndex
            }, function () {
                yCallback && yCallback();
            }, function (index) {
                layer.close(index);
            });
        },

        layerIframe: function (areaW, areaH, url, title, closeBtn) {
            layer.open({
                title: title,
                type: 2,
                area: [areaW + "px", areaH + "px"],
                content: [url, "no"],
                shadeClose: true,
                closeBtn: closeBtn,
                fixed: true, //不固定
                anim: 1
            });
        },

        layerIframeTitle: function (areaW, areaH, url, title) {
            layer.open({
                title: title,
                type: 2,
                area: [areaW + "px", areaH + "px"],
                content: [url],
                shadeClose: true,
                fixed: true, //不固定
                maxmin: true,
                anim: 1,
                end: function (index) {
                    if (sessionStorage.getItem('editFlag') === 'true') {
                        sessionStorage.setItem('editFlag', 'false');
                        window.location.reload();
                    }
                }
            });
        },

        layerIframeNoReload: function (areaW, areaH, url, title) {
            layer.open({
                title: title,
                type: 2,
                area: [areaW + "px", areaH + "px"],
                content: [url],
                maxmin: true,
                shadeClose: true,
                fixed: true, //不固定
                anim: 1,
            });
        },

        layerIframeTitle2: function (areaW, areaH, url, title) {
            layer.open({
                title: title,
                type: 2,
                area: [areaW + "px", areaH + "px"],
                content: [url],
                shadeClose: true,
                fixed: true, //不固定
                maxmin: true,
                anim: 1,
                end: function (index) {
                    if ($('#doRefresh').length)
                        $('#doRefresh').trigger('click');
                    else
                        window.location.reload();
                }
            });
        },
        //弹出一个已经设置好的DIV
        layerDiv: function ($elem, areaW, areaH, title) {
            layer.open({
                title: title,
                type: 1,
                //zIndex: layer.zIndex,
                offset: '70px',
                //area: [areaW + 'px', areaH + 'px'],
                content: $elem,
                success: function (layero) {
                    obj.disBlockElem($('.layui-layer .layui-layer-content').children('div'));
                },
                cancel: function (index, layero) {
                    obj.disNoneElem($('.layui-layer .layui-layer-content').children('div'));
                }
            });
        },
        //设置本地存储
        setSessionStorage: function (objData, name) {
            var dateDataStr = JSON.stringify(objData);
            sessionStorage.setItem(name, dateDataStr);
        },
        //获取本地存储
        getSessionStorage: function (name) {
            var data = sessionStorage.getItem(name);//取值
            return JSON.parse(data);//返回JSON对象
        },
        //退出系统
        signOut: function (title, text, url, rturl, type, dataType, data, callback) {
            layer.confirm(text, {
                title: title,
                resize: false,
                btn: ['确定退出', '容我想想'],
                btnAlign: 'c',
                icon: 3
            }, function () {
                $.ajax({
                    url: url,
                    type: type,
                    dataType: dataType,
                    data: data,
                    success: function (res) {
                        res.code == 1200 ? location.href = rturl : obj.layerAlert(1, res.msg, '提示');
                    },
                    error: function () {
                        obj.layerAlert(2, '操作失败！', '提示');
                    }
                });
            });
        },
        /**点击刷新验证码**/
        refreshVerify: function (verify_img) {
            var ts = Date.parse(new Date()) / 1000;
            verify_img.src = "/captcha?id=" + ts;
        },

        //判读变量是否为函数
        isExitsFunction: function (funcName) {
            try {
                if (typeof(eval(funcName)) == "function") {
                    return true;
                }
            } catch (e) {
                console.log('isExitsFunction:错误');
            }
            return false;
        },
        //判断变量是否存在
        isExitsVariable: function (variableName) {
            try {
                if (typeof(variableName) == "undefined") {
                    //alert("value is undefined");
                    return false;
                } else {
                    //alert("value is true");
                    return true;
                }
            } catch (e) {
            }
            return false;
        },
        //导航下标
        adjustHeader: function (index) {
            var $navs = $('#nav li a');
            $navs.eq(index).addClass('curIndex');
        },

        /**编辑文章函数**/
        //检查字数
        surveyWorldNum: function () {
            var $titleNum = $('#title-word-num')
                , $titleText = $('#title-text')
                , titleMaxLength = $titleNum.text()//标题最多的字数
                , hasLength = $titleText.val().length
                , restLength = titleMaxLength - hasLength;
            $titleNum.text(restLength);
            $titleText.on("input propertychange", function () {
                var $this = $(this)
                hasLength = $this.val().length
                restLength = titleMaxLength - hasLength;
                if (Math.abs(restLength) < 0) {
                    obj.layerAlertE("文章标题字数超出了!");
                } else {
                    $titleNum.text(restLength);
                }
            });
        },

        //获取屏幕宽度
        getWindowWidth: function () {
            return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        },
        //获取屏幕高度
        getWindowHeight: function () {
            return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        },
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

        flowImg: function (elem, scrollElem) {
            flow.lazyimg({
                elem: elem
                , scrollElem: scrollElem
            });
        },
        //获取当前日期
        getNowFormatDate: function () {
            var date = new Date();
            var seperator1 = "-";
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = year + seperator1 + month + seperator1 + strDate;
            return currentdate;
        }
    };
    exports("common", obj);
});
