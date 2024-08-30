<?php

namespace BernskioldMedia\LaravelHighcharts\Data;

use BernskioldMedia\LaravelHighcharts\Concerns\ConfiguresChartType;
use BernskioldMedia\LaravelHighcharts\Concerns\ConfiguresTooltip;
use BernskioldMedia\LaravelHighcharts\Concerns\ConvertsArrayToJson;
use BernskioldMedia\LaravelHighcharts\Concerns\Dumpable;
use BernskioldMedia\LaravelHighcharts\Concerns\HasOptions;
use BernskioldMedia\LaravelHighcharts\Concerns\Makeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Tappable;

use function dump;

/**
 * @method static self make(array $data = [])
 */
class Series implements Arrayable, Jsonable
{
    use Conditionable,
        ConfiguresChartType,
        ConfiguresTooltip,
        ConvertsArrayToJson,
        Dumpable,
        HasOptions,
        Makeable,
        Tappable;

    /**
     * @var array<DataPoint|string|array>
     */
    public array $data = [];

    /**
     * @param  array<DataPoint|string|array>  $data
     */
    public function __construct(array $data = [])
    {
        $this->data($data);
    }

    public function withDataLabels(): self
    {
        return $this->set('dataLabels.enabled', true);
    }

    public function withoutDataLabels(): self
    {
        return $this->set('dataLabels.enabled', false);
    }

    public function name(string $name): self
    {
        return $this->set('name', $name);
    }

    public function id(string $id): self
    {
        return $this->set('id', $id);
    }

    /**
     * @param  array<DataPoint|string|array>  $data
     */
    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function toArray(): array
    {
        $series = $this->options;

        if ($this->data) {
            $series['data'] = collect($this->data)
                ->map(fn ($dataPoint) => $dataPoint instanceof DataPoint
                    ? $dataPoint->toArray()
                    : $dataPoint)
                ->toArray();
        }

        if ($this->type) {
            $series['type'] = $this->type;
        }

        return $series;
    }

    public function dump(...$args)
    {
        dump(
            $this->toArray(),
            ...$args,
        );

        return $this;
    }
}
