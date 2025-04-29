<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'user_id'    => $this->user_id,
            'status'    => $this->status,
            'name'    => $this->name,
            'phone'    => $this->phone,
            'about'    => $this->about,
            'address'    => $this->address,
            'image'    => setImage($this->image),
             'provinces'    => $this->provinces,
            'provincess'    => $this->provincess,
            'rating'    => $this->reviews()->count() > 0 ? number_format($this->reviews()->sum('rating') / $this->reviews()->count()  , 1) : 0,
                 'reviews'    => $this->reviews,
             'category'    => $this->category,
             'valid_till'   =>Carbon::parse($this->valid_till)->format('Y-m-d'),
             'sub_categories'    => $this->subCategories->load('subCategory')
        ];
    }
}
