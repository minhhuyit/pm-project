<?php
/**
 * Created by Comit.
 * User: Tuan
 * Date: 10/03/2016
 * Time: 1:37 CH
 */
namespace app\components;


class MultilevelDropDownComponent extends BaseComponent{
    /*Example of 2 model is use
        * CREATE TABLE `term` (
          `id` bigint(20) UNSIGNED NOT NULL,
          `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
          `slug` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE `term_taxonomy` (
          `id` bigint(20) UNSIGNED NOT NULL,
          `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
          `taxonomy` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
          `description` longtext COLLATE utf8_unicode_ci NOT NULL,
          `parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
          `count` bigint(20) UNSIGNED NOT NULL DEFAULT '0'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
     */
    /**
     * @param $parents object get all row that are parent (has parent = 0)
     * @param $space string prefix of multilevel
     * @param $modelA object (Term)
     * @param $modelB object (TermTaxonomy)
     * @return array|string
     */
    public static function makeDropDown($parents, $space, $modelA, $modelB) {
        global $data;
        $data = array();
        foreach ($parents as $parent) {
            $data[$parent->id] = $parent->name;
            self::subDropDown($parent, $space, $modelA, $modelB);
        }
        return $data;
    }
    public static function subDropDown($children, $space, $modelA, $modelB) {

        global $data;
        $childrens = $modelB::findAll(['parent' => $children->id]);
        foreach ($childrens as $child) {
            $nameChild = $modelA::findOne(['id' => $child->term_id]);
            $data[$nameChild->id] = $space . $nameChild->name;
            self::subDropDown($nameChild, $space . $space, $modelA, $modelB);
        }
    }
}