<?php

namespace Database\Seeders;

use App\Models\Assistant;
use App\Models\Lawyer;
use Illuminate\Database\Seeder;

class AssistantLawyerSeeder extends Seeder
{
    public function run(): void
    {
        $assistants = Assistant::all();
        $lawyers = Lawyer::all();

        foreach ($assistants as $assistant) {
            $assistant->lawyers()->sync(
                $lawyers->random(rand(1, 4))->pluck('id')->toArray()
            );
        }
    }
}
