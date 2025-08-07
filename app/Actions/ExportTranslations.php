<?php

namespace App\Actions;

use App\Models\Translation;
use Lorisleiva\Actions\Concerns\AsAction;

class ExportTranslations
{
    use AsAction;

    public function handle($lang = null)
    {
        $lang         = $lang ?: app()->getLocale();
        $translations = Translation::where('lang', $lang)->pluck('content', 'key');

        return response()->json($translations);
    }
}
