<?php

namespace Ponticlaro\Bebop\HttpApi\Swagger;

/**
 * Swagger / OpenAPI Specification tag object.
 *
 * @package Bebop\HttpApi
 * @since 1.2.0
 * @api
 *
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#tagObject
 */
class Tag {

  /**
   * Tag name
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $name;

  /**
   * Tag description
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $description;

  /**
   * Tag externalDocs
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $externalDocs = [];
  
  /**
   * Instantiates class; Sets tag name
   *
   * @since 1.2.0
   * 
   * @param string Tag name
   */
  public function __construct( $name )
  {
    $this->name        = $name;
    $this->description = $description;
  }

  /**
   * Sets tag description
   *
   * @since 1.2.0
   * 
   * @param string Tag description
   */
  public function setDescription( $description )
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Sets definition type
   *
   * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#externalDocumentationObject
   * 
   * @since 1.2.0
   *
   * @param string External docs description
   * @param string External docs URL
   */
  public function setExternalDocs( $url, $description = null )
  {
    $this->externalDocs['url'] = $url;

    if ($description)
      $this->externalDocs['description'] = $description;

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
    $spec = [
      'name' => $this->name
    ];

    if ($this->description)
      $spec['description'] = $this->description;

    if ($this->externalDocs)
      $spec['externalDocs'] = $this->externalDocs;

    return $spec;
  }
}