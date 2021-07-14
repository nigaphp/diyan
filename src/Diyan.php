<?php
/*
 * This file is part of the Nigatedev PHP framework package
 * 
 *  (c) Abass Ben Cheik <abass@todaysdev.com>
 */
 
namespace Nigatedev\Diyan;


/**
 * View render
 * 
 * @Author Abass Ben Cheik <abass@todaysdev.com>
 */
class Diyan
{
  /**
   * @param 
   * 
   * @return render final view
   */
  public function render($view) 
  {
    $baseLayout =  $this->getBaseLayout();
    $viewContent =  $this->getViewContent($view);
    
    return str_replace(["{{content}}", "{{title}}"], [$viewContent, strtoupper($view)], $baseLayout);
  }
  
  /**
   * @return base template 
   */
  public function getBaseLayout()
  {
    ob_start();
    require_once "../views/layouts/base.php";
    return ob_get_clean();
  }
  
  /**
   * @param the view giving from the Router, E.g:  Nigatedev\Core\Router::get("/", "home") method. will load path/to/views/home.php
   *
   * @return only view content
   */
  public function getViewContent($view)
  {
    ob_start();
    require_once "../views/$view.php";
    return ob_get_clean();
  }
  
}