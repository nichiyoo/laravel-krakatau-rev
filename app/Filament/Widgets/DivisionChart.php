<?php

namespace App\Filament\Widgets;

use App\Models\Division;
use Filament\Widgets\ChartWidget;

class DivisionChart extends ChartWidget
{
  protected static ?string $heading = 'Division Chart';
  protected int | string | array $columnSpan = 2;
  protected static ?int $sort = 2;

  protected function getOptions(): array
  {
    return [
      'indexAxis' => 'y',
      'elements' => [
        'bar' => [
          'borderWidth' => 0,
        ]
      ],
      'scales' => [
        'y' => [
          'grid' => [
            'display' => false,
          ],
        ],
        'x' => [
          'grid' => [
            'display' => true,
          ]
        ],
      ],
      'plugins' => [
        'legend' => [
          'display' => false,
        ],
      ],
    ];
  }

  protected function getData(): array
  {
    $divisions = Division::withCount('participants')->get();

    $data = (object) [
      'labels' => $divisions->pluck('name')->toArray(),
      'values' => $divisions->pluck('participants_count')->toArray(),
    ];

    return [
      'datasets' => [
        [
          'label' => 'Jumlah Partisipan pada Divisi',
          'data' => $data->values,
          'backgroundColor' => '#f59e0b',
          'borderColor' => '#f59e0b',
        ],
      ],
      'labels' => $data->labels,
    ];
  }


  protected function getType(): string
  {
    return 'bar';
  }
}
