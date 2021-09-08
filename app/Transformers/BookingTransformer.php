<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Booking;

/**
 * Class BookingTransformer.
 *
 * @package namespace App\Transformers;
 */
class BookingTransformer extends TransformerAbstract
{
    /**
     * Transform the Booking entity.
     *
     * @param \App\Models\Booking $model
     *
     * @return array
     */
    public function transform(Booking $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
