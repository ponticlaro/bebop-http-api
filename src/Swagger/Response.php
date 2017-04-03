<?php

namespace Ponticlaro\Bebop\HttpApi\Swagger;

/**
 * Swagger / OpenAPI Specification response object.
 *
 * @package Bebop\HttpApi
 * @since 1.2.0
 * @api
 *
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#responsesDefinitionsObject
 */
class Response {

  /**
   * Response name
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $name;

  /**
   * Response description
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $description;

  /**
   * Response schema
   *
   * @since 1.2.0
   * 
   * @var mixed
   */
  private $schema;
  
  /**
   * Response headers
   *
   * @since 1.2.0
   * 
   * @var mixed
   */
  private $headers;

  /**
   * Response examples
   *
   * @since 1.2.0
   * 
   * @var mixed
   */
  private $examples;

  /**
   * Instantiates class; Sets tag name
   *
   * @since 1.2.0
   * 
   * @param string Tag name
   */
  public function __construct( $name, $description )
  {
    $this->name        = $name;
    $this->description = $description;
  }

  /**
   * Sets response schema
   *
   * @since 1.2.0
   * 
   * @param Schema Response scehma
   */
  public function setSchema( Schema $schema )
  {
    $this->schema = $schema;

    return $this;
  }

  /**
   * Sets response headers
   *
   * @since 1.2.0
   * 
   * @param mixed Response headers
   */
  public function setHeaders( array $headers )
  {
    $this->headers = $headers;

    return $this;
  }

  /**
   * Returns tag specification
   *
   * @since 1.2.0
   * 
   * @return string Tag specification
   */
  public function getSpec()
  {
    $name = ;

    $spec = [
      $this->name => [
        'description' => $this->description
      ]
    ];

    if ( $this->schema )
      $spec[ $this->name ]['description'] = $this->schema;

    if ( $this->headers )
      $spec[ $this->name ]['headers'] = $this->headers;

    if ( $this->examples )
      $spec[ $this->name ]['examples'] = $this->examples;

    return $spec;
  }
}