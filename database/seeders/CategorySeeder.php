<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ["Electricity, air conditioning and elevators", "electricity.svg"],
            ["Water and sanitation treatment", "water-hand.svg"],
            ["Dyes and decorations", "hair-dye.svg"],
            ["Construction and renovations", "renovation-home.svg"],
            ["Pest control and cleaning", "material-symbols-light_pest-control.svg"],
            ["Car maintenance and transportation", "car.svg"],
            ["Electronics, printing and photography", "printer.svg"],
            ["Cosmetology", "facial-treatment.svg"],
            ["Furniture and furnishings", "furniture.svg"],
            ["Blacksmithing, aluminum and carpentry", "blacksmith.svg"],
            ["Weddings and events", "wedding.svg"],
            ["Livestock and animals", "livestock.svg"],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category[0],
                'slug' => Str::slug($category[0]), // Generates a URL-friendly slug
                'image' => $category[1],
            ]);
        }
    }
}
