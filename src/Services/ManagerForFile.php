<?php
/**
 * Created by PhpStorm.
 * User: jesda
 * Date: 11/11/18
 * Time: 12:48
 */

namespace App\Services;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class ManagerForFile
{
    private $public_directory;

    public function __construct($public_directory)
    {
        $this->public_directory = $public_directory;
    }

    public function upload(UploadedFile $file, $targetDirectory){
        $fileName = ($this->generateUniqueFileName().'.'.$file->guessExtension());
        $file->move($this->public_directory.$targetDirectory, $fileName);

        return $fileName;
    }

    public function delete($targetDirectory){
        unlink($this->public_directory.$targetDirectory);
    }

    private function generateUniqueFileName(){
        return md5(uniqid());
    }
}