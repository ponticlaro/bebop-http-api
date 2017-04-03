

<?php

namespace Ponticlaro\Bebop\HttpApi\Swagger;

use Ponticlaro\Bebop\HttpApi\Swagger\Patterns\PathOperationInterface;

/**
 * Swagger / OpenAPI Specification path object.
 *
 * @package Bebop\HttpApi
 * @since 1.2.0
 * @api
 *
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#pathsObject
 */
class Path {

  /**
   * Path path
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $path;

  /**
   * Path operations
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $operations = [];

  /**
   * Instantiate class; sets path
   *
   * @since 1.2.0
   */
  public function __construct( $path )
  {
    $this->path = $path;
  }

  /**
   * Sets a single operation
   *
   * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#pathItemObject
   * 
   * @since 1.2.0
   * 
   * @return string PathOperation
   */
  public function addOperation( PathOperationInterface $operation )
  {
    $method = $operation->getMethod();
    $spec   = $operation->getSpec();

    $this->operations[ $method ] = $spec;

    return $this;
  }

  /**
   * Returns path specification
   *
   * @since 1.2.0
   * 
   * @return string Path specification
   */
  public function getSpec()
  {
    return [
      $this->path => $this->operations
    ];
  }
}