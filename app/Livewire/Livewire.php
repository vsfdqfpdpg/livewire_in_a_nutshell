<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Blade;
use ReflectionException;

class Livewire
{
    /**
     * @param $class
     * @return string
     */
    public function initComponent($class): string
    {
        $component = new $class;
        try {
            [$html, $snapshot] = $this->toSnapshot($component);
            $snapshotAttributes = htmlentities(json_encode($snapshot));
            return <<<HTML
<div wire:snapshot="$snapshotAttributes">
{$html}
</div>
HTML;
        } catch (ReflectionException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get rendered content and snapshot from a component
     * @param mixed $component
     * @return array
     * @throws ReflectionException
     */
    public function toSnapshot(mixed $component): array
    {
        $properties = $this->getProperties($component);
        $html = Blade::render($component->render(), $properties);
        return [$html, ["class" => get_class($component), "data" => $properties]];
    }

    /**
     * Get all public properties from a component
     * @throws ReflectionException
     */
    private function getProperties(mixed $component): array
    {
        $reflect = new \ReflectionClass($component);
        $properties = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        $args = [];
        foreach ($properties as $property) {
            $args[$property->getName()] = $property->getValue($component);
        }
        return $args;
    }

    public function fromSnapshot(mixed $snapshot)
    {
        ["class" => $class, "data" => $data] = $snapshot;
        $component = new $class;
        $this->setProperties($component, $data);
        return $component;
    }

    private function setProperties(mixed $component, mixed $data): void
    {
        foreach ($data as $name => $value) {
            $component->$name = $value;
        }
    }

    public function callMethod(mixed $component, mixed $method): void
    {
        method_exists($component, $method) && $component->$method();
    }
}
