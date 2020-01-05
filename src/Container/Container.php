<?php

namespace Lil\Container;

class Container implements ContainerInterface
{
    protected $definitions = [];

    protected $results = [];

    public function __construct(array $definitions = [])
    {
        $this->definitions = $definitions;
    }

    public function get($id)
    {
        if (self::class === $id) {
            return $this;
        }

        if (array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (!array_key_exists($id, $this->definitions)) {
            return $this->results[$id] = $this->resolveClass($id);
        }

        $definition = $this->definitions[$id];
        if ($definition instanceof \Closure) {
            $this->results[$id] = $definition($this);
        } elseif (is_string($definition)) {
            $this->results[$id] = $this->get($definition);
        } elseif (is_object($definition)) {
            $this->results[$id] = $definition;
        } else {
            throw new \Exception("Can't resolve class $id.");
        }

        return $this->results[$id];
    }

    protected function resolveClass($id)
    {
        if (class_exists($id)) {
            $reflection = new \ReflectionClass($id);
            $arguments = [];
            if (null !== ($constructor = $reflection->getConstructor())) {
                foreach ($constructor->getParameters() as $parameter) {
                    if ($paramClass = $parameter->getClass()) {
                        $arguments[] = $this->get($paramClass->getName());
                    } elseif ($parameter->isArray()) {
                        $arguments[] = [];
                    } else {
                        if (!$parameter->isDefaultValueAvailable()) {
                            throw new \Exception('Unable to resolve "'.$parameter->getName().'"" in service "'.$id.'"');
                        }
                        $arguments[] = $parameter->getDefaultValue();
                    }
                }
            }

            return $reflection->newInstanceArgs($arguments);
        }
        throw new \Exception('Unknown service "'.$id.'"');
    }

    public function has($id): bool
    {
        return array_key_exists($id, $this->results);
    }

    public function set($id, $value): void
    {
        if (array_key_exists($id, $this->results)) {
            unset($this->results[$id]);
        }
        $this->definitions[$id] = $value;
    }
}
