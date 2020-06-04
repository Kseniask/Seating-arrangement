<?php

include_once("inc/config.inc.php");

class FileService implements FileServiceInterface {

    public static $_fileName = "data/manifest.data";
    public static $_filecontent;
    static function read() : string {
        //Clear the file cache
        clearstatcache();
    
        try {
            $filehandle = fopen(self::$_fileName,'r');
            $fileContents = fread($filehandle, filesize(self::$_fileName));
             if(empty($fileContents)){
                 throw new Exception("The file is not found");
             }
            fclose($filehandle);

        } catch (Exception $ex) {
            
            $ex->getMessage(); 
            error_log($ex->getMessage(),1);
        }
        //return the file contents
        return $fileContents;
    }
    //Write
    static function write(string $contents) {
        clearstatcache(); 
        try {
            $filehandle = fopen(self::$_fileName, 'w+');
            fwrite($filehandle, $contents);

                if(empty($filehandle)){
                    throw new Exception("File is not found");
                }
        }catch (Exception $ex) {
            $ex->getMessage();
            error_log($ex->getMessage(),1);
        }
        fclose($filehandle);
        // echo"File is Written";
    }

}