<?php

namespace Tests\StubClasses;

trait TraitWithEvents
{
    public static function registerTraitWithEventsEvents(): array
    {
        return ['traitEvent'];
    }
}
