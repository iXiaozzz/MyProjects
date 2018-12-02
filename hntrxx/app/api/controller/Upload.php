<?php

namespace app\api\controller;

use app\admin\controller\AdminBase;
use think\Config;
use think\Db;
use think\Image;
use think\Request;

class Upload extends AdminBase
{
    //新闻封面图片
    public function uploadFileNews(Request $request)
    {
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $prePath = config::get('upload_file_path') . config::get('upload_file_news');
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            $image = Image::open($file);
            $imageType = $this->turnImageType($image->type());
            $imageName = time();
            $yuanTuPath = './upload/company/img_news/yuantu/' . 'yuantu' . $imageName . '.' . $imageType;
            $image->save($yuanTuPath, $imageType, 80, true);
            $filePath = $this->accordSizeThumbImage($file, $prePath, config::get('image_news_width'));

            if ($filePath) {
                return respond(0, '上传图片成功!', ['src' => $filePath, 'yuantu_path' => $yuanTuPath]);
            } else {
                return respond(1, '上传图片失败!', '');
            }
        }
    }

    //上传资质文件
    public function uploadFileZizhi(Request $request)
    {
        $file = $request->file('file');
        if (empty($file) && !isset($file)) {
            return respond(1, '请上传图片', '');
        }
        $prePath = config::get('upload_file_path') . config::get('upload_file_zizhi');
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            //大图
            $bigPath = $prePath . 'big/';
            $fileInfo = $this->articleBigFile($file, $bigPath);
            //小图
//            $thumbImageWidth = config::get('image_zhengshu_thumb_width');
            $thumbPath = $prePath . 'thumb/';
            $thumbInfo = $this->articleThumbFile($file, $thumbPath);
            if ($fileInfo && $thumbInfo) {
                return respond(0, '上传图片成功!', [
                    'src' => substr($fileInfo['finalPath'], 1)
                    , 'src_thumb' => substr($thumbInfo['finalPath'], 1)
                    , 'bigWidth' => $fileInfo['imgWidth']
                    , 'bigHeight' => $fileInfo['imgHeight']
                    , 'imgFlag' => $fileInfo['imgFlag']
                ]);
            } else {
                return respond(1, '上传图片失败!', ['src' => '']);
            }
        }
    }

    //上传荣誉文件
    public function uploadFileRongYu(Request $request)
    {
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $prePath = config::get('upload_file_path') . config::get('upload_file_rongyu');
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            //大图
            $bigPath = $prePath . 'big/';
            $fileInfo = $this->articleBigFile($file, $bigPath);
            //小图
//            $thumbImageWidth = config::get('image_zhengshu_thumb_width');
            $thumbPath = $prePath . 'thumb/';
            $thumbInfo = $this->articleThumbFile($file, $thumbPath);
            if ($fileInfo && $thumbInfo) {
                return respond(0, '上传图片成功!', [
                    'src' => substr($fileInfo['finalPath'], 1)
                    , 'src_thumb' => substr($thumbInfo['finalPath'], 1)
                    , 'bigWidth' => $fileInfo['imgWidth']
                    , 'bigHeight' => $fileInfo['imgHeight']
                    , 'imgFlag' => $fileInfo['imgFlag']
                ]);
            } else {
                return respond(1, '上传图片失败!', ['src' => '']);
            }
        }
    }
//    public function uploadFileRongYu(Request $request)
//    {
//        $file = $request->file('file');
//        if (empty($file)) {
//            return respond(1, '请选择文件!', '');
//        }
//        $prePath = config::get('upload_file_path') . config::get('upload_file_rongyu');
//        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
//        if (!$info) {
//            return respond(1, $file->getError());
//        } else {
//            $bigImageWidth = config::get('image_zhengshu_width');
//            $bigPath = $prePath . 'big/';
////            return respond(0,$bigImageWidth,'');
//            //大图的路径
//            $fileInfo = $this->accordSizeThumbImage($file, $bigPath, $bigImageWidth);
//            //小图的路径
//            $thumbImageWidth = config::get('image_zhengshu_thumb_width');
//            $bigPath = $prePath . 'thumb/';
//            $thumbFileInfo = $this->accordSizeThumbImage($fileInfo['finalPath'], $bigPath, $thumbImageWidth);
//            if ($fileInfo && $thumbFileInfo) {
//                return respond(0, '上传图片成功!', ['src' => substr($fileInfo['finalPath'], 1)
//                    , 'src_thumb' => substr($thumbFileInfo['finalPath'], 1)]);
//            } else {
//                return respond(1, '上传图片失败!', '');
//            }
//        }
//    }

    //上传产品文件
    public function productionFile(Request $request)
    {
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $prePath = config::get('upload_file_path') . config::get('upload_file_production');
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            $bigImageWidth = config::get('image_production_width');
            //大图的路径
            $filePath = $this->accordSizeThumbImage($file, $prePath, $bigImageWidth);
            if ($filePath) {
                $id = intval($request->param('id'));
                $queryPath = Db::name('production_solution')->field('f_disImg_path path')
                    ->where('f_id', '=', $id)->find()['path'];
                Db::name('production_solution')
                    ->where('f_id', '=', $id)
                    ->update(['f_disImg_path' => $filePath['finalPath']]);
                if ($queryPath) {
                    deleteFile('.' . $queryPath);
                }
                return respond(0, '修改成功!', ['src' => substr($filePath['finalPath'], 1)]);
            } else {
                return respond(1, '修改失败!', '');
            }
        }
    }

    //文章封面图片
    public function articleCoverImg(Request $request)
    {
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $prePath = config::get('upload_file_path') . config::get('upload_file_news');
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            $bigImageWidth = config::get('image_news_width');
            //大图的路径
            $filePath = $this->accordSizeThumbImage($file, $prePath, $bigImageWidth);
            if ($filePath) {
                $id = intval($request->param('id'));
                $queryPath = Db::name('article')->field('f_cover_img_path path')
                    ->where('f_article_id', '=', $id)->find()['path'];
                Db::name('article')
                    ->where('f_article_id', '=', $id)
                    ->update(['f_cover_img_path' => $filePath['finalPath']]);
                deleteFile('.' . $queryPath);
                return respond(0, '修改成功!', ['src' => substr($filePath['finalPath'], 1)]);
            } else {
                return respond(1, '修改失败!', '');
            }
        }
    }


    public function bannerZiZhi(Request $request)
    {
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            $bannerWith = config::get('img_banner_width');
            $bannerHeight = config::get('img_banner_height');
            $image = Image::open($file);
            $imageType = $this->turnImageType($image->type());
            $image->thumb($bannerWith, $bannerHeight, Image::THUMB_CENTER);
            try {
                $path = config::get('banner_path') . 'zizhi.' . $imageType;
                deleteFile($path);
                $image->save($path, $imageType, 80, true);
                return respond(0, '修改成功!', ['src' => substr($path, 1)]);
            } catch (\ErrorException $e) {
                return respond(1, '修改失败!', '');
            }
        }
    }

    public function bannerRongYu(Request $request)
    {
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            $bannerWith = config::get('img_banner_width');
            $bannerHeight = config::get('img_banner_height');

            $image = Image::open($file);
            $imageType = $this->turnImageType($image->type());
            $image->thumb($bannerWith, $bannerHeight, Image::THUMB_CENTER);
            try {
                $path = config::get('banner_path') . 'rongyu.' . $imageType;
                deleteFile($path);
                $image->save($path, $imageType, 80, true);
                return respond(0, '修改成功!', ['src' => substr($path, 1)]);
            } catch (\ErrorException $e) {
                return respond(1, '修改失败!', '');
            }
        }
    }

    public function bannerNews(Request $request)
    {
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            $bannerWith = config::get('img_banner_width');
            $bannerHeight = config::get('img_banner_height');

            $image = Image::open($file);
            $imageType = $this->turnImageType($image->type());
            $image->thumb($bannerWith, $bannerHeight, Image::THUMB_CENTER);
            try {
                $path = config::get('banner_path') . 'news.' . $imageType;
                deleteFile($path);
                $image->save($path, $imageType, 80, true);
                return respond(0, '修改成功!', ['src' => substr($path, 1)]);
            } catch (\ErrorException $e) {
                return respond(1, '修改失败!', '');
            }
        }
    }

    public function moduleImg(Request $request)
    {
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            $imgWith = config::get('module_img_width');
            $imgHeight = config::get('module_img_height');
            $image = Image::open($file);
            $imageType = $this->turnImageType($image->type());
            $image->thumb($imgWith, $imgHeight, Image::THUMB_CENTER);
            $name = md5(time());
            try {
                $fid = intval($request->get('id'));
                $oldPath = Db::name('homepage_img')
                    ->field('f_img_path')
                    ->where('f_id', '=', $fid)
                    ->find()['f_img_path'];
                $newPath = config::get('upload_file_home') . $name . '.' . $imageType;
                deleteFile($oldPath);
                $image->save($newPath, $imageType, 80, true);
                Db::name('homepage_img')->where('f_id', '=', $fid)
                    ->update(['f_img_path' => $newPath]);
                return respond(0, '修改成功!', ['src' => $newPath]);
            } catch (\ErrorException $e) {
                return respond(1, '修改失败!', '');
            }
        }
    }

    public function updateBgImg(Request $request){
        $file = $request->file('file');
        if (empty($file)) {
            return respond(1, '请选择文件!', '');
        }
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            $imgWith = config::get('bg_img_width');
            $imgHeight = config::get('bg_img_height');
            $image = Image::open($file);
            $imageType = $this->turnImageType($image->type());
            $image->thumb($imgWith, $imgHeight, Image::THUMB_CENTER);
            $name = 'bg'.md5(time());
            try {
                $fid = intval($request->get('id'));
                $oldPath = Db::name('homepage_img')
                    ->field('f_img_path')
                    ->where('f_id', '=', $fid)
                    ->find()['f_img_path'];
                $newPath = config::get('upload_file_home') . $name . '.' . $imageType;
                deleteFile($oldPath);
                $image->save($newPath, $imageType, 80, true);
                Db::name('homepage_img')->where('f_id', '=', $fid)
                    ->update(['f_img_path' => $newPath]);
                return respond(0, '修改成功!', ['src' => $newPath]);
            } catch (\ErrorException $e) {
                return respond(1, '修改失败!', '');
            }
        }
    }

    public function updateFileZizhi(Request $request)
    {
        $fid = intval($request->param('id'));
        $file = $request->file('file');
        if (empty($file) && !isset($file)) {
            return respond(1, '请上传图片', '');
        }
        $prePath = config::get('upload_file_path') . config::get('upload_file_zizhi');
        $info = $file->validate(['ext' => 'jpg,png,jpeg']);
        if (!$info) {
            return respond(1, $file->getError());
        } else {
            //大图
            $bigPath = $prePath . 'big/';
            $fileInfo = $this->articleBigFile($file, $bigPath);
            //小图
            $thumbPath = $prePath . 'thumb/';
            $thumbInfo = $this->articleThumbFile($file, $thumbPath);
            if ($fileInfo && $thumbInfo) {
                $imgPath = Db::name('file')
                    ->field('f_large_file_path,f_small_file_path')
                    ->where('f_id', '=', $fid)
                    ->find();
                deleteFile($imgPath['f_large_file_path']);
                deleteFile($imgPath['f_small_file_path']);
                return respond(0, '上传图片成功!', [
                    'src' => substr($fileInfo['finalPath'], 1)
                    , 'src_thumb' => substr($thumbInfo['finalPath'], 1)
                    , 'bigWidth' => $fileInfo['imgWidth']
                    , 'bigHeight' => $fileInfo['imgHeight']
                    , 'imgFlag' => $fileInfo['imgFlag']
                ]);
            } else {
                return respond(1, '上传图片失败!', ['src' => '']);
            }
        }

    }

    /**
     * @param $tempPath  打开的文件路径
     * @param $prePath   保存路径的前缀
     * @param $accordWidth  剪裁后的宽度
     * @param $accordHeight 剪裁后的高度
     * @param $imageName  图片名称
     * @return string  返回图片路径
     */
    private function accordSizeThumbImage($tempPath, $prePath, $accordWidth)
    {
        $image = Image::open($tempPath);
        $imgWidth = $image->width();//获取图片的宽度
        $imgHeight = $image->height();//获取图片的高度
        $biLi = $imgHeight / $imgWidth;
        $accordHeight = intval($accordWidth * $biLi);
        $imageType = $this->turnImageType($image->type());
        $imageName = time();
        $finalPath = $prePath . $imageName . '.' . $imageType;
        if ($imgWidth > $accordWidth || $imgHeight > $accordHeight) {
            $image->thumb($accordWidth, $accordHeight, Image::THUMB_CENTER);
        } else {
            $accordWidth = $imgWidth;
            $accordHeight = $imgHeight;
        }
        try {
            $image->save($finalPath, $imageType, 80, true);
            return [
                'finalPath' => $finalPath
                , 'bigHeight' => $accordHeight
                , 'bigWidth' => $accordWidth
            ];
        } catch (\ErrorException $e) {
            return false;
        }
    }

    private function articleBigFile($tempPath, $prePath)
    {
        $image = Image::open($tempPath);
        $imgWidth = $image->width();//获取图片的宽度
        $imgHeight = $image->height();//获取图片的高度
        $biLi = $imgHeight / $imgWidth;
        if ($biLi > 1) {
            $imgFlag = 1;
            $ImageWidth = config::get('image_zhengshu_width2');
//            $ImageHeight = config::get('image_zhengshu_height2');

        } else {
            $imgFlag = 0;
            $ImageWidth = config::get('image_zhengshu_width1');
//            $ImageHeight = config::get('image_zhengshu_height1');
        }
        $ImageHeight = $ImageWidth * $biLi;
        $imageType = $this->turnImageType($image->type());
        $imageName = time();
        $finalPath = $prePath . $imageName . '.' . $imageType;
        $image->thumb($ImageWidth, $ImageHeight, Image::THUMB_CENTER);
        try {
            $image->save($finalPath, $imageType, 80, true);
            return [
                'finalPath' => $finalPath
                , 'imgHeight' => $ImageHeight
                , 'imgWidth' => $ImageWidth
                , 'imgFlag' => $imgFlag
            ];
        } catch (\ErrorException $e) {
            return false;
        }
    }

    private function articleThumbFile($tempPath, $prePath)
    {
        $image = Image::open($tempPath);
        $imgWidth = $image->width();//获取图片的宽度
        $imgHeight = $image->height();//获取图片的高度
        $biLi = $imgHeight / $imgWidth;
        if ($biLi > 1) {
            $imgFlag = 1;
            $ImageWidth = config::get('image_zhengshu_thumb_width2');
            $ImageHeight = config::get('image_zhengshu_thumb_height2');
        } else {
            $imgFlag = 0;
            $ImageWidth = config::get('image_zhengshu_thumb_width1');
            $ImageHeight = config::get('image_zhengshu_thumb_height1');
        }
//        $ImageWidth = $imgWidth;
//        $ImageHeight = $imgHeight;
        $imageType = $this->turnImageType($image->type());
        $imageName = time();
        $finalPath = $prePath . $imageName . '.' . $imageType;
        $image->thumb($ImageWidth, $ImageHeight, Image::THUMB_CENTER);
        try {
            $image->save($finalPath, $imageType, 60, true);
            return [
                'finalPath' => $finalPath
                , 'imgHeight' => $ImageHeight
                , 'imgWidth' => $ImageWidth
                , 'imgFlag' => $imgFlag
            ];
        } catch (\ErrorException $e) {
            return false;
        }
    }

    //将后缀为jpeg的图片转化为jpg
    private function turnImageType($type)
    {
        switch ($type) {
            case 'jpeg':
                return 'jpg';
                break;
            default:
                return $type;
                break;
        }
    }

    //删除图片接口
    public function deleteImg(Request $request)
    {
        $path = './' . $request->post('path');
        $res = deleteFile($path);
        if ($res) {
            return json(['state' => 1, 'message' => '删除成功！']);
        } else {
            return json(['state' => 0, 'message' => '删除失败！']);
        }
    }


}