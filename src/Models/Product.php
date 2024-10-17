<?php

namespace Webkul\InventoryTransfer\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Product\Models\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if ($key == 'pivot') {
            return Model::getAttribute($key);
        }

        return parent::getAttribute($key);
    }
}
