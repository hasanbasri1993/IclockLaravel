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

    protected array $pollingOptions = [
        '5s' => 'Every 5 seconds',
        '' => 'None',
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

            SelectColumn::make(__('Status'), 'status1')
                ->options([
                    '0' => '0 (Masuk)',
                    '1' => '1 (Pulang)',
                ])
                ->sortable()
                ->searchable(),

            DateColumn::make('Waktu', 'timestamp')
                ->sortable()
                ->format('F jS, Y h:i A'),
        ];
    }

    protected function filters(): array
    {
        return [

            //            SelectFilter::make(__('Category'), 'category_id')
            //                ->options(
            //                    Category::query()->get()->pluck('title', 'id')->toArray()
            //                ),
            //
            //            SelectFilter::make(__('Author'), 'author_id')
            //                ->options(
            //                    User::query()->get()->pluck('name', 'id')->toArray()
            //                ),

            DateFilter::make('Waktu', 'timestamp'),
        ];
    }

    protected function actions(): array
    {
        return [

        ];
    }
}
