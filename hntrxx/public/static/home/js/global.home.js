    layui.config({
        base: '/static/plus/layui/lay/modules/extendplus/' //自定义layui组件的目录
    }).extend({
        common: 'common',
        // commonHome: 'common.home',
        // validator: 'validator',
        // navbar: 'navbar/navbar',
        // tab: 'navbar/tab',
        // icheck: 'icheck/icheck',
        // browser: 'browser',
        // paging: 'paging',
        // myDate: 'myDate'
    });

layui.use(['common', 'util', 'element', 'mobile'], function () {
        var layer = layui.layer
            , common = layui.common
            , element = layui.element
            , mobile = layui.mobile
            , util = layui.util;
        var winWidth = common.getWindowWidth();
        var setMainHeight = function () {
            var bodyH = $('html').height()
                , winHeight = common.getWindowHeight();
            var device = layui.device();
            if (!device.ios && !device.android && !device.weixin) {
                winHeight = winHeight < 640 ? 640 : winHeight;
            }
            if (bodyH < winHeight + 1) {
                var headerH = $('.header').outerHeight()
                    , footerH = $('.footer').outerHeight()
                    , setHeight = winHeight - headerH - footerH;
                $('#main').css({'min-height': setHeight});
                $('#main>div.layui-row.layui-col-space30').css({'min-height': setHeight});
            }
        };
        setMainHeight();
        //设置导航下标
        var navIndex = parseInt($('#headerNavNum').val());
        $('#nav li').eq(navIndex - 1).addClass('layui-this');

        //设置main的高度
        window.onresize = function () {
            winWidth = common.getWindowWidth();
            setMainHeight();
            isMobile();
        };

        //在移动端可以选择子导航
        isMobile();

        //页面图片懒加载
        // common.flowImg('#main img', 'body');

        

        //底部的分享效果
        $('#share>a').hover(function () {
            var $this = $(this);
            var title = $this.data('title');
            layer.tips(title, $this, {
                tips: [1, '#99CC99']
            });
        }, function () {
            layer.closeAll('tips');
        });


        //固定块
        util.fixbar({
            bar1: true,
            bar2: false,
            // bgcolor: '#FF99FF',
            click: function (type) {
                switch (type) {
                    case 'bar1':
                        winWidth < 769 ? $('#menu-toggle').trigger('click') : window.location.reload();
                        break;
                    case 'bar2':
                        alert('bar2');
                        break;
                }
            }
        });

        function isMobile() {
            if (winWidth < 769) {
                $(".header .nav-item").each(function () {
                    var $this = $(this);
                    $this.attr("href", "javascript:;");
                });

                var oArticleImgs = $('.article-content').find('img');
                oArticleImgs.removeAttr('width');
                oArticleImgs.removeAttr('height');

                //如果是移动端，改变导航栏
                var navLeft = $('#nav').html();
                $('#menu-toggle').on('click', function () {
                    mobile.layer.open({
                        type: 1
                        ,
                        content: '<div class="layui-side my-bg-blue"><div class="layui-side-scroll" ><ul class="layui-nav layui-nav-tree my-bg-blue" lay-shrink="all" lay-filter="nav-left">' +
                        navLeft + '</ul></div></div>'
                        ,
                        anim: 'right'
                        ,
                        style: 'position:fixed; left:0; top:0; width:200px; height:100%; border: none; -webkit-animation-duration: .5s; animation-duration: .5s;'
                        ,
                        success: function (elem) {
                            element.render('nav', 'nav-left');
                        }
                    });
                });
            }
        }
    }
);
