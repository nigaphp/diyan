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
   * @param $view from views folder
   * 
   * @return render final view
   */
  public function render($view) 
  {
    $getView =  $this->getView($view);
    $getBaseView =  $this->getBaseView();
    
    return str_replace(["{{content}}", "{{title}}"], [$getView, $view], $getBaseView);
  }
  
  /**
   * @param $view from the views folder
   *
   * @return only view content
   */
  public function getView($view) 
  {
     ob_start();
     require_once "../views/$view.php";
     return ob_get_clean();
  }
  
  /**
   * @return base template 
   */
  public function getBaseView()
   {
     ob_start();
     require_once "../views/base.php";
     return ob_get_clean();
   }
  
}