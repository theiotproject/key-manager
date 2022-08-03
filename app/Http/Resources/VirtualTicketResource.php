<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mockery\Undefined;

class VirtualTicketResource extends JsonResource
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
            'id' => $this['id'],
            'profile_photo_url' => $this['0']['profile_photo_url'],
            'name' => $this['0']['name'],
            // 'message' => $this['message'],
            'label' => $this['label'],
            'email' => $this['email'],
            'validFrom' => $this['valid_from'],
            'validTo' => $this['valid_to'],
            'gates' => $this['gates']

        ];
    }
}
