<?php

namespace App\Support;

use File;

trait CleansEditorImages
{
    /**
     * Delete editor-uploaded images (ed_* prefix) that were present in the old
     * content but are no longer referenced in the new content.
     *
     * @param  string|null  $oldContent  HTML content before the update
     * @param  string|null  $newContent  HTML content after the update
     * @param  string  $folder  Folder name under public/images/ (e.g. "artikel")
     * @return int Number of files deleted
     */
    protected function cleanupRemovedEditorImages(?string $oldContent, ?string $newContent, string $folder): int
    {
        $oldImages = $this->extractEditorImages($oldContent, $folder);
        $newImages = $this->extractEditorImages($newContent, $folder);

        $removed = array_diff($oldImages, $newImages);
        $deleted = 0;

        foreach ($removed as $filename) {
            $path = public_path('images/'.$folder.'/'.$filename);
            if (File::exists($path)) {
                File::delete($path);
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Delete all editor-uploaded images referenced in the given content.
     * Use when destroying a record entirely.
     *
     * @param  string|null  $content  HTML content
     * @param  string  $folder  Folder name under public/images/
     * @return int Number of files deleted
     */
    protected function deleteAllEditorImages(?string $content, string $folder): int
    {
        $images = $this->extractEditorImages($content, $folder);
        $deleted = 0;

        foreach ($images as $filename) {
            $path = public_path('images/'.$folder.'/'.$filename);
            if (File::exists($path)) {
                File::delete($path);
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Extract ed_* filenames from HTML content for a given image folder.
     *
     * @return array<string>
     */
    private function extractEditorImages(?string $content, string $folder): array
    {
        if (empty($content)) {
            return [];
        }

        $pattern = '/\/images\/'.preg_quote($folder, '/').'\/(ed_[^"\'\s]+)/i';
        preg_match_all($pattern, $content, $matches);

        return array_unique($matches[1] ?? []);
    }
}
