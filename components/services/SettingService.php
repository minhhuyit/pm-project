<?php

namespace app\components\services;

use app\components\BaseComponent;
use Yii;
use app\components\OptionName;

/**
 * SettingService define functions work with cms settings
 *
 * @author ptu
 */
class SettingService extends BaseComponent
{

    /**
     *
     * @return string front page display type, page or posts
     */
    public function getFrontPageDisplayType()
    {
        return Yii::$app->optionService->getOption(OptionName::FRONT_PAGE_DISPLAY);
    }

    /**
     *
     * @return int return id of static page that showed on front
     */
    public function getPageOnFront()
    {
        return (int)Yii::$app->optionService->getOption(OptionName::PAGE_ON_FRONT);
    }

    /**
     *
     * @return int return id of page that show list posts on front
     */
    public function getPostsOnFront()
    {
        return (int)Yii::$app->optionService->getOption(OptionName::POSTS_ON_FRONT);
    }

    /**
     *
     * @return int return number of posts will be showed on page
     */
    public function getNumPostsShow()
    {
        return (int)Yii::$app->optionService->getOption(OptionName::NUM_POSTS_SHOW);
    }

    /**
     * @return string title of main
     */
    public function getSiteTitle()
    {
        return Yii::$app->optionService->getOption(OptionName::SITE_TITLE);
    }

    /**
     * @return string date format
     */
    public function getDateFormat()
    {
        return Yii::$app->optionService->getOption(OptionName::DATE_FORMAT);
    }

    /**
     * @return string time format
     */
    public function getTimeFormat()
    {
        return Yii::$app->optionService->getOption(OptionName::TIME_FORMAT);
    }

    /**
     * @return string language
     */
    public function getLanguage()
    {
        return Yii::$app->optionService->getOption(OptionName::LANGUAGE);
    }

    /**
     * @return string Permalink
     */
    public function getPermalink()
    {
        $r = Yii::$app->optionService->getOption(OptionName::POST_PERMALINK);
        return $r;
    }

    /**
     * 
     * @param array $datas keys and values of settins 
     */
    public function saveSettings($datas)
    {
        foreach($datas as $key=>$value){
            Yii::$app->optionService->setOption($key, $value);
        }
    }
}
