<?php

namespace App\Serializer;

use League\Fractal\Serializer\ArraySerializer;

class ApiSerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $resourceKey ? [$resourceKey => $data] : $data;
        // return ($resourceKey && $resourceKey !== 'data') ? [$resourceKey => $data] : $data;
        // return $data;
    }

    public function item($resourceKey, array $data)
    {
        // return $resourceKey ? [$resourceKey => $data] : $data;
        // return ($resourceKey && $resourceKey !== 'data') ? [$resourceKey => $data] : $data;
        return $data;
    }
}
