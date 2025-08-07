<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class TranslationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_translations()
    {
        File::put(resource_path('lang/en/messages.php'), "<?php return ['hello' => 'Hello'];");

        $this->actingAsUser()
            ->getJson('/api/translations?lang=en')
            ->assertStatus(200)
            ->assertJsonFragment(['hello' => 'Hello']);
    }

    public function test_can_add_translation()
    {
        $this->actingAsUser()
            ->postJson('/api/translations', [
                'lang'    => 'en',
                'key'     => 'greeting',
                'content' => 'Hello world'
            ])
            ->assertStatus(200);

        $data = include resource_path('lang/en/messages.php');
        $this->assertArrayHasKey('greeting', $data);
    }

    public function test_can_export_translations()
    {
        File::put(resource_path('lang/ar/messages.php'), "<?php return ['bye' => 'Au revoir'];");

        $this->actingAsUser()
            ->getJson('/api/translations/export/ar')
            ->assertStatus(200)
            ->assertJsonFragment(['bye' => 'Au revoir']);
    }

    protected function actingAsUser()
    {
        $user = \App\Models\User::factory()->create();

        return $this->actingAs($user, 'sanctum');
    }
}
