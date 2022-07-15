<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VirtualKeyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
