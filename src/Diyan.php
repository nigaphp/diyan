<?php
/**
* This file is part of the Nigatedev PHP framework package
*
* (c) Abass Ben Cheik <abass@todaysdev.com>
*/

namespace Nigatedev\Diyan;

use Nigatedev\Diyan\DiyanNotFoundTemplate;
use Nigatedev\Diyan\DiyanInterface;
use Nigatedev\FrameworkBundle\Application\App;

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
  * @var string $head
  */
    private $head;

  /**
  * @var string $header
  */
    private $header;

  /**
  * @var string $body
  */
    private $body;

  /**
  * @var string $footer
  */
    private $footer;
  
  
  /**
  * undocumented class variable
  *
  * @var string|null $onlyView
  */
    private $onlyView;
  
  /**
  * undocumented class variable
  *
  * @var string $defaultVars
  */
    private $defaultVars;

  /**
  * undocumented class variable
  *
  * @var string|null $viewTitle
  */
    private $viewTitle;

  /**
  * @var string $baseView
  */
    private $baseView;
  
  /**
  * undocumented function
  *
  * @param string $head
  *
  * @return void
  */
    public function setHead($head)
    {
        $this->head = $head;
    }

  /**
  * undocumented function
  *
  * @param string $header
  *
  * @return void
  */
    public function setHeader($header)
    {
        $this->header = $header;
    }

  /**
  * undocumented function
  *
  * @param mixed $body
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
  *
  * @return void
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
  * @return array<string, string|null>
  */
    public function getDefaultVars()
    {
        return [
        "title" => $this->viewTitle,
        ];
    }
  
  /**
  * @param string|null $view
  * @param mixed $params
  *
  * @return mixed
  */
    public function render($view, $params = [])
    {
        $this->viewTitle = $view;
    
        if (empty($this->body)) {
            $this->setOnlyView($view, $params);
        }
        $this->setBaseView("base");
    
        $params = array_merge($this->getDefaultVars(), $params);
        return str_replace("{{body}}", $this->getOnlyView(), $this->getBaseView());
    }
  
  /**
   * @return string|null
   */
    public function getOnlyView()
    {
        return $this->onlyView;
    }
  
  /**
   * @return string
   */
    public function getBaseView()
    {
        return $this->baseView;
    }

  /**
  * @param string|null $onlyView
  * @param mixed $params
  *
  * @return mixed
  */
    public function setOnlyView($onlyView, $params = [])
    {
   
        $this->onlyView = $onlyView;
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        require_once APP::$APP_ROOT. "/views/{$this->onlyView}.php";
        $this->onlyView = (string)ob_get_clean();
    }

 /**
  * @param string $baseView
  *
  * @return self
  */
    public function setBaseView($baseView = "base"): self
    {
        $this->baseView = $baseView;
        ob_start();
        require_once App::$APP_ROOT . "/views/{$this->baseView}.php";
        $this->baseView = (string)ob_get_clean();
        return $this;
    }
}
