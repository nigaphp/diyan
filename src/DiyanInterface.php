<?php

namespace Nigatedev\Diyan;

interface DiyanInterface
{
  
   public function render($view);
  
   public function setBaseView($baseView);
   
   public function getBaseView();
   
   public function setOnlyView($onlyView);
   
   public function getOnlyView();
}