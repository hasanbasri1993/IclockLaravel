<?php

namespace App\Livewire;

use App\Models\Attendance;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Columns\SelectColumn;
use RamonRietdijk\LivewireTables\Filters\DateFilter;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class AttendedTable extends LivewireTable
{
    protected string $model = Attendance::class;

    protected bool $deferLoading = true;

    protected bool $useSession = true;

    protected array $pollingOptions = [
        '' => 'None',
        '5s' => 'Every 5 seconds',
    ];

    protected function columns(): array
    {
        return [

            Column::make('ID', 'id')
                ->sortable(),

            SelectColumn::make(__('SN'), 'sn')
                ->options(
                    Attendance::query()->distinct()->get()->pluck('sn', 'sn')->toArray()
                )
                ->sortable()
                ->searchable(),

            Column::make('Employee', 'employee_id')
                ->sortable()
                ->searchable(),

            SelectColumn::make(__('Status'), 'checktype')
                ->displayUsing(function (mixed $value): string {
                    return match ($value) {
                        0 => 'Masuk',
                        1 => 'Pulang',
                        4 => 'Masuk Lembur',
                        5 => 'Pulang Lembur',
                        default => 'Unknown',
                    };
                })
                ->options([
                    '0' => '0 (Masuk)',
                    '1' => '1 (Pulang)',
                    '4' => '4 (Masuk Lembur)',
                    '5' => '5 (Pulang Lembur)',
                ])
                ->sortable()
                ->searchable(),

            DateColumn::make('Waktu', 'checktime')
                ->sortable()
                ->format('F jS, Y h:i A'),
        ];
    }

    protected function filters(): array
    {
        return [
            DateFilter::make('Waktu', 'timestamp'),
        ];
    }

    protected function actions(): array
    {
        return [

        ];
    }
}
