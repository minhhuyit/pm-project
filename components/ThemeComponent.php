<?php

namespace app\components;

use app\components\helpers\CmsFileHelper;

/**
 * ThemeComponent
 *
 * @author ptu
 */
class ThemeComponent extends BaseComponent {
    public function getActiveThemeName()
    {
        $key='cms_active_theme_name';
        return \Yii::$app->optionService->getOption($key);
    }
    
    /**
     * 
     * @param string $theme Theme name
     */
    public function setActiveThemeName($theme)
    {
        $key='cms_active_theme_name';
        \Yii::$app->optionService->setOption($key, $theme);
    }
    
    /**
     * Get all installed themes in the system
     * @return array array of themes with meta datas
     */
    public function getAllAvailableThemes()
    {
        $dir=  \Yii::getAlias('@themes');
        $themeDirs= CmsFileHelper::findDirs($dir);
        $themes=[];
        $activeTheme=$this->getActiveThemeName();
        
        foreach($themeDirs as $themeDir){
            if($this->checkIfValidTheme($themeDir)){
                $descriptionFilePath=$dir . DIRECTORY_SEPARATOR . $themeDir . DIRECTORY_SEPARATOR . 'description.php';
                $screenshotFilePath=$dir . DIRECTORY_SEPARATOR . $themeDir . DIRECTORY_SEPARATOR . 'screenshot.png';

                $themeDatas=  require_once ($descriptionFilePath);
                $themeDatas['themeName']=$themeDir;
                $themeDatas['themePath']=$dir . DIRECTORY_SEPARATOR . $themeDir;
                $themeDatas['screenshot']=$screenshotFilePath;
                $themeDatas['isActive']=$activeTheme===$themeDatas['themeName'];
                
                $themes[]=$themeDatas;
            }            
        }
        
        return $themes;
    }

    /**
     * Load theme.
     * After the theme be loaded, app will has new component call loadedTheme, this is object of class Theme of loaded theme
     *
     * @param string $themeName theme's name to load, if empty then load actived theme
     */
    public function loadTheme($themeName='')
    {
        if(!$themeName){
            $themeName=$this->getActiveThemeName();
        }

        if($themeName && $this->checkIfValidTheme($themeName)){
            \Yii::setAlias('@theme', "@themes/$themeName");

            //attach loaded theme to app's components
            \Yii::$app->setComponents([
                'loadedTheme'=>[
                    'class'=>'theme\Theme'
                ]
            ]);

            //call this to init loaded theme
            \Yii::$app->loadedTheme;
        }
    }

    /**
     * Check if provided themeName is a valid theme struct
     *
     * @param $themeName theme's name
     * @return bool
     */
    private function checkIfValidTheme($themeName)
    {
        $dir=\Yii::getAlias('@themes');
        $themeClassFilePath=$dir . DIRECTORY_SEPARATOR . $themeName . DIRECTORY_SEPARATOR . 'Theme.php';
        $descriptionFilePath=$dir . DIRECTORY_SEPARATOR . $themeName . DIRECTORY_SEPARATOR . 'description.php';
        $screenshotFilePath=$dir . DIRECTORY_SEPARATOR . $themeName . DIRECTORY_SEPARATOR . 'screenshot.png';

        return is_file($themeClassFilePath) && is_file($descriptionFilePath) && is_file($screenshotFilePath);
    }
}
