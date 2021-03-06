<?php


namespace App\Service;


use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{

    private $uploadsPath;

    public function __construct(string $uploadsPath){

        $this->uploadsPath = $uploadsPath;

    }


    public function UploadCityPicture (UploadedFile $uploadedFile) : string
    {
        $destination = $this->uploadsPath . '/cities';

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move(
            $destination,
            $newFilename
        );

        return $newFilename;

    }

}