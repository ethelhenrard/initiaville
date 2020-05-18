<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileUploader
{
    private $targetDirectory;


    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;

    }

    public function upload(UploadedFile $file)
    {
        //on recupere le nom qu'il y a dans le fichier
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        //on rajoute un identifiant unique + extension
        $fileName = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();

        //possible de modifier le target directory de service.yaml directement (upload directory)
        $destination = $this->targetDirectory . "/projects";

        try {
            //on essaie de mettre dans le fichier upload > try/catch$
            //on le deplace vers target Directory
            $file->move($destination, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}