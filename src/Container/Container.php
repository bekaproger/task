<?php


namespace Calc\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private $definitions = [];
    private $results = [];

    public function __construct(array $definitions = [])
    {
        $this->definitions = $definitions;
    }

    public function get($id)
    {
        if (array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (!array_key_exists($id, $this->definitions)) {
            return $this->results[$id] = $this->resolveClass($id);
        }

        $definition = $this->definitions[$id];
        if ($definition instanceof \Closure) {
            $this->results[$id] = $definition($this);
        } else if (is_string($definition)) {
            $this->results[$id] = $this->resolveClass($definition);
        } else {
            throw new \Exception("Can't resolve class $id.");
        }
        return $this->results[$id];
    }

    protected function resolveClass ($id)
    {
        if (class_exists($id)) {
            if ($id === self::class) {
                return $this;
            }
            $reflection = new \ReflectionClass($id);
            $arguments = [];
            if (($constructor = $reflection->getConstructor()) !== null) {
                foreach ($constructor->getParameters() as $parameter) {
                    if ($paramClass = $parameter->getClass()) {
                        $arguments[] = $this->get($paramClass->getName());
                    } elseif ($parameter->isArray()) {
                        $arguments[] = [];
                    } else {
                        if (!$parameter->isDefaultValueAvailable()) {
                            throw new \Exception('Unable to resolve "' . $parameter->getName() . '"" in service "' . $id . '"');
                        }
                        $arguments[] = $parameter->getDefaultValue();
                    }
                }
            }
            return $reflection->newInstanceArgs($arguments);
        }
        throw new \Exception('Unknown service "' . $id . '"');

    }

    public function has($id): bool
    {
        return array_key_exists($id, $this->definitions) || class_exists($id);
    }

    public function set($id, $value): void
    {
        if (array_key_exists($id, $this->results)) {
            unset($this->results[$id]);
        }
        $this->definitions[$id] = $value;
    }

    public function getSingleton($id)
    {
        return $this->resolveClass($id);
    }
 }