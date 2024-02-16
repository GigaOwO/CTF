<?php
namespace Libs\Routing;

use Libs\Https\Request;

class Router
{
    private array $routingTables = [];

    public function __construct(array $routingTableClasses)
    {
        foreach ($routingTableClasses as $routingTableClass){
            $this->add($routingTableClass[0], new $routingTableClass[1]);
        }
    }

    public function add(string $prefixPregPattern, RoutingTable $routingTable): void
    {
        echo '<pre>';
        print_r($routingTable);
        echo '</pre>';
        $routingTable->registerMyUrlPatterns();
        $this->routingTables[] = [
            'prefixPregPattern' => $prefixPregPattern
            , 'table' => $routingTable];
    }

    public function resolve(Request $request): ?array
    {
        $path_info = $request->pathInfo();
        $result = null;
        foreach ($this->routingTables as $routingTable){
            if (preg_match($routingTable['prefixPregPattern'], $path_info, $matches)){
//                echo '<pre>';
//                print_r($routingTable);
//                echo '</pre>';
                $current_path_info = substr($path_info, strlen($matches[0]));
                $result = $routingTable['table']->resolve($current_path_info, $request->methodType());
                if ($result !== null) {
                    break;
                }
            }
        }
        return $result;
    }
}