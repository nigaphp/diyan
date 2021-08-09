<?php

namespace Nigatedev\Diyan;

interface DiyanInterface
{
  /**
   * @param string $view
   *
   * @return void
   */
    public function render($view);
  
  /**
   * @param string $baseView
   *
   * @return self
   */
    public function setBaseView($baseView);
   
  /**
   * @return string
   */
    public function getBaseView();
   
  /**
   * @param string $onlyView
   * @param mixed $params
   *
   * @return mixed
   */
    public function setOnlyView($onlyView, $params = []);
   
   
  /**
   * @return string
   */
    public function getOnlyView();
}
