<?php
namespace Lichv\UEditor;

use OSS\OssClient;
use OSS\Core\OssException;

class ListsAlioss
{
	public function __construct($allowFiles, $listSize, $path, $request)
	{
		$this->allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);
		$this->listSize = $listSize;
		$this->path = $path;
		$this->request = $request;
	}

	public function getList()
	{

		$size = $this->request->get('size', $this->listSize);
		$start = $this->request->get('start', 0);
		$end = $start + $size;
		/* 获取文件列表 */
		$path = public_path()  .'/'. ltrim($this->path,'/');

		$files = $this->getfiles($path, $this->allowFiles);
		if (!count($files)) {
			return [
			"state" => "no match file",
			"list" => array(),
			"start" => $start,
			"total" => count($files)
			];
		}

		/* 获取指定范围的列表 */
		$len = count($files);
		for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
			$list[] = $files[$i];
		}


		/* 返回数据 */
		$result = [
		"state" => "SUCCESS",
		"list" => $list,
		"start" => $start,
		"total" => count($files)
		];

		return $result;
	}
    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    protected function  getfiles($path, $allowFiles, &$files = array()){

    	$list = [];
		$ossClient = new OssClient(config('UEditorUpload.core.alioss.appId'), config('UEditorUpload.core.alioss.appKey'), config('UEditorUpload.core.alioss.host'));
		$year = date('Y',time());
		$month = date('m',time());
		$result = $ossClient->listObjects(config('UEditorUpload.core.alioss.bucket'),['prefix'=>'uploads/'.$year.'/'.$month,'delimiter'=>'','marker'=>'','max-keys'=>500]);
		$list1 = $result->getObjectList();
		$imghost = empty(config('UEditorUpload.core.alioss.imghost'))?config('UEditorUpload.core.alioss.host'):config('UEditorUpload.core.alioss.imghost');
		foreach ($list1 as $key => $value) {
			$temp = [];
			$temp['url'] = 'http://'.config('UEditorUpload.core.alioss.bucket').'.'.$imghost.'/'.$value->getKey();
			$temp['mtime'] = strtotime($value->getLastModified());
			$list[] = $temp;
		}
		return $list;
    }

}
