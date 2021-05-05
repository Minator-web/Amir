<?php


namespace Fira\App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class BaseMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param ServerRequestInterface $request PSR7 request
     * @param ResponseInterface $response PSR7 response
     * @param callable $next Next middleware
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        if (isset($this)) {
            $this->handleBefore($request, $response);
        }
        $response = $next($request, $response);
        $this->handleAfter($request, $response);

        return $response;
    }

    abstract protected function handleBefore(ServerRequestInterface $request, ResponseInterface $response): void;

    abstract protected function handleAfter(ServerRequestInterface $request, ResponseInterface $response): void;
}