<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(isset($this['0'])){
            return [
                'status' => $this['status'],
                'profile_photo_url' => $this['profile_photo_url'],
                'name' => $this['name'],
                'message' => $this['message'],
                'scan_time' => $this['scan_time'],
                'gate_name' => $this['0']['name']
            ];
        }
        return [
            'status' => $this['status'],
            'profile_photo_url' => $this['profile_photo_url'],
            'name' => $this['name'],
            'message' => $this['message'],
            'scan_time' => $this['scan_time'],
            'gate_name' => 'Deleted gate'
        ];
    }
}
