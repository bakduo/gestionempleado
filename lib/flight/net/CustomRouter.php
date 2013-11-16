<?php
/**
 * CustomRouter.php:
 *
 * @copyright   Copyright (c) 2013, Linuxknow <linuxknow@gmail.com>
 * @license     MIT, http://flightphp.com/license
 */

namespace flight\net;

/*
#############################################################################                                                                           #
#   Clase CustomRouter,MiniRouteHttp                                        #
#############################################################################
*/
class MiniRouteHttp
{
    /**
     * @var string URL pattern
     */
    public $pattern;
    /**
     * @var array Route parameters
     */
    public $params = array();

    public $enabled=false;

    /**
     * @var string Matching regular expression
     */
    public $regex;

    public function setPattern($str){
    	$this->pattern=$str;
    }

    public function getPattern(){
    	return $this->pattern;
    }

     public function matchUrl($url) {
        if ($this->pattern === '*' || $this->pattern === $url) {
            return true;
        }

        $ids = array();
        $char = substr($this->pattern, -1);
        $this->pattern = str_replace(array(')','*'), array(')?','.*?'), $this->pattern);

        // Build the regex for matching
        $regex = preg_replace_callback(
            '#@([\w]+)(:([^/\(\)]*))?#',
            function($matches) use (&$ids) {
                $ids[$matches[1]] = null;
                if (isset($matches[3])) {
                    return '(?P<'.$matches[1].'>'.$matches[3].')';
                }
                return '(?P<'.$matches[1].'>[^/\?]+)';
            },
            $this->pattern
        );

        // Fix trailing slash
        if ($char === '/') {
            $regex .= '?';
        }
        // Allow trailing slash
        else {
            $regex .= '/?';
        }

        // Attempt to match route and named parameters
        if (preg_match('#^'.$regex.'(?:\?.*)?$#i', $url, $matches)) {
            foreach ($ids as $k => $v) {
                $this->params[$k] = (array_key_exists($k, $matches)) ? urldecode($matches[$k]) : null;
            }

            $this->regex = $regex;

            return true;
        }

        return false;
    }

    public function getParams(){
    	return $this->params;
    }

    function setEnabled($ok){
       $this->enabled = $ok;
    }

    function getEnabled(){
        return $this->enabled;
    }
}

class CustomRouter extends Router
{
	protected $app=NULL;
	public $pattern='';
	public $params = array();
	public $regex;
	public $routes = array();
	public $index = 0;
	public $methods = array();

	public function mapCustom($pattern,$enabled) {
	 	$mini=new MiniRouteHttp();
        if (strpos($pattern, ' ') !== false) {
            list($method, $url) = explode(' ', trim($pattern), 2);
           //$methods = explode('|', $method);
            $mini->setPattern($url);
            $mini->setEnabled($enabled);
            array_push($this->routes, $mini);
        }
        else {
        	$mini->setPattern($pattern);
            $mini->setEnabled($enabled);
            array_push($this->routes, $mini);
        }
    }
    /**
     * Clears all routes the router.
     */
    public function clear() {
        $this->routes = array();
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function route(Request $request) {
        while ($route = $this->current()) {
            if ($route !== false) {
            	if ($route->matchUrl($request->url) && $route->getEnabled()){
            	   return $route;
            	}
            }
            $this->next();
        }
        $this->reset();
        return false;
    }

	public function setApp($app){
		$this->app=$app;
	}

    public function current() {
        return isset($this->routes[$this->index]) ? $this->routes[$this->index] : false;
    }

    /**
     * Gets the next route.
     *
     * @return Route
     */
    public function next() {
        $this->index++;
    }

    /**
     * Reset to the first route.
     */
    public  function reset() {
        $this->index = 0;
    }

}

?>