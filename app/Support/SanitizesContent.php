<?php

namespace App\Support;

trait SanitizesContent
{
    /**
     * Strip base64-embedded images and Word/Office junk from rich text content
     * to prevent oversized DB writes (MySQL max_allowed_packet).
     *
     * Usage in a controller: $clean = $this->sanitizeContent($request->content);
     *
     * @param  string|null  $content  Raw HTML from the editor
     */
    protected function sanitizeContent(?string $content): string
    {
        if (empty($content)) {
            return '';
        }

        // Strip base64-embedded images (Word paste can embed multi-MB images)
        $content = preg_replace(
            '/<img[^>]+src\s*=\s*["\']data:image\/[^"\']*["\'][^>]*>/i',
            '',
            $content
        );

        // Strip MS Office XML namespace tags: <o:p>, </o:p>, <v:shape>, etc.
        $content = preg_replace('/<\/?\w+:[^>]*>/i', '', $content);

        // Strip MS Office conditional comments
        $content = preg_replace('/<!--\[if[^>]*>[\s\S]*?<!\[endif\]-->/i', '', $content);

        // Strip <style> blocks injected by Word
        $content = preg_replace('/<style[\s\S]*?<\/style>/i', '', $content);

        return $content;
    }

    /**
     * Sanitize one or more content fields on a Request before saving.
     *
     * Usage: $this->sanitizeRequestContent($request, ['content']);
     *        $this->sanitizeRequestContent($request, ['misi', 'visi', 'sejarah']);
     *
     * @param  array<string>  $fields  Field names that hold rich text HTML
     */
    protected function sanitizeRequestContent(\Illuminate\Http\Request $request, array $fields): void
    {
        $merged = [];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $merged[$field] = $this->sanitizeContent($request->input($field));
            }
        }

        if (! empty($merged)) {
            $request->merge($merged);
        }
    }
}
