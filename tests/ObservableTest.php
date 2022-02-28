<?php

namespace Tests;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Tests\StubClasses\ObservableModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ObservableTest extends TestCase
{
    use RefreshDatabase;

    public function testEventsAreRegistered(): void
    {
        $events = Event::fake();

        $model = new ObservableModel;

        foreach ($model->getObservableEvents() as $event) {
            if ($event === 'customEventNotRegistered') {
                continue;
            }

            $this->assertTrue(
                $events->hasListeners("eloquent.{$event}: " . ObservableModel::class)
            );
        }
    }

    public function testTraitEventsAreRegistered(): void
    {
        $events = Event::fake();

        new ObservableModel;

        foreach (ObservableModel::registerTraitWithEventsEvents() as $event) {
            $this->assertTrue(
                $events->hasListeners("eloquent.{$event}: " . ObservableModel::class)
            );
        }
    }

    public function testCreatedEventIsFiredOnModel(): void
    {
        /** @var ObservableModel $model */
        $model = tap(new ObservableModel(['name' => Str::random()]))->save();

        $this->assertCount(4, $model->eventsDisptached);
        $this->assertTrue($model->eventsDisptached['creating']);
        $this->assertTrue($model->eventsDisptached['saving']);
        $this->assertTrue($model->eventsDisptached['created']);
        $this->assertTrue($model->eventsDisptached['saved']);
    }

    public function testEventWithoutHandlerIsNotRegistered(): void
    {
        $events = Event::fake();

        new ObservableModel;

        $this->assertFalse(
            $events->hasListeners('eloquent.customEventNotRegistered: ' . ObservableModel::class)
        );
    }
}
