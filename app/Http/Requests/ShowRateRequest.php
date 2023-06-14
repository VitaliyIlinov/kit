<?php

namespace App\Http\Requests;

use App\Models\Symbol;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class ShowRateRequest extends FormRequest
{
    private Collection $symbols;

    protected function prepareForValidation(): void
    {
        $this->merge([
            'from' => (int)$this->route('send_currency'),
            'to' => (int)$this->route('receive_currency'),
        ]);
        $this->symbols = Symbol::pluck('code', 'symbol');
    }

    public function rules(): array
    {
        return [
            'from' => ['required', Rule::in($this->symbols)],
            'to' => [Rule::in($this->symbols)],
        ];
    }
}
