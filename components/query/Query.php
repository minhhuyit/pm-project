<?php

namespace app\components\query;

/**
 * Query query data
 *
 * @author ptu
 */
class Query extends BaseComponent {
    private $isHome;
    private $isArchive;
    private $isPage;
    
    private $queryVars;
    
    
    public function isHome()
    {
        return false;
    }
    
    public function isArchive()
    {
        return false;
    }
    
    public function isPage($page='')
    {
        
    }
    
    public function isFrontPage()
    {
        
    }
    
    /**
     * Main function to query datas
     * @param type $args
     */
    public function query($args)
    {
        
    }
    
    /**
     * Parse query 
     */
    public function parseQuery()
    {
        
    }
    
    
}
