<?php

namespace App\Http\Requests\Export;

use Illuminate\Foundation\Http\FormRequest;

class FinancialReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->user()->can('export_financial-reports');
    }

    public function rules(): array
    {
        return [];
    }
}
