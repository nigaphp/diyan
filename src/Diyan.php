<?php
/**
* This file is part of the Nigatedev PHP framework package
*
* (c) Abass Ben Cheik <abass@todaysdev.com>
*/

namespace Nigatedev\Diyan;

use Nigatedev\Diyan\DiyanNotFoundTemplate;
use Nigatedev\Diyan\DiyanInterface;
use Nigatedev\Core\App;

/**
* Diyan view render
*
* @package Nigatedev\Diyan
*
* @author Abass Ben Cheik <abass@todaysdev.com>
*/
class Diyan extends DiyanNotFoundTemplate implements DiyanInterface
{

  /**
  * @var string
  */
  private $head;

  /**
  * @var string
  */
  private $header;

  /**
  * @var string
  */
  private $body;

  /**
  * @var string
  */
  private $footer;
  
  
  /**
  * undocumented class variable
  *
  * @var string
  */
  private $onlyView;
  
  /**
  * undocumented class variable
  *
  * @var string
  */
  private $defaultVars;

  /**
  * undocumented class variable
  *
  * @var string
  */
  private $viewTitle;

  /**
  * @var string
  */
  private $baseView;
  
  /**
  * undocumented function
  *
  * @param string $head
  */
  public function setHead($head)
  {
    $this->head = $head;
  }

  /**
  * undocumented function
  *
  * @param string $header
  */
  public function setHeader($header)
  {
    $this->header = $header;
  }

  /**
  * undocumented function
  *
  * @param string $body
  */
  public function setBody($body): self
  {
    $this->body = $body;
    if ($body) {
      $this->onlyView = $body;
    }

    return $this;
  }

  /**
  * undocumented function
  *
  * @param string $footer
  */
  public function setFooter($footer)
  {
    $this->footer = $footer;
  }

  /**
  * undocumented function
  *
  * @return string
  */
  public function getHead()
  {
    return $this->head;
  }

  /**
  * undocumented function
  *
  * @return string
  */
  public function getHeader()
  {
    return $this->header;
  }

  /**
  * undocumented function
  *
  * @return string
  */
  public function getBody()
  {
    return $this->body;
  }

  /**
  * undocumented function
  *
  * @return string
  */
  public function getFooter()
  {
    return $this->footer;
  }
  
  /**
  * undocumented function
  *
  * @return string
  */
  public function getDefaultVars()
  {
    return [
      "title" => $this->viewTitle,
      ];
  }
  
  /**
  * @param $view from views folder
  * @param array $params
  *
  * @return render final view
  */
    public function render($view, $params = []) 
  {
    $this->viewTitle = $view;
    
    if (is_null($this->body)) {
      $this->setOnlyView($view, $params);
    }
    $this->setBaseView("base");
    
    $params = array_merge($this->getDefaultVars(), $params);
    return str_replace("{{body}}", $this->getOnlyView(), $this->getBaseView());
  }

  public function getOnlyView()
  {
    return $this->onlyView;
  }

  public function getBaseView()
  {
    return $this->baseView;
  }

  /**
  * @param $view from the views folder     *
  * @param array $params
  *
  * @return only view content
  */
  public function setOnlyView($onlyView,  $params = []) {
   
    $this->onlyView = $onlyView;
        foreach ($params as $key => $value) {
      $$key = $value;
    }
    ob_start();
    require_once APP::$APP_ROOT. "/views/{$this->onlyView}.php";
    $this->onlyView = ob_get_clean();
  }

 /**
  * @return base template
  */
  public function setBaseView($baseView = "base"): self
  {
    $this->baseView = $baseView;
    ob_start();
    require_once App::$APP_ROOT . "/views/{$this->baseView}.php";
    $this->baseView = ob_get_clean();
    return $this;
  }
}
