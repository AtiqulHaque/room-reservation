<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Room;

/**
 * Class RoomTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoomTransformer extends TransformerAbstract
{
    /**
     * Transform the Room entity.
     *
     * @param \App\Models\Room $model
     *
     * @return array
     */
    public function transform(Room $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
