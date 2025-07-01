<?php

namespace App\CoreFacturalo\Helpers\Storage;

use Illuminate\Support\Facades\Storage;

trait StorageDocument
{
    protected $_folder;
    protected $_filename;

    public function uploadStorage($filename, $file_content, $file_type, $root = null)
    {
        $this->setData($filename, $file_type, $root);
        Storage::disk('tenant')->put($this->_folder.DIRECTORY_SEPARATOR.$this->_filename, $file_content);
    }

    public function downloadStorage($filename, $file_type, $root = null)
    {
        $this->setData($filename, $file_type, $root);

        return Storage::disk('tenant')->download($this->_folder.DIRECTORY_SEPARATOR.$this->_filename);
    }

    public function getStorage($filename, $file_type, $root = null)
    {
        $this->setData($filename, $file_type, $root);
        return Storage::disk('tenant')->get($this->_folder.DIRECTORY_SEPARATOR.$this->_filename);
    }

    public function existsFile($filename, $file_type, $root = null){
        $this->setData($filename, $file_type, $root);
        return Storage::disk('tenant')->exists($this->_folder.DIRECTORY_SEPARATOR.$this->_filename);
    }


    public function getXmlFromCdr( $filename,  $root = null ){
        $this->setData($filename, 'cdr' , $root);

        $exists = Storage::disk('tenant')->exists($this->_folder.DIRECTORY_SEPARATOR.$this->_filename);
        if( !$exists )return false;


        $storagePath = Storage::disk('tenant')->getDriver()->getAdapter()->getPathPrefix();
        $fullFileName = $this->_folder.DIRECTORY_SEPARATOR.$this->_filename;
        $fileNameWithPath = "{$storagePath}/{$fullFileName}";

        $zip = new \ZipArchive();
        if( $zip->open( $fileNameWithPath ) ){
            $xmlContent = $zip->getFromName('R-'.$filename.'.xml');
            $zip->close();

            $simpleXmlObject = new \SimpleXMLElement($xmlContent);

            $cbcNotes = $simpleXmlObject->children('cbc',true)->Note;


            $cacNameSpaces = $simpleXmlObject->children('cac',true);
            $cacResponse = $cacNameSpaces->DocumentResponse->Response;
            $cbcNodes = $cacResponse->children('cbc',true);

            $responseCode = (int)$cbcNodes->ResponseCode;
            $responseDescription = (string)$cbcNodes->Description;

            return [
              'code' => $responseCode,
              'description' => $responseDescription,
              'notes' => (array)$cbcNotes
            ];
        }

    }

    public function getXmlContentFromCdr( $filename,  $root = null ){
        $this->setData($filename, 'cdr' , $root);

        $exists = Storage::disk('tenant')->exists($this->_folder.DIRECTORY_SEPARATOR.$this->_filename);
        if( !$exists )return false;


        $storagePath = Storage::disk('tenant')->getDriver()->getAdapter()->getPathPrefix();
        $fullFileName = $this->_folder.DIRECTORY_SEPARATOR.$this->_filename;
        $fileNameWithPath = "{$storagePath}/{$fullFileName}";

        $zip = new \ZipArchive();
        if( $zip->open( $fileNameWithPath ) ){
            $xmlContent = $zip->getFromName('R-'.$filename.'.xml');
            $zip->close();

            return $xmlContent;
        }

    }


    private function setData($filename, $file_type, $root)
    {
        $extension = 'xml';
        switch ($file_type) {
            case 'unsigned':
                break;
            case 'signed':
                break;
            case 'pdf':
                $extension = 'pdf';
                break;
            case 'cdr':
                $filename = 'R-'.$filename;
                $extension = 'zip';
                break;
            case 'ot':
                $extension = 'pdf';
                break;
        }
        $this->_filename = $filename.'.'.$extension;
        $this->_folder = ($root)?$root.DIRECTORY_SEPARATOR.$file_type:$file_type;
    }
}
