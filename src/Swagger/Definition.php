<?php

namespace Ponticlaro\Bebop\HttpApi\Swagger;

use Ponticlaro\Bebop\HttpApi\Swagger\DefinitionProperty;

/**
 * Swagger / OpenAPI Specification definition object.
 *
 * @package Bebop\HttpApi
 * @since 1.2.0
 * @api
 *
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#definitionsObject
 */
class Definition {

  /**
   * Definition name
   *
   * @since 1.2.0
   * 
   * @var string
   */
  private $name;

  /**
   * Definition specification
   *
   * @since 1.2.0
   * 
   * @var array
   */
  private $spec = [];

  /**
   * Instantiate class; sets definition name and spec defaults
   *
   * @since 1.2.0
   */
  public function __construct( $name )
  {
    $this->name = $name;
    $this->spec = [
      'type'       => null,
      'required'   => [],
      'properties' => [],
    ];
  }

  /**
   * Return definition name
   *
   * @since 1.2.0
   * 
   * @return string Definition name
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets definition type
   *
   * @since 1.2.0
   * 
   * @param string Definition type
   */
  public function setType( $type )
  {
    $this->spec['type'] = $type;

    return $this;
  }

  /**
   * Sets definition required properties
   *
   * @since 1.2.0
   * 
   * @param aray Definition required properties
   */
  public function setRequired( array $required )
  {
    $this->spec['required'] = $required;

    return $this;
  }

  /**
   * Sets a single definition property
   *
   * @since 1.2.0
   * 
   * @param DefinitionProperty Property object
   */
  public function setProperty( DefinitionProperty $prop )
  {
    $name = $prop->getName();
    $spec = $prop->getSpec();

    $this->spec['properties'][ $name ] = $spec;

    return $this;
  }

  /**
   * Returns definition specification
   *
   * @since 1.2.0
   * 
   * @return string Definition specification
   */
  public function getSpec()
  {
    return $this->spec;
  }
}