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

/**
 * NotFound Template
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class DiyanNotFoundTemplate
{
  
    /**
     * Route not found content
     *   Example when you try to access an route that doesn't exist
     *    This content will be automatically injection on the current page
     *     And the code status is set to 404
     *
     * @return string
     */
    public function getNotFound()
    {
        $path = $_SERVER["HTTP_HOST"] ?? "http://localhost:8000";
        return <<<NOTFOUND
<div class="be-container">
  <h1 class="be-color-dg">Oops 🙄 404 Not Found</h1>
  <p class="be-color-dg">Sorry this page is not found</code></p>
  <small>Maybe try to go <a href="http://$path">Home?</a></small>
</div>
NOTFOUND;
    }
    
    /**
     * Home page content if not route found
     *  The code status is set to 404
     *
     * @return string
     */
    public function getHomeNotFound()
    {
        
        $path = $_SERVER["HTTP_HOST"] ?? "http://localhost:8000";
        return <<<HOMENOTFOUND
<div class="be-container">
  <h2 class="be-color-py">Nigatedev PHP framework for saving time</h2>
  <img width="100" height="auto" src="http://$path/images/nigatedev.png"></img>
  <p class="be-color-dg">ERROR: <code>404 Not Found</code></p>
  <small>You are seeing this because
  you haven't config a route for the Home page yet and debug mode is enabled.</small>
<p>You can use the following command <span class='be-code'>bin/niga m:c HomeController</span> to create a route that point to http://$path/home for example.</p>
</div>
HOMENOTFOUND;
    }
}
