<?php

namespace App\Presenters;

use App\Transformers\BookingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BookingPresenter.
 *
 * @package namespace App\Presenters;
 */
class BookingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BookingTransformer();
    }
}
