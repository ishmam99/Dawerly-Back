<?php

namespace App\Filament\Resources\TechnicianResource\Pages;

use App\Filament\Resources\TechnicianResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTechnician extends CreateRecord
{
    protected static string $resource = TechnicianResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt('password'),
            'role' => 'technician',
        ]);

        $data['user_id']   = $user->id;
        return $data;
    }
}
