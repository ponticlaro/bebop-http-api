<?php 

namespace Ponticlaro\Bebop\HttpApi;

use Ponticlaro\Bebop\HttpApi;

class StaticAssetsServer {

  public function __construct(HttpApi $http_api, $directory)
  {
    if (!is_string($directory))
      throw new \UnexpectedValueException("Directory to serve must be a string");

    if (!is_readable($directory))
      throw new \UnexpectedValueException("Directory to serve must be readable");

    // Set unique resource to capture all requests
    $http_api->get('/.*?', function() use($http_api, $directory) {

      // Get slim instance
      $slim = $http_api->slim();

      // Find asset path
      $relative_path = str_replace($http_api->getBaseUrl(), '', $slim->request()->getResourceUri());
      $path          = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($relative_path, '/');

      // Search for target files
      $list = glob($path .'.*');

      // Return 404 if asset do not exist
      if (!$list) {
          
        $slim->halt(404, json_encode(array(
          'message' => "You're looking for a static asset that do not exist"
        )));
      }
      
      $path = $list[0];

      // Check file extension
      $file_parts = pathinfo($path);

      switch($file_parts['extension'])
      {
        case "css":
          $content_type = 'text/css; charset=UTF-8';
          break;

        case "js":
          $content_type = 'application/javascript; charset=UTF-8';
          break;

        default:
          $content_type = 'text/html; charset=UTF-8';
          break;
      }

      // Set response headers
      $slim->response()->header('Content-Type', $content_type);
      $slim->response()->header('Content-Length', filesize($path));
      $slim->response()->header('Cache-Control', 'public, max-age=31536000');

      // Do not JSON encode response
      $slim->hook('handle_response', function ($data) use($slim) {      
        $slim->response()->body($data); 
      });

      // Return file content
      return file_get_contents($path);
    });
  }
}