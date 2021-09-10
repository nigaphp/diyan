<?php
/*
 * This file is part of the Nigatedev framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Nigatedev\Diyan;

use Nigatedev\Diyan\DiyanNotFoundTemplate;
use Nigatedev\Diyan\DiyanInterface;
use Nigatedev\FrameworkBundle\Application\App;

/**
* Diyan template render
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
  *
  * @var string|null
  */
    private $onlyView;
  
  /**
  *
  * @var string
  */
    private $defaultVars;

 /**
  *
  * @var string|null
  */
    private $viewTitle;

 /**
  * @var string
  */
    private $baseView;
  
 /**
  * Overwrite template head
  *   Example the contents between the tag <head> and </head>
  *
  * @param string $head
  * @return void
  */
    public function setHead($head)
    {
        $this->head = $head;
    }

 /**
  *
 /**
  * Overwrite template header
  *   Example the contents between the tags <header> and </header>
  *
  * @param string $header
  * @return void
  */
    public function setHeader($header)
    {
        $this->header = $header;
    }

 /**
  * Inject template contents
  *   by default it overwrite {{content}} see base template for more information
  *
  * @param mixed $body
  * @return void
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
  * Overwrite footer contents
  *  Example the contents between the tags <footer> and </footer>
  *
  * @param string $footer
  * @return void
  */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

 /**
  * Get the current template head contents
  *
  * @return string
  */
    public function getHead()
    {
        return $this->head;
    }

 /**
  * Get the current template header contents
  *
  * @return string
  */
    public function getHeader()
    {
        return $this->header;
    }

 /**
  * Get the current template body contents
  *
  * @return string
  */
    public function getBody()
    {
        return $this->body;
    }

  
 /**
  * Get the current template footer contents
  *
  * @return string
  */
    public function getFooter()
    {
        return $this->footer;
    }
  
  /**
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
