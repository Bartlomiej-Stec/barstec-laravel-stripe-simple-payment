<?php

namespace Barstec\Stripe\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StripeNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.object.id' => ['required', 'exists:' . config('stripe.table_name') . ',order_id']
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        abort(403);
    }
}
