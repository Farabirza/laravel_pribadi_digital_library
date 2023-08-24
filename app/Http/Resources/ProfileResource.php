<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date,
            'role' => $this->role,
            'grade' => $this->grade,
            'year_join' => $this->year_join,
            'address_street' => $this->address_street,
            'address_city' => $this->address_city,
            'address_zip' => $this->address_zip,
            'languange' => $this->languange,
            'interest' => $this->interest,
            'biodata' => $this->biodata,
            'email' => $this->email,
        ];
    }
}
