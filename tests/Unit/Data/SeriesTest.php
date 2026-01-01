<?php

use BernskioldMedia\LaravelHighcharts\Data\DataPoint;
use BernskioldMedia\LaravelHighcharts\Data\Series;

it('can be created with data', function () {
    $series = Series::make([
        ['name' => 'John', 'y' => 5],
        ['name' => 'Jane', 'y' => 2],
    ]);

    expect($series->data->all())->toBe([
        ['name' => 'John', 'y' => 5],
        ['name' => 'Jane', 'y' => 2],
    ]);
});

it('can be created with data points', function () {
    $dataPoint = DataPoint::make(1.0, 2.0, 'John');

    $series = Series::make([
        $dataPoint,
    ]);

    expect($series->data->all())->toBe([
        $dataPoint,
    ]);
});

it('can enable data labels', function () {
    $series = Series::make()->withDataLabels();

    expect($series->options()['dataLabels']['enabled'])->toBe(true);
});

it('can disable data labels', function () {
    $series = Series::make()->withoutDataLabels();

    expect($series->options()['dataLabels']['enabled'])->toBe(false);
});

it('can set data', function () {
    $series = Series::make()->data([
        ['name' => 'John', 'y' => 5],
        ['name' => 'Jane', 'y' => 2],
    ]);

    expect($series->data->all())->toBe([
        ['name' => 'John', 'y' => 5],
        ['name' => 'Jane', 'y' => 2],
    ]);
});

it('can set the series type', function () {
    $series = Series::make()->type('bar');

    expect($series->type)->toBe('bar');
});

it('can output to an array', function () {
    $series = Series::make()
        ->bar()
        ->data([
            ['name' => 'John', 'y' => 5],
            ['name' => 'Jane', 'y' => 2],
        ]);

    expect($series->toArray())->toBe([
        'data' => [
            ['name' => 'John', 'y' => 5],
            ['name' => 'Jane', 'y' => 2],
        ],
        'type' => 'bar',
    ]);
});

it('can output a series with data points to an array', function () {
    $dataPoint = DataPoint::make(1.0, 2.0, 'John');

    $series = Series::make()
        ->bar()
        ->data([
            $dataPoint,
        ]);

    expect($series->toArray())->toBe([
        'data' => [
            $dataPoint->toArray(),
        ],
        'type' => 'bar',
    ]);
});
