// 对Date的扩展，将 Date 转化为指定格式的String
// 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，
// 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)
// 例子：
// (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423
// (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18
Date.prototype.Format = function (fmt) { //author: meizz
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
};

layui.define(['laydate', 'common'], function (exports) {
    var laydate = layui.laydate
        , common = layui.common;
    var obj = {
        initDate: function ($dateS, $dateE, timeS, timeE) {//初始化日期 将日期设置为今天和明天
            if (timeS == null)
                timeS = 0;
            else
                timeS = obj.dateToUnixTime(timeS);
            if (timeE == null)
                timeE = '+1';
            else
                timeE = obj.dateToUnixTime(timeE);
            $dateS.val(laydate.now(timeS));
            $dateE.val(laydate.now(timeE));
        },
        start: {
            min: laydate.now()
            , max: '2099-12-31 23:59:59'
            , istoday: true
            , isclear: false //是否显示清空
            , issure: false //是否显示确认
            , festival: true
            //, choose: function (datas) {
            //    obj.end.min = datas; //开始日选好后，重置结束日的最小日期
            //    obj.end.start = datas; //将结束日的初始值设定为开始日
            //}
        },
        end: {
            min: laydate.now(+1)
            , max: '2099-12-31 23:59:59'
            , istoday: false
            , isclear: false //是否显示清空
            , issure: false //是否显示确认
            , festival: true
            //, choose: function (datas) {
            //    obj.start.max = datas; //结束日选好后，重置开始日的最大日期
            //}
        },
        chooseDate: function ($dateS, $dateE, callback1, callback2) {
            $dateS.val(laydate.now()).on('click', function () {
                obj.start.elem = this;
                if (common.isExitsFunction(callback1) && common.isExitsVariable(callback1)) {
                    obj.start.choose = function (datas) {
                        callback1();
                        //obj.start.max = datas; //结束日选好后，重置开始日的最大日期
                        obj.end.start = datas; //将结束日的初始值设定为开始日
                    }
                }
                laydate(obj.start);
            });
            $dateE.val(laydate.now(+1)).on('click', function () {
                obj.end.elem = this;
                if (common.isExitsFunction(callback2) && common.isExitsVariable(callback2)) {
                    obj.end.choose = function (datas) {
                        callback2();
                        obj.start.max = datas; //结束日选好后，重置开始日的最大日期
                    };
                }
                laydate(obj.end);
            });
        },

        splitDate: function (dateStr) {
            return dateStr.split('-');
        },
        //获取下一天的日期
        getNextDay: function (d) {
            d = new Date(d);
            d = +d + 1000 * 60 * 60 * 24;
            d = new Date(d);
            var nextd = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
            return new Date(nextd).Format("yyyy-MM-dd");
        },
        //计算两个日期格式的差
        //日期格式为 2017-03-29
        countDValue: function (date1, date2) {
            return parseInt((new Date(date1) - new Date(date2)) / 1000 / 60 / 60 / 24);
        },
        //时间格式2014-02-02 14:10:00改成时间戳
        StrToUnixTime: function (str_time) {
            var new_str = str_time.replace(/:/g, "-");
            new_str = new_str.replace(/ /g, "-");
            var arr = new_str.split("-");
            var datum = new Date(Date.UTC(arr[0], arr[1] - 1, arr[2], arr[3] - 8, arr[4], arr[5]));
            return datum.getTime() / 1000;
        },
        //时间格式2014-02-02改成时间戳
        dateToUnixTime: function (str_time) {
            var new_str = str_time.replace(/:/g, "-");
            new_str = new_str.replace(/ /g, "-");
            var arr = new_str.split("-");
            var datum = new Date(arr[0], arr[1] - 1, arr[2]);
            return datum.getTime();
        },
        checkTime: function (i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        },
        //当时间+N分钟  second/秒
        ChangeTimeStr: function (second) {
            var today = new Date();//你已知的时间
            var today_s = today.getTime();//转化为时间戳毫秒数
            var today_change = new Date();//定义一个新时间
            today_change.setTime(today_s + 1000 * second);//设置新时间比旧时间多一分钟
            var Y = today_change.getFullYear();
            var m = today_change.getMonth() + 1;//获取当前月份的日期
            var d = today_change.getDate();
            m = obj.checkTime(m);
            d = obj.checkTime(d)
            var H = today_change.getHours();
            var i = today_change.getMinutes();
            var s = today_change.getSeconds();// 在小于10的数字钱前加一个‘0’
            i = obj.checkTime(i);
            s = obj.checkTime(s);
            return Y + "-" + m + "-" + d + " " + H + ":" + i + ":" + s;
        },
    };
    exports("myDate", obj);
});