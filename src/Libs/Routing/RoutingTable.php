<?php
namespace Libs\Routing;

class RoutingTable
{
    protected array $urlPatterns = [];
    private array $tables = [];

    public function registerMyUrlPatterns(): void
    {
        if (count($this->tables) > 0)
            return;

        foreach ($this->urlPatterns as $urlPattern) {
            $this->register(
                pattern: $urlPattern[0],
                methodType: $urlPattern[1],
                class: $urlPattern[2],
                action: $urlPattern[3] ?? 'index'
            );
        }
    }

    public function register(string $pattern, string $methodType, string $class, string $action = 'index'): void
    {
//        echo '<pre>';
//        print_r($this->tables);
//        echo '</pre>';
        if (empty($this->tables[$methodType])) {
            $this->tables[$methodType] = [];
        }
//        echo '<pre>';
//        print_r($this->tables);
//        echo '</pre>';
        $pieces = explode('/', $pattern);
        $current_pointer = &$this->tables[$methodType];
        foreach ($pieces as $piece) {
            if (empty($current_pointer[$piece])) {
                $current_pointer[$piece] = [];
            }
            $current_pointer = &$current_pointer[$piece];
        }
        $current_pointer = [
            'class' => $class,
            'action' => $action
        ];
    }

    public function resolve(string $pathInfo, string $methodType): ?array
    {
        if (empty($this->tables[$methodType]))
            return null;

        $params = [];
        $branch = $this->tables[$methodType];
        $pieces = explode('/', $pathInfo);
        $result = null;
        for($i = 0; $i < count($pieces); $i++) {
            $result = $this->_pickBranch($branch, $pieces[$i], $params);
            if (is_null($result))
                return null;
        }
        if (is_null($result) || empty($result['class']) || empty($result['action']))
            return null;
        return ['class' => $result['class'], 'action' => $result['action'], 'params' => $params];
    }


    private function _pickBranch(array $branch, string $piece, array &$params): ?array
    {
        if (empty($branch[$piece])) {
            [$real_piece, $params] = $this->_pickParam(branch: $branch, piece: $piece, params: $params, value_pattern: '/^\d+$/', value_type: 'int');
            if($real_piece === false){
                [$real_piece, $params] = $this->_pickParam(branch: $branch, piece: $piece, params: $params, value_pattern: '/^.+$/', value_type: 'str');
            }
            if($real_piece === false)
                return null;
            $piece = $real_piece;
        }
        $result = $branch[$piece];
        return $result;
    }

    private function _pickParam(array $branch, string $piece, array $params, string $value_pattern, string $value_type): array
    {
        if (preg_match($value_pattern, $piece)) {
            foreach (array_keys($branch) as $key) {
                if (preg_match('/' . $value_type . ':(.+)/', $key, $matches)) {
                    $params[$matches[1]] = $piece;
                    $piece = $key;
                    return [$piece, $params];
                }
            }
        }
//        echo '<pre>';
//        print_r($this->tables);
//        echo '</pre>';
        return [false, $params];
    }
}