<?php

namespace App\Transformers;

use App\Models\Image;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Image $v)
    {
        $data = [
            'id' => $v->id,
            'name' => $v->name,
            'image' => $v->image,
            'file_image' => empty($v->image) ? null : asset('storage/uploads/images/' . $v->image),
            'file' => $v->file,
            'file_link' => empty($v->file) ? null : asset('storage/uploads/images/' . $v->file),
        ];

        return $data;
    }
}
