<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    protected $defaultImagePath = 'images/editor/';

    /**
     * Upload an image from the rich text editor.
     * Centralized endpoint used by all modules.
     *
     * Pass ?folder=artikel to store in images/artikel/ instead of the default.
     * Only alphanumeric folder names are accepted to prevent path traversal.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'folder' => 'nullable|string|alpha_dash|max:50',
        ]);

        $imagePath = $this->resolveImagePath($request->input('folder'));

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = 'ed_'.time().'_'.\Str::random(8).'.'.$extension;
        $path = public_path($imagePath);

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $file->move($path, $filename);

        return response()->json([
            'url' => asset($imagePath.$filename),
        ]);
    }

    /**
     * Resolve the storage path from an optional folder name.
     * Returns e.g. "images/artikel/" or falls back to "images/editor/".
     */
    private function resolveImagePath(?string $folder): string
    {
        if (! empty($folder)) {
            return 'images/'.rtrim($folder, '/').'/';
        }

        return $this->defaultImagePath;
    }

    /**
     * Remove editor images that are no longer referenced in any rich text content.
     * Scans the default folder plus all module folders that have editor images.
     * Only touches files with the "ed_" prefix — never cover images or other assets.
     */
    public function cleanupImages(): JsonResponse
    {
        $allContent = $this->collectAllRichContent();
        $deleted = 0;

        foreach ($this->getEditorImageFolders() as $folderPath) {
            $fullPath = public_path($folderPath);

            if (! is_dir($fullPath)) {
                continue;
            }

            foreach (\File::files($fullPath) as $file) {
                $filename = $file->getFilename();

                // Only clean up editor-uploaded files (ed_ prefix)
                if (! str_starts_with($filename, 'ed_')) {
                    continue;
                }

                if (strpos($allContent, $filename) === false) {
                    \File::delete($file->getPathname());
                    $deleted++;
                }
            }
        }

        return response()->json([
            'deleted' => $deleted,
            'message' => $deleted.' gambar yang tidak digunakan berhasil dihapus',
        ]);
    }

    /**
     * All folders where editor images may live.
     * Add new folders here when a module uses a custom image-folder.
     *
     * @return array<string>
     */
    private function getEditorImageFolders(): array
    {
        return [
            'images/editor/',
            'images/artikel/',
            'images/artikelSimo/',
        ];
    }

    /**
     * Collect all rich-text HTML content from every model/column that uses the editor.
     * Add new entries here when a new module starts using the editor.
     *
     * @return array<array{model: class-string, columns: array<string>}>
     */
    private function getContentSources(): array
    {
        return [
            ['model' => \App\Models\Artikel::class, 'columns' => ['content']],
            ['model' => \App\Models\ArtikelSimo::class, 'columns' => ['content', 'ringkasan']],
            ['model' => \App\Models\Cu::class, 'columns' => ['misi', 'visi', 'nilai', 'sejarah', 'deskripsi']],
            ['model' => \App\Models\ProdukCu::class, 'columns' => ['keterangan', 'aturan_setor', 'aturan_tarik', 'aturan_balas_jasa', 'aturan_lain']],
        ];
    }

    /**
     * Concatenate all rich-text content from every registered source.
     */
    private function collectAllRichContent(): string
    {
        $allContent = '';

        foreach ($this->getContentSources() as $source) {
            try {
                $query = $source['model']::query();

                foreach ($source['columns'] as $column) {
                    $values = (clone $query)
                        ->whereNotNull($column)
                        ->where($column, '!=', '')
                        ->pluck($column)
                        ->implode(' ');

                    $allContent .= ' '.$values;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $allContent;
    }
}
