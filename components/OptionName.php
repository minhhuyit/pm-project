<?php

namespace app\components;

/**
 * OptionName option name constants
 *
 * @author ptu
 */
class OptionName {
    /**
     * Setting front page display type, page or posts
     */
    const FRONT_PAGE_DISPLAY='cms_front_page_display';
    
    /**
     * Setting static page will be display on front 
     */
    const PAGE_ON_FRONT='cms_page_on_front';
    
    /**
     * setting page that display posts on front
     */
    const POSTS_ON_FRONT='cms_posts_on_front';
    
    /**
     * Number of posts will be display per page
     */
    const NUM_POSTS_SHOW='cms_num_posts_show';

    /**
     *Title of main
     */
    const SITE_TITLE='cms_site_title';

    /**
     *Date format
     */
    const DATE_FORMAT='cms_date_format';

    /**
     *Time format
     */
    const TIME_FORMAT='cms_time_format';

    /**
     *Language format
     */

    const LANGUAGE='cms_language';

    /**
     * Setting Permalink
     */
    const POST_PERMALINK='cms_post_permalink';
}
