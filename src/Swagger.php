<?php

namespace Ponticlaro\Bebop\HttpApi;

use Ponticlaro\Bebop\HttpApi\Swagger\Tag;
use Ponticlaro\Bebop\HttpApi\Swagger\Path;
use Ponticlaro\Bebop\HttpApi\Swagger\Definition;

/**
 * Swagger / OpenAPI Specification builder.
 *
 * @package Bebop\HttpApi
 * @since 1.2.0
 * @api
 *
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md
 */
class Swagger {

  /**
   * Specification version
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $spec_version = '2.0';

  /**
   * Info list
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $info = [];

  /**
   * Host
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $host;

  /**
   * Base path
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $base_path;

  /**
   * Schemes list
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $schemes = [];

  /**
   * Consumed mime-types list
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $consumes = [];

  /**
   * Produced mime-types list
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $produces = [];

  /**
   * Tags list
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $tags = [];

  /**
   * Paths list
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $paths = [];

  /**
   * Definitions list
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $definitions = [];

  /**
   * Instantiate class
   *
   * @since 1.2.0
   */
  public function __construct() {}

  /**
   * Sets single info key
   *
   * @since 1.2.0
   * 
   * @param string Info key
   * @param string Info value
   */
  public function setInfo( $key, $value )
  {
    $this->info[ $key ] = $value;

    return $this;
  }

  /**
   * Sets host
   *
   * @since 1.2.0
   * 
   * @param string
   */
  public function setHost( $host )
  {
    $this->host = $host;

    return $this;
  }

  /**
   * Sets base path
   *
   * @since 1.2.0
   * 
   * @param string
   */
  public function setBasePath( $path )
  {
    $this->base_path = $path;

    return $this;
  }

  /**
   * Sets single scheme
   * 
   * @param string
   */
  public function addScheme( $scheme )
  {
    $this->schemes[] = $scheme;

    return $this;
  }

  /**
   * Sets single consumed mime type
   * 
   * @param string
   */
  public function addConsumedMimeType( $mime_type )
  {
    $this->consumes[] = $mime_type;

    return $this;
  }

  /**
   * Sets single produced mime type
   * 
   * @param string
   */
  public function addProducedMimeType( $mime_type )
  {
    $this->produces[] = $mime_type;

    return $this;
  }

  /**
   * Adds a single tag specification
   *
   * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#tagObject
   * 
   * @since 1.2.0
   * 
   * @param Tag
   */
  public function addTag( Tag $tag )
  {
    $this->tags[] = $tag->getSpec();

    return $this;
  }

  /**
   * Sets a single path specification
   *
   * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#pathsObject
   * 
   * @since 1.2.0
   * 
   * @param Path
   */
  public function addPath( Path $path )
  {
    $path = $path->getPath();
    $spec = $path->getSpec();

    $this->paths[ $path ] = $spec;

    return $this;
  }

  /**
   * Sects a single definition specification
   *
   * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#definitionsObject
   * 
   * @since 1.2.0
   * 
   * @param Definition
   */
  public function addDefinition( Definition $definition )
  {
    $name = $definition->getName();
    $spec = $definition->getSpec();

    $this->definitions[ $name ] = $spec;

    return $this;
  }

  /**
   * Returns full specification
   *
   * @since 1.2.0
   * 
   * @return array 
   */
  public function getSpec()
  {
    $spec = [
      'swagger' => $this->spec_version
    ];

    if ($this->info)
      $spec['info'] = $this->info;

    if ($this->host)
      $spec['host'] = $this->host;

    if ($this->base_path)
      $spec['basePath'] = $this->base_path;

    if ($this->schemes)
      $spec['schemes'] = $this->schemes;

    if ($this->consumes)
      $spec['consumes'] = $this->consumes;

    if ($this->produces)
      $spec['produces'] = $this->produces;

    if ($this->paths)
      $spec['paths'] = $this->paths;

    if ($this->definitions)
      $spec['definitions'] = $this->definitions;

    if ($this->tags)
      $spec['tags'] = $this->tags;

    return $spec;
  }
}