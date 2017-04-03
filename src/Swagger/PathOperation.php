<?php

namespace Ponticlaro\Bebop\HttpApi\Swagger;

use Ponticlaro\Bebop\HttpApi\Swagger\Patterns\PathOperationInterface;

/**
 * Swagger / OpenAPI Specification path item object.
 *
 * @package Bebop\HttpApi
 * @since 1.2.0
 * @api
 *
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#pathItemObject
 */
class PathOperation implements PathOperationInterface {

  /**
   * Path item method
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $method;

  /**
   * Path item spec
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $spec = [];

  /**
   * {@inheritDoc}
   */
  public function __construct( $method, array $spec = [] )
  {
    $this->method = $method;
    $this->spec   = $spec;
  }

  /**
   * {@inheritDoc}
   */
  public function getMethod()
  {
    return $this->method;
  }

  /**
   * {@inheritDoc}
   */
  public function getSpec()
  {
    return $this->spec;
  }
}