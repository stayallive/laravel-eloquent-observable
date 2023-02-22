<?php

namespace Tests\StubClasses;

use Illuminate\Database\Eloquent\Model;
use Stayallive\Laravel\Eloquent\Observable\Observable;

/**
 * @property string|null $id
 * @property string|null $other_id
 * @property string      $name
 */
class ObservableModel extends Model
{
    use Observable, TraitWithEvents;

    public $timestamps = false;

    protected $table = 'tests';

    protected static $unguarded = true;

    protected $observables = ['customEvent', 'customEventNotRegistered'];

    public array $eventsDisptached = [];

    public static function onRetrieved(self $model): void
    {
        $model->eventsDisptached['retrieved'] = true;
    }
    public static function onCreating(self $model): void
    {
        $model->eventsDisptached['creating'] = true;
    }
    public static function onCreated(self $model): void
    {
        $model->eventsDisptached['created'] = true;
    }
    public static function onUpdating(self $model): void
    {
        $model->eventsDisptached['updating'] = true;
    }
    public static function onUpdated(self $model): void
    {
        $model->eventsDisptached['updated'] = true;
    }
    public static function onSaving(self $model): void
    {
        $model->eventsDisptached['saving'] = true;
    }
    public static function onSaved(self $model): void
    {
        $model->eventsDisptached['saved'] = true;
    }
    public static function onRestoring(self $model): void
    {
        $model->eventsDisptached['restoring'] = true;
    }
    public static function onRestored(self $model): void
    {
        $model->eventsDisptached['restored'] = true;
    }
    public static function onReplicating(self $model): void
    {
        $model->eventsDisptached['replicating'] = true;
    }
    public static function onDeleting(self $model): void
    {
        $model->eventsDisptached['deleting'] = true;
    }
    public static function onDeleted(self $model): void
    {
        $model->eventsDisptached['deleted'] = true;
    }
    public static function onForceDeleting(self $model): void
    {
        $model->eventsDisptached['onForceDeleting'] = true;
    }
    public static function onForceDeleted(self $model): void
    {
        $model->eventsDisptached['forceDeleted'] = true;
    }
    public static function onCustomEvent(self $model): void
    {
        $model->eventsDisptached['customEvent'] = true;
    }
    public static function onTraitEvent(self $model): void
    {
        $model->eventsDisptached['traitEvent'] = true;
    }
}
