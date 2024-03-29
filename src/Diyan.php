<?php
/*
 * This file is part of the Niga framework package.
 *
 * (c) Abass Ben <abass@abassdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Niga\Diyan;

use Niga\Diyan\DiyanNotFoundTemplate;
use Niga\Diyan\DiyanInterface;
use Niga\Framework\Attributes\Route;
use Niga\Framework\Application\App;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Diyan template render
 *
 * @author Abass Ben <abass@abassdev.com>
 */
class Diyan extends DiyanNotFoundTemplate implements DiyanInterface
{

  /**
   * @var ServerRequestInterface
   */
  private $request;

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
   * @var Route
   */
  private Route $route;

  /**
   * @param ServerRequestInterface $request
   */
  public function __construct(ServerRequestInterface $request)
  {
    $this->request = $request;
  }
  /**
   * Get ServerRequest
   * @return void
   */
  public function getDebug()
  {
    return App::$app->debugger->getDebugMode();
  }

  /**
   * Get ServerRequest
   * @return void
   */
  public function getRequest()
  {
    return $this->request;
  }

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
   * Get path (e.g "/product")
   *
   * @return string
   */
  public function getPath()
  {
    return $this->request->getHost;
  }

  /**
   * Load JavaScript files
   *
   * @param string $style
   * @return string
   */
  public function scriptAsset(string $script)
  {
    $host = $this->getHost();
    $scriptAsset = "{$host}/build/{$script}.js";
    return $scriptAsset;
  }

  /**
   * Load Css(style) files
   *
   * @param string $style
   * @return string
   */
  public function styleAsset(string $style)
  {
    $host = $this->getHost();
    $styleAsset = "{$host}/build/{$style}.css";
    return $styleAsset;
  }

  /**
   * Load images
   *
   * @param string $image
   * @return string
   */
  public function imageAsset(string $image)
  {
    $host = $this->getHost();
    $imageAsset = "{$host}/images/{$image}";
    return $imageAsset;
  }

  /**
   * @return string
   */
  public function getHost()
  {
    $configFile = php_sapi_name() === 'cli' ? "./config/app.json" : APP::$APP_ROOT . "/config/app.json";

    $security = json_decode(\file_get_contents($configFile), true);
    $protocole = $security["security"]["http_protocol"];
    return $protocole . "://" . $this->request->getHeader("host")[0];
  }

  /**
   * Return the generate URL
   *
   * @return string
   */
  /**public function generateUrl(string $route = "", array $params = [])
  {

    $host = $this->getHost();
    $routeName = $this->request->getRouteName($route);

    $url = "{$host}{$routeName}";

    if (is_array($params)) {
      if (isset($params["id"]) && is_integer($params["id"])) {
        $url .= "/" . (string)$params["id"];
      }
    }
    return str_ireplace("/{id}", "", $url);
  }*/

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
   * Default render() params
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
   * Final views render
   *
   * @param string|null $view
   * @param mixed $params
   *
   * @return mixed
   */
  public function render($view, $params = [])
  {
    $this->viewTitle = $view;

    if (empty($this->getBody())) {
      $this->setOnlyView($view, $params);
    }
    $this->setBaseView("base");

    $params = array_merge($this->getDefaultVars(), $params);
    return str_replace("{{body}}", $this->getOnlyView(), $this->getBaseView());
  }

  /**
   * Get the a single view
   *
   * @return string|null
   */
  public function getOnlyView()
  {
    return $this->onlyView;
  }

  /**
   * Get the base view (e.g base.twig, base.diyan.php)
   *
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
    if ($onlyView === 'errors/_404' && !file_exists(APP::$APP_ROOT . "/views/errors/_404.php")) {
      
    $this->onlyView = $onlyView;
    foreach ($params as $key => $value) {
      $$key = $value;
    }
    ob_start();
    require_once dirname(__DIR__) . "/views/errors/_404.php";
    $this->onlyView = (string)ob_get_clean();
   
    } else {
    $this->onlyView = $onlyView;
    foreach ($params as $key => $value) {
      $$key = $value;
    }
    ob_start();
    require_once php_sapi_name() == 'cli' ? "./views/{$this->onlyView}.php" : APP::$APP_ROOT .  "/views/{$this->onlyView}.php";
    $this->onlyView = (string)ob_get_clean();
    }
  }

  /**
   * Base view setter
   *
   * @param string $baseView
   *
   * @return self
   */
  public function setBaseView($baseView = "base"): self
  {
     if ($baseView === 'base' && !file_exists(APP::$APP_ROOT . "/views/base.php")) {
         
    $this->baseView = $baseView;
   
    ob_start();
    require_once dirname(__DIR__) . "/views/base.php";
    $this->baseView = (string)ob_get_clean();
   return $this;
    }  else {
    $this->baseView = $baseView;
    ob_start();
    require_once App::$APP_ROOT . "/views/{$this->baseView}.php";
    $this->baseView = (string)ob_get_clean();
    return $this;
    }
  }
}
