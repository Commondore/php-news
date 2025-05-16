<?php

namespace App\Middleware;

use App\Helpers\AuthApi;

class ApiAuthMiddleware
{
  public static function handle(): void
  {
    if(!AuthApi::check()) {
      http_response_code(404);
      echo 'Страница не найдена';
      exit;
    }
  }
}