<?php

namespace App\Http\Controllers\Orion;

use App\Models\Translation;
use App\Policies\TranslationPolicy;
use Orion\Http\Controllers\Controller;

class TranslationController extends Controller
{
    protected $model  = Translation::class;
    protected $policy = TranslationPolicy::class;

    public function includes(): array
    {
        return [];
    }

    public function filterableBy(): array
    {
        return ['lang', 'key', 'tag', 'content'];
    }

    public function searchableBy(): array
    {
        return ['lang', 'key', 'content', 'tag'];
    }

    public function sortableBy(): array
    {
        return ['id', 'key'];
    }
}
