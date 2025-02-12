<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'    => $this->name,
            'phone'    => $this->phone,
            'about'    => $this->about,
            'address'    => $this->address,
            'image'    => setImage($this->image),
             'province'    => $this->province,
             'category'    => $this->category,
             'sub_categories'    => $this->subCategories
        ];
    }
}
