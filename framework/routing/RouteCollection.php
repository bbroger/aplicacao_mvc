<?php
namespace Framework\Routing;

use Framework\Routing\Route;

/**
 * Classe RouteCollection: Armazena Rotas encapsuladas como objetos Route.
 */
class RouteCollection
{

    /**
     * Armazena os objetos Route
     * @var type array
     */
    private static $routes = [];

    /**
     * Adicionar uma rota
     * @param type $method
     * @param type $uri
     * @param type $handler
     */
    public static function add(string $method, string $uri, $handler = NULL)
    {
        $method = strtoupper($method);

        if (preg_match("/^(GET|POST|PUT|DELETE)$/", $method)) {
            self::$routes[] = new Route($method, $uri, $handler);

            // Permitir que uma ação seja executada sobre a última rota inserida
            $totalIndexed = count(self::$routes);
            $index = 0;
            foreach (self::$routes as $key => $route) {
                if (++$index === $totalIndexed) {
                    return self::$routes[$key];
                }
            }
        } else {
            throw new Exception('Erro: tentativa de adicionar uma rota com um método inválido.');
        }
    }

    /**
     * Obter uma Route.  Precisa  de uma Uri para casar com uma das Routes
     * Utilizará o método match da Route para encontrar a route apropriada
     * 
     * @param type $method
     * @param type $uri
     * @return type Route
     */
    public static function get(string $method, string $uri): ?Route
    {
        foreach (self::$routes as $route) {

            if ($route->match($method, $uri)) {

                return $route;
            }
        }
        return NULL;
    }
}
