<?php
namespace Pctco\Data;
use think\facade\Request;
/**
 * 数据
 */
class Form{
   protected $request;
   public function __construct(Request $request){
	   $this->request = $request;
   }
   /**
   * @name FileUpload
   * @describe 文件上传
   * @return Array
   **/
   public function FileUpload(){
      $file = $this->request->file('test');
      $post = input('post.');
      if($file){
         $info = $file->move(ROOT_PATH . 'produce' . DS . $post['path']);
         if($info){
            return json([
               'ext' => $info->getExtension(),
               'path' => $info->getSaveName(),
               'name' => $info->getFilename(),
            ]);
         }else{
            // 上传失败获取错误信息
            return json($file->getError());
         }
      }else {
        // 上传失败获取错误信息
        return json($file->getError());
      }
   }
}
