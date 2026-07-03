<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

abstract class UserScopedSeeder extends Seeder
{
    /**
     * @return Collection<int, User>
     */
    protected function users(): Collection
    {
        $users = User::query()->orderBy('id')->get();

        if ($users->isEmpty()) {
            $users = collect([
                User::factory()->create([
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                ]),
            ]);
        }

        return $users;
    }
}
