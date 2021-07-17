<?php
/**
 * This file is part of the Nigatedev PHP framework package
 * 
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 */
 
namespace Nigatedev\Diyan;

use Nigatedev\Diyan\Template\NotFound;

/**
 * Diyan view render
 * 
 * @package Nigatedev\Diyan
 * 
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Diyan extends NotFound
{
  
    /**
     * @param $view from views folder
     * @param array $params 
     * 
     * @return render final view
     */
    public function render($view, $params = []) 
    {
        $getView =  $this->getView($view, $params);
        $getBaseView =  $this->getBaseView();
    
        return str_replace(["{{body}}", "{{title}}"], [$getView, $view], $getBaseView);
    }
  
    /**
     * @param $view from the views folder     *
     * @param array $params 
     * 
     * @return only view content
     */
    public function getView($view, $params = []) 
    {
        if (is_array($params)) {
            foreach ($params as $varName => $value) {
                $$varName = $value;
            }
        }
    
        ob_start();
        include_once  "../views/$view.php";
        return ob_get_clean();
    }
  
    /**
     * @return base template 
     */
    public function getBaseView()
    {
        ob_start();
        include_once "../views/base.php";
        return ob_get_clean();
    }
    
    /**
     * @return route not found title and content
     */
    public function notFound()
    {
        return [
         "{{title}}" => "404 Not Found",
        "{{body}}" => $this->notFoundBody()
        ];
    }
    /**
     * @return home page title and content if not route found
     */
    public function homeNotFound()
    {
        return [
         "{{title}}" => "Home page not found",
         "{{body}}" => $this->getHomeNotFound()
        ];
    }
}
