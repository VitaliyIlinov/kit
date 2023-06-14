<?php

namespace App\Http\Requests;

use App\Models\Symbol;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CourseListRequest extends FormRequest
{
    private Collection $symbols;

    protected function prepareForValidation(): void
    {
        $this->symbols = Symbol::pluck('code', 'symbol');
    }

    public function rules(): array
    {
        return [
            'from' => [Rule::in($this->symbols)],
            'to' => [Rule::in($this->symbols)],
        ];
    }
}
