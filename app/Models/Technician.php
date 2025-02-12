<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Technician extends Model
{
    /** @use HasFactory<\Database\Factories\TechnicianFactory> */
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get all of the subCategories for the Technician
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function subCategories(): BelongsToMany
    {
        return $this->belongsToMany(SubCategory::class, 'technician_sub_categories','technician_id', 'sub_category_id' );
    }
    /**
     * Get the category that owns the Technician
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Get the province that owns the Technician
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Provinces::class);
    }
}
