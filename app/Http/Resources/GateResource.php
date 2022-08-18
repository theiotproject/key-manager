<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GateResource extends JsonResource
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
            'serial_number' => $this['serial_number'],
            'name' => $this['name'],
            'team_id' => $this['team_id'],
            'updated_at' =>$this['updated_at'],
            'created_at' => $this['created_at']
        ];
    }
}
