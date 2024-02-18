<?php
namespace Libs\Routing;

class RoutingTable
{
    protected array $urlPatterns = [];
    private array $tables = [];


    const INT_PATTERN = '/^\d+$/';
    const STR_PATTERN = '/^[^0-9]+$/';

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

    public function register(string $pattern, string $methodType, string $class, string $action): void
    {

        if (empty($this->tables[$methodType])) {
            $this->tables[$methodType] = [];
        }
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
        $real_piece = null;

        if ($real_piece = $this->_pickIntParam($branch, $piece, $params)) {
            return $branch[$real_piece];
        }

        if ($real_piece = $this->_pickStrParam($branch, $piece, $params)) {
            return $branch[$real_piece];
        }

        return null;
    }

    private function _pickIntParam(array $branch, string $piece, array &$params): string|null
    {
        return $this->_pickParam($branch, $piece, $params, self::INT_PATTERN, 'int');
    }

    private function _pickStrParam(array $branch, string $piece, array &$params): string|null
    {
        return $this->_pickParam($branch, $piece, $params, self::STR_PATTERN, 'str');
    }

    private function _pickParam(array $branch, string $piece, array &$params, string $valuePattern, string $valueType): string|null
    {
        if (preg_match($valuePattern, $piece)) {
            foreach (array_keys($branch) as $key) {
                if (preg_match('/' . $valueType . ':(.+)/', $key, $matches)) {
                    $params[$matches[1]] = $piece;
                    return $key;
                }
            }
        }

        return null;
    }

}