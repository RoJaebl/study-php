<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use App\Exception\SesstionException;

class SessionMiddleware implements MiddlewareInterface
{
  public function process(callable $next)
  {
    if (session_status() === PHP_SESSION_ACTIVE) {
      throw new SesstionException("Session already active");
    }

    if (headers_sent($filename,  $line)) {
      throw new SesstionException("Headers already sent. Consider enabling output buffering. Data outputted from {$filename} - Line: {$line}");
    }

    session_start();

    $next();

    session_write_close();
  }
}
