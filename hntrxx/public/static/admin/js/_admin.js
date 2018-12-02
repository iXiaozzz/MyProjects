var tab;
layui.use(['layer', 'element', 'util', 'common', 'navbar', 'tab', 'form'], function () {
    var $ = layui.jquery
        , element = layui.element
        , util = layui.util
        , common = layui.common
        , navbar = layui.navbar()
        , form = layui.form
        , tab = layui.tab({
        elem: '.layui-tab-card' //设置选项卡容器
    });
    //iframe自适应
    $(window).on('resize', function () {
        var $content = $('.admin-nav-card .layui-tab-content');
        $content.height($(this).height() - 192);
        $content.find('iframe').each(function () {
            $(this).height($content.height());
        });
        var width = $(".y-role").width();
        $('#gridList,#gbox_gridList,#gview_gridList,#gridPager,.ui-jqgrid-hdiv,#ui-jqgrid-hbox').width(width - 2);
    }).resize();

    //绑定导航数据
    var $menu = $('#menu');

    $menu.find('li.layui-nav-item').each(function () {
        var $this = $(this);
        //绑定一级导航的点击事件
        $this.on('click', function () {
            //获取设置的模块ID
            var id = $this.find('a').data('fid');

            //设置数据源有两个方式。
            //第一：在此页面通过ajax读取设置  举个栗子：
            /*$.getJSON('/api/xxx',{moduleId:id},function(data){
             navbar.set({
             elem: '#side',

             data: data
             });
             navbar.render();
             navbar.on('click(side)', function(data) {
             tab.tabAdd(data.field);
             });
             });*/

            //第二：设置url
            /*navbar.set({
             elem: '#side',
             url: '/api/xxx?moduleId='+id
             });
             navbar.render();
             navbar.on('click(side)', function(data) {
             tab.tabAdd(data.field);
             });*/

            //生成上边导航栏
            $.getJSON('/admin/index/sideMenu', {fid: id}, function (result) {
                if (result.state == 1) {
                    //设置navbar
                    navbar.set({
                        elem: '#admin-navbar-side', //存在navbar数据的容器ID
                        data: result.data
                    });
                    //渲染navbar
                    navbar.render();
                    //添加tips
                    var li = $("#sidebar-side").find("li");
                    var dd = $("#sidebar-side").find("dd");
                    li.hover(function () {
                        var minitips = $("#sidebar-side").hasClass("sidebar-mini");
                        if (minitips) {
                            var title = $(this).find("a").first().find("cite").text();
                            layer.tips(title, this, {
                                tips: 2,
                                time: 500
                            });
                        }
                    });
                    dd.hover(function () {
                        var minitips = $("#sidebar-side").hasClass("sidebar-mini");
                        if (minitips) {
                            var title = $(this).find("a").find("cite").text();
                            layer.tips(title, this, {
                                tips: 2,
                                time: 1500
                            });
                        }
                    });
                    //监听点击事件
                    navbar.on('click(side)', function (data) {
                        tab.tabAdd(data.field);
                    });
                } else {
                    common.layerAlertE(result.message, '错误');
                }
            });
        });

    });
    //个人的设置
    $('.frame_Add').on('click', function () {
        var $this = $(this);
        tab.tabAdd({
            href: $this.data('url')
            , icon: $this.data('icon')
            , title: $this.attr('title')
        });
    });
    //$('#test').hover(function(){
    //    var that = $(this);
    //    layer.tips('test', that); //在元素的事件回调体中，follow直接赋予this即可
    //},function(){
    //    layer.close(layer.index);
    //});
    //$('#test').on('click',function(){
    //
    //});
    //模拟点击内容管理
    $('#menu').find('a[data-fid=5]').click();

    //固定Bar
    util.fixbar({
        bar1: true
        , click: function (type) {
            if (type === 'bar1') {
                location.href = '';
            }
        }
    });

    //全屏
    // var controllScreen = {
        // isFullScreen: false,
        // fullscreen: function() {
        //     elem = document.body;
        //     if (elem.webkitRequestFullScreen) {
        //         elem.webkitRequestFullScreen();
        //     } else if (elem.mozRequestFullScreen) {
        //         elem.mozRequestFullScreen();
        //     } else if (elem.requestFullScreen) {
        //         elem.requestFullscreen();
        //     } else {
        //         //浏览器不支持全屏API或已被禁用
        //     }
        // },
        // exitFullscreen: function() {
        //     var elem = document;
        //     if (elem.webkitCancelFullScreen) {
        //         elem.webkitCancelFullScreen();
        //     } else if (elem.mozCancelFullScreen) {
        //         elem.mozCancelFullScreen();
        //     } else if (elem.cancelFullScreen) {
        //         elem.cancelFullScreen();
        //     } else if (elem.exitFullscreen) {
        //         elem.exitFullscreen();
        //     } else {
        //         //浏览器不支持全屏API或已被禁用
        //     }
        // },
        // action: function(elem, ev) {
        //     elem.on(ev, () => {
        //         if (!this.isFullScreen) {
        //             this.fullscreen();
        //             this.isFullScreen = true;
        //         } else {
        //             this.exitFullscreen();
        //             this.isFullScreen = false;
        //         }
        //     });
        // }
    // };
    // controllScreen.action($('#maxScreen'),'click');
    // var isFullScreen = false;
    // $('#maxScreen').on('click', () => {
    //     if (!isFullScreen) {
    //         controllScreen.fullscreen();
    //         isFullScreen = true;
    //     } else {
    //         controllScreen.exitFullscreen();
    //         isFullScreen = false;
    //     }
    // });

    //退出系统
    var adminActive = {
        doLoginOut: function () {
            var url = $(this).data('href');
            var rturl = $(this).data('rturl');
            if (url) {
                if (!rturl) {
                    rturl = 'admin/Login/index';
                }
                common.signOut('确认退出系统？', '请再次确认是否要退出系统！', url, rturl, 'post', 'json', {"request": "exit"});
            }
            else {
                common.layerAlertE('链接错误！', '提示');
            }
        }
    };

    $('.do-admin').on('click', function (event) {
        var type = $(this).data('type');
        adminActive[type] ? adminActive[type].call(this) : '';
        return false;
    });

    //左侧菜单收缩
    var foldNode = $('#sidebar');
    var sidebarNode = $('#sidebar-side');
    var headerNode = $('.header-admin');
    if (foldNode) {
        $(document).on("click", '#sidebar', function () {
            var toType = sidebarNode.hasClass("sidebar-mini") ? "full" : "mini";
            var sideWidth = sidebarNode.width();
            if (sideWidth === 200) {
                $('#admin-body').animate({
                    left: '70px'
                }); //admin-footer
                $('.admin-footer').animate({
                    left: '70px'
                });
                sidebarNode.addClass('sidebar-mini');
                headerNode.addClass('header-mini');
                $('#sidebar').find('i').removeClass('fa-bars').addClass('fa-th-large');
            } else {
                $('#admin-body').animate({
                    left: '200px'
                });
                $('.admin-footer').animate({
                    left: '200px'
                });
                sidebarNode.removeClass('sidebar-mini');
                headerNode.removeClass('header-mini');
                $('#sidebar').find('i').removeClass('fa-th-large').addClass('fa-bars');
            }
        });
    }

    //open-tab
    function opentab(t) {
        $this = $(t);
        var data = {
            field: {
                href: $this.data('href'),
                icon: $this.data('icon'),
                title: $this.data('title')
            }
        };
        tab.tabAdd(data.field);
        layui.stope(e);//阻止冒泡事件
    }
});
