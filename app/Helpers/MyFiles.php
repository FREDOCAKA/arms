<?php

namespace App\Helpers;
use Slim\Http\Request;
use Slim\Http\Response;

class MyFiles
{

    public $fileName;

    public $full_path;

    /**
     * Upload FIles
     *
     * @param [array] $request
     * @param [type] $directory
     * @param [type] $field
     * @return void
     */
    public function uploadFiles($request,$directory,$field)
    {
       

        $files = $request->getUploadedFiles();

        $newFile = $files[$field];

        if($newFile->getError()===UPLOAD_ERR_OK)
        {
            $this->fileName  = time().$newFile->getClientFilename();

            $newFile->moveTo($directory.$this->fileName);
        }
    
    }
    
    /**
     * File download method
     *
     * @param Response $response
     * @param [string] $router
     * @param [string] $file_name
     * @return void
     */
    public function downloadFile (Response $response,$router, $file_name)
    {
        $file = $_SERVER['DOCUMENT_ROOT'].$router.'storage/docs/'.$file_name;
        
        $response = $response->withHeader('Content-Description','File Transfer')
                                ->withHeader('Content-type','application/octet-stream')
                                ->withHeader('Content-Disposition','attachment;filename="'.basename($file).'"')
                                ->withHeader('Content-Length',filesize($file))
                                ->withHeader('Expires','0')
                                ->withHeader('Cache-Control','private,must-revalidate')
                                ->withHeader('Pragma','public')
                                ->withHeader('Content-Transfer-Encoding','Binary')
                                ->withHeader('Accept-Ranges','bytes');
        
                                  
        readfile($file);

        return $response;
    }

    

    /**
     * Full file path
     *
     * @param [string] $file_name
     * @param [string] $router
     * @return fullPath
     */
    public function filePath($file_name,$router)
    {
       $file_path =  'http://'.$_SERVER['SERVER_NAME'].$router.'storage/docs/'.$file_name;

       return $file_path;
    }


    /**
     * Full file path
     *
     * @param [string] $file_name
     * @param [string] $router
     * @return fullPath
     */
    public function fullPath($file_name,$router)
    {
       $this->full_path =  $_SERVER['DOCUMENT_ROOT'].$router.'storage/docs/'.$file_name;

       return $full_path;
    }
}