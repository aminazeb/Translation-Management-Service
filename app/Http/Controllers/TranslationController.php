<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $lang         = $request->has('lang') && in_array($request->get('lang'), config('app.locales')) ? $request->get('lang') : app()->getLocale();
        $path         = resource_path("lang/{$lang}/messages.php");
        $translations = include $path;

        return response()->json($translations);
    }

    public function search(Request $request)
    {
        $lang = $request->has('lang') ? $request->get('lang') : app()->getLocale();

        $path = resource_path("lang/{$lang}/messages.php");
        if (!File::exists($path)) {
            return response()->json(['error' => 'Language file not found'], 404);
        }

        $translations = include $path;

        if ($request->filled('key')) {
            $translations = array_filter($translations, fn ($value, $key) => str_contains($key, $request->key), ARRAY_FILTER_USE_BOTH);
        }

        if ($request->filled('content')) {
            $translations = array_filter($translations, fn ($value) => str_contains($value, $request->content));
        }

        return response()->json($translations);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lang'    => 'required|string',
            'key'     => 'required|string',
            'content' => 'required|string',
        ]);

        $langDir  = resource_path("lang/{$data['lang']}");
        $langFile = "{$langDir}/messages.php";

        if (!in_array($data['lang'], config('app.locales'))) {
            $existingValue = implode(',', config('app.locales'));
            $updatedValue  = $existingValue ? $existingValue . ',' . $data['lang'] : $data['lang'];

            file_put_contents(app()->environmentFilePath(), str_replace(
                'APP_LANGUAGES=' . $existingValue,
                'APP_LANGUAGES=' . $updatedValue,
                file_get_contents(app()->environmentFilePath())
            ));
        }

        if (!File::exists($langDir)) {
            File::makeDirectory($langDir, 0755, true);
        }

        if (!File::exists($langFile)) {
            File::put($langFile, "<?php\n\nreturn [\n];\n");
        }

        $translations               = include $langFile;
        $translations[$data['key']] = $data['content'];
        $fileContent                = "<?php\n\nreturn [\n";

        foreach ($translations as $key => $value) {
            $fileContent .= "    '" . addslashes($key) . "' => '" . addslashes($value) . "',\n";
        }

        $fileContent .= "];\n";

        File::put($langFile, $fileContent);

        return response()->json(['message' => 'Translation added/updated']);
    }

    public function export($lang)
    {
        $langFile = resource_path("lang/{$lang}/messages.php");

        if (!File::exists($langFile)) {
            return response()->json(['error' => 'Language not found'], 404);
        }

        $translations = include $langFile;

        return new StreamedResponse(function () use ($translations) {
            echo json_encode(['translations' => $translations]);
        }, 200, ["Content-Type" => "application/json"]);
    }
}
