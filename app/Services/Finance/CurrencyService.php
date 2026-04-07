<?php

namespace App\Services\Finance;

use App\Models\Finance\Currency;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Facades\DataTables;

class CurrencyService
{
    public function getCurrenciesQuery(): Builder
    {
        return Currency::query()->orderBy('sort_order')->orderBy('id');
    }

    public function datatable(Builder $query)
    {
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('code', fn($row) => '<span class="badge badge-primary px-2 py-1 tx-13">' . e($row->code) . '</span>')
            ->addColumn('name', fn($row) => '<strong>' . e($row->name) . '</strong>')
            ->addColumn('exchange_rate', fn($row) => '<span class="text-monospace">' . number_format($row->exchange_rate, 4) . '</span>')
            ->addColumn(
                'is_default',
                fn($row) => $row->is_default
                    ? '<span class="badge badge-success"><i class="las la-check"></i></span>'
                    : '<span class="badge badge-light text-muted">—</span>'
            )
            ->addColumn(
                'status',
                fn($row) => $row->status
                    ? '<span class="badge badge-success">' . trans('admin.global.active') . '</span>'
                    : '<span class="badge badge-danger">' . trans('admin.global.disabled') . '</span>'
            )
            ->addColumn('actions', fn($row) => $this->renderActionsColumn($row))
            ->rawColumns(['code', 'name', 'exchange_rate', 'is_default', 'status', 'actions'])
            ->make(true);
    }

    public function store(array $data): Currency
    {
        return Currency::create($data);
    }

    public function update(Currency $currency, array $data): Currency
    {
        if ($currency->is_default) {
            throw new \Exception(trans('admin.Finance.messages.failed.cannot_edit_default_currency'));
        }

        $currency->update($data);

        return $currency;
    }

    public function deleteCurrency(Currency $currency): bool
    {
        if ($currency->is_default) {
            throw new \Exception(trans('admin.Finance.messages.failed.cannot_delete_default_currency'));
        }

        try {
            return $currency->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                throw new \Exception(trans('admin.Finance.messages.failed.currency_in_use'));
            }
            throw $e;
        }
    }

    private function renderActionsColumn(Currency $currency): string
    {
        return view('admin.Finance.currencies.partials.actions', ['currency' => $currency])->render();
    }
}
