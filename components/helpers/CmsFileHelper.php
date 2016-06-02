<?php
namespace app\components\helpers;

use yii\helpers\FileHelper;

/**
 * FileHelper File helper methods
 *
 * @author ptu
 */
class CmsFileHelper extends FileHelper {
    
    /**
     * Find all directories in a folder
     * @param string $dir directory path
     * 
     * @return type
     * @throws InvalidParamException
     */
    public static function findDirs($dir)
    {
        if (!is_dir($dir)) {
            throw new InvalidParamException("The dir argument must be a directory: $dir");
        }
        $dir = rtrim($dir, DIRECTORY_SEPARATOR);
        
        $list = [];
        $handle = opendir($dir);
        if ($handle === false) {
            throw new InvalidParamException("Unable to open directory: $dir");
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            
            if(is_dir($path)){
                $list[]=$file;
            }
        }
        closedir($handle);

        return $list;
    }
}
