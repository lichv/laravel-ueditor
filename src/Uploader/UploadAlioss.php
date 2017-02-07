<?php
namespace Lichv\UEditor\Uploader;

use OSS\OssClient;
use OSS\Core\OssException;

/**
 *
 *
 * trait UploadAlioss
 *
 * 阿里OSS 上传 类
 *
 * @package Lichv\UEditor\Uploader
 */
trait UploadAlioss
{
    /**
     * 获取文件路径
     * @return string
     */

    public function UploadAlioss($key, $content){
        $ossClient = new OssClient(config('UEditorUpload.core.alioss.appId'), config('UEditorUpload.core.alioss.appKey'), config('UEditorUpload.core.alioss.host'));
        $filename = 'uploads/'.date("Y/m/d/",time()).$key;
        $result =$ossClient->uploadFile(config('UEditorUpload.core.alioss.bucket'),$filename,$content);
        $host = config('UEditorUpload.core.alioss.host');
        // $imghost = empty(config('UEditorUpload.core.alioss.imghost'))?$host:config('UEditorUpload.core.alioss.imghost');
        // if (!in_array($this->fileType, [".png", ".jpg", ".jpeg", ".gif", ".bmp"]) ){
            $this->fullName = $url = '//'.config('UEditorUpload.core.alioss.bucket').'.'.$host.'/'.$filename;   
        // }else{
            // $this->fullName = $url = 'http://'.config('UEditorUpload.core.alioss.bucket').'.'.$imghost.'/'.$filename;
        // }
        $this->stateInfo = $this->stateMap[0];
        return true;
    }
}