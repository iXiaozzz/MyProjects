layui.use(['mupload'],function(){
    console.log(layui.mupload);
    layui.mupload({
        //必须，服务器路径
        url:'/admin/ManageHome/uploadFile',
        //必须，传递table的id,请不要传class
        container:'#container',
        //默认"file"，用于服务器获取文件名
        file_name:'file',
        //回调函数
        complete:function(res){
            //res:返回所有文件的上传结果
        }
    });
});