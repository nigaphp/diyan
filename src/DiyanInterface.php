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
