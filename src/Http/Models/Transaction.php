<?php

namespace Barstec\Stripe\Http\Models;

use Barstec\Stripe\Payload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'order_id';

    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    public function createTransaction(Payload $payload, string $transactionId): void
    {
        $input = [
            'order_id' => $transactionId,
            'item_name' => $payload->getName(),
            'description' => $payload->getDescription(),
            'amount' => $payload->getAmount(),
            'currency_code' => $payload->getCurrency(),
            'quantity' => $payload->getQuantity(),
        ];
        $additionalFields = $payload->getAdditionalParams();
        foreach ($additionalFields as $field => $value) {
            if (in_array($field, config('stripe.additional_input_columns'))) {
                if(is_array($value)){
                    $value = implode(", ", $value);   
                }
                $input[str_replace('.', '_', $field)] = $value;
            }
        }
        $this->create($input);
    }

    public function getTable(): string
    {
        return $this->table ?: config('stripe.table_name') ?? parent::getTable();
    }
}
