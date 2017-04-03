<?php

namespace Ponticlaro\Bebop\HttpApi\Swagger\Patterns;

/**
 * Swagger / OpenAPI Specification path item interface.
 *
 * @package Bebop\HttpApi
 * @since 1.2.0
 * @api
 *
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#pathItemObject
 */
interface PathOperationInterface {

  /**
   * Instantiate class
   *
   * @since 1.2.0
   */
  public function __construct( $method, array $spec = [] );

  /**
   * Returns path item method
   *
   * @since 1.2.0
   * 
   * @return string
   */
  public function getMethod();

  /**
   * Returns path item specification
   *
   * @since 1.2.0
   * 
   * @return string Path item specification
   */
  public function getSpec();
}