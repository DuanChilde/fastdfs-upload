<?php
/**
 * Created by IntelliJ IDEA.
 * User: duanwei
 * Date: 2017/10/23
 * Time: 下午6:17
 */


class FileUpload{

    /**
     *上传附件
     * @return array
     */
    public function uploadAttach()
    {
        if(!$_FILES || false == isset($_FILES["upFile"]))
        {
            throw new Exception("upFile is not set",10100);
        }

        $file = $_FILES["upFile"];
        if (false == isset($file['tmp_name']) || false == is_file($file['tmp_name']))
        {
            throw new Exception("tmp_name is not file",10101);
        }
        if (0 == filesize($file['tmp_name']))
        {
            throw new UploadException("tmp_name filesize is 0",10102);
        }
        $curlFile = new CurlFile($file['tmp_name'], $file['type'], $file['name']);
        $fileSuffix = $this->getSuffix($curlFile->getPostFilename());

        $ret = [];
        $ret['file'] = $file;
        $ret['fileId'] = $this->uploadToFastdfs($curlFile, $fileSuffix);
        return $ret;
    }

    /**
     * 获取文件后缀
     * @param $fileName
     * @return string
     */
    public function getSuffix($fileName)
    {
        preg_match('/\.(\w+)?$/', $fileName, $matchs);
        return isset($matchs[1])?$matchs[1]:'';
    }

    /**
     * 上传到fastdfs
     * @param CurlFile $file
     * @param $fileSuffix
     * @return mixed
     */
    public function uploadToFastdfs(CurlFile $file, $fileSuffix)
    {
        $fdfs = new FastDFS();
        $fdfs->tracker_get_connection();
        $fileId = $fdfs->storage_upload_by_filebuff1(file_get_contents($file->getFilename()), $fileSuffix);
        $fdfs->tracker_close_all_connections();
        return $fileId;
    }

}