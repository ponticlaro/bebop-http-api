<?php

namespace Ponticlaro\Bebop;

use Ponticlaro\Bebop\Common\Collection;

class HttpApi {

	/**
	 * Api configuration
	 * 
	 * @var Ponticlaro\Bebop\Common\Collection
	 */
	protected $config;

	/**
	 * Api router
	 * 
	 * @var Ponticlaro\Bebop\HttpApi\Router
	 */
	protected $router;

	/**
	 * Instantiates new Api
	 * 
	 * @param string $rewrite_tag Rewrite Tag. Must not match any WordPress built-in query vars
	 * @param string $base_url    Base URL for all API resources
	 */
	public function __construct($rewrite_tag, $base_url)
	{
		// Initialize Config
		$this->config = new Collection;

		// Initialize Router
		$this->router = new Router;

		if (!$rewrite_tag)
			throw new \Exception("HttpApi: rewrite_tag must be a string");

		$this->setRewriteTag($rewrite_tag);

		if (!$base_url)
			throw new \Exception("HttpApi: base_url must be a string");

		$this->setBaseUrl($base_url);

		// Register stuff on the init hook
		add_action('init', array($this, '__initRegister'), 1);

		// Register custom rewrite rules
		add_action('rewrite_rules_array', array($this, '__rewriteRules'), 99);

		// Handle template includes
		add_action('template_redirect', array($this, '__templateRedirects'), 1);
	}

	/**
	 * Sets Api rewrite tag
	 * 
	 */
	public function setRewriteTag($rewrite_tag)
	{
		if (is_string($rewrite_tag)) {

			$this->config->set('rewrite_tag', $rewrite_tag);
			$this->router->setRewriteTag($rewrite_tag);
		}

		return $this;
	}

	/**
	 * Returns Api rewrite tag
	 * 
	 * @return string
	 */
	public function getRewriteTag()
	{
		return $this->config->get('rewrite_tag');
	}

	/**
	 * Sets Api URL prefix
	 * 
	 */
	public function setBaseUrl($url)
	{
		if (is_string($url)) {

			$url = trim($url ,'/') .'/';
			$this->config->set('base_url', $url);
			$this->router->setBaseUrl($url);
		}

		return $this;
	}

	/**
	 * Returns Api URL prefix
	 * 
	 * @return string
	 */
	public function getBaseUrl()
	{
		return trim($this->config->get('base_url') ,'/') .'/';
	}

	/**
	 * Returns Router instance
	 *
	 * @return Ponticlaro\WordPress\CloudMedia\Api\Router Api Router
	 */
	public function router()
	{
		return $this->router;
	}

	/**
	 * Returns Slim Framework instance
	 *
	 * @return Slim\Slim
	 */
	public function slim()
	{
		return $this->router->slim();
	}

	/**
	 * Returns Routes Manager instance
	 *
	 * @return Ponticlaro\Bebop\HttpApi\Routes Api Routes Manager
	 */
	public function routes()
	{
		return $this->router->routes();
	}

	/**
	 * Register Api stuff on the init hook
	 * 
	 * @return void
	 */
	public function __initRegister()
	{
		add_rewrite_tag('%'. $this->getRewriteTag() .'%','([^&]+)');
	}

	/**
	 * Adds custom rewrite rules for API
	 * 
	 * @param  array $wp_rules Array of rewrite rules
	 * @return array           Modified array of rewrite rules
	 */
	public function __rewriteRules($rules) 
	{
		return array_merge(
			array(
				$this->getBaseUrl() ."?(.*)?$" => 'index.php?'. $this->getRewriteTag() .'=1'
			), 
			$rules
		);
	}

	/**
	 * Adds template redirections to run the router
	 * 
	 * @return void
	 */
	public function __templateRedirects() 
	{
		global $wp_query;

		if ($wp_query->get($this->getRewriteTag())) {

			$this->router->run();
			exit;
		}
	}

    /**
     * Adds a single route with GET as the method
     * 
     * @param  string                      $path     Route path
     * @param  string                      $callable Route function
     * @return Ponticlaro\Bebop\HttpApi\Routes           This class instance
     */
    public function get($path, $callable)
    {
        $this->__addRoute('get', $path, $callable);

        return $this;
    }

    /**
     * Adds a single route with POST as the method
     * 
     * @param  string                      $path     Route path
     * @param  string                      $callable Route function
     * @return Ponticlaro\Bebop\HttpApi\Routes           This class instance
     */
    public function post($path, $callable)
    {
        $this->__addRoute('post', $path, $callable);

        return $this;
    }

    /**
     * Adds a single route with PUT as the method
     * 
     * @param  string                      $path     Route path
     * @param  string                      $callable Route function
     * @return Ponticlaro\Bebop\HttpApi\Routes           This class instance
     */
    public function put($path, $callable)
    {
        $this->__addRoute('put', $path, $callable);

        return $this;
    }

    /**
     * Adds a single route with PATCH as the method
     * 
     * @param  string                      $path     Route path
     * @param  string                      $callable Route function
     * @return Ponticlaro\Bebop\HttpApi\Routes           This class instance
     */
    public function patch($path, $callable)
    {
        $this->__addRoute('patch', $path, $callable);

        return $this;
    }

    /**
     * Adds a single route with DELETE as the method
     * 
     * @param  string                      $path     Route path
     * @param  string                      $callable Route function
     * @return Ponticlaro\Bebop\HttpApi\Routes           This class instance
     */
    public function delete($path, $callable)
    {
        $this->__addRoute('delete', $path, $callable);

        return $this;
    }

    /**
     * Adds a single route with OPTIONS as the method
     * 
     * @param  string                      $path     Route path
     * @param  string                      $callable Route function
     * @return Ponticlaro\Bebop\HttpApi\Routes           This class instance
     */
    public function options($path, $callable)
    {
        $this->__addRoute('options', $path, $callable);

        return $this;
    }

    /**
     * Internal method to add a route
     * 
     * @param  string $method   Route method
     * @param  string $path     Route path
     * @param  string $callable Route function
     * @return void
     */
	protected function __addRoute($method, $path, $callable)
	{
		if (!is_string($method))
			throw new \Exception("Api: route method must be a string");

		if (!is_string($path))
			throw new \Exception("Api: route path must be a string");
			
		if (!is_callable($callable))
			throw new \Exception("Api: route callable must be callable");
		
		call_user_func_array(array($this->routes(), $method), array($path, $callable));
	}

	/**
	 * Used to add Slim routes to Api
	 * 
	 * @param  string 					  $name Route method
	 * @param  srray  					  $args Route args
	 * @return Ponticlaro\WordPress\CloudMedia\Api\WpApi       This class instance
	 */
	public function __call($name, $args)
	{
		call_user_func_array(array($this->routes(), $method), $args);

		return $this;
	}
}