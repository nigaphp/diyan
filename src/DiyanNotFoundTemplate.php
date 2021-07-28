<?php
/*
 * This file is part of the Nigatedev PHP framework package
 * 
 *  (c) Abass Ben Cheik <abass@todaysdev.com>
 */

namespace Nigatedev\Diyan;

/**
 * NotFound class
 * 
 * @package Nigatedev\Diyan;
 * 
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class DiyanNotFoundTemplate
{
  
    /**
     * @return route not found content / type 404 Not Found
     */
    public function getNotFound() 
    {
        $path = $_SERVER["HTTP_HOST"];
        return <<<NFB
<div class="be-container">
  <h1 class="be-color-dg">Oops 🙄 404 Not Found</h1>
  <p class="be-color-dg">Sorry this page is not found</code></p>
  <small>Maybe try to go <a href="http://$path"?>Home?</a></small>
</div>
NFB;
    }
    
    
    /**
     * @return home page title and content if not route found
     */
    public function getHomeNotFound()
    {
        return <<<HNF
<div class="be-container">
  <h2 class="be-color-py">Nigatedev PHP framework for saving time ⏱️</h2>
  <p class="be-color-dg">ERROR: <code>404 Not Found</code></p>
  <small>You are seeing this because
  you haven't config a route for the Home page yet.</small>
<p>You can use the following command <span class='be-code'>php bin/console make:controller HomeController</span> to create a route that point to http://localhost:8000/home for example.</p>
</div>
HNF;
    }
}
