<?php

namespace App\Rules;

use App\Models\Pedido;

use Illuminate\Contracts\Validation\Rule;

class MaxPedidosRule implements Rule
{
    public $totalPedidosMax = 3;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($total)
    {
        $this->totalPedidosMax = $total;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cpf = preg_replace('/[^0-9]/', '', $value);
        $count = Pedido::whereIn('situacao_id', [1, 3, 7, 10])->where('cpf', $value)->count();
        return $count > $this->totalPedidosMax;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Você só pode ter  ' . $this->totalPedidosMax . ' pedidos cadastrado!';
    }
}