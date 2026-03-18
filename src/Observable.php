<?php

namespace Stayallive\Laravel\Eloquent\Observable;

trait Observable
{
    public static function bootObservable(): void
    {
        // The booted callback was introduced in v12.8.0, so we check if it exists before using it
        if (method_exists(static::class, 'whenBooted')) {
            static::whenBooted(static function () {
                static::registerObservableModelEvents();
            });
        } else {
            static::registerObservableModelEvents();
        }
    }

    private static function registerObservableModelEvents(): void
    {
        $events = (new static)->getObservableEvents();

        $traitEvents = self::collectEventsRegisteredByTraits();

        if ($traitEvents !== null) {
            $events = array_values(array_unique(array_merge($events, $traitEvents)));
        }

        $class = static::class;

        foreach ($events as $event) {
            $method = 'on' . ucfirst($event);

            if (method_exists($class, $method)) {
                static::registerModelEvent($event, $class . '@' . $method);
            }
        }
    }

    private static function collectEventsRegisteredByTraits(): ?array
    {
        $class  = static::class;
        $events = [];

        foreach (class_uses_recursive($class) as $trait) {
            $method = 'register' . class_basename($trait) . 'Events';

            if (method_exists($class, $method)) {
                foreach (static::{$method}() as $event) {
                    $events[] = $event;
                }
            }
        }

        if (empty($events)) {
            return null;
        }

        return array_values(array_unique($events));
    }
}
