<?php

namespace App\Models\Concerns;

use App\Models\Lampiran;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;

trait HasLampiran
{
    public function lampirans(): MorphMany
    {
        return $this->morphMany(Lampiran::class, 'lampirable');
    }

    public function simpanLampiran(UploadedFile $file, string $folder = 'lampiran', ?string $keterangan = null): Lampiran
    {
        $path = $file->store($folder, 'public');

        return $this->lampirans()->create([
            'path' => $path,
            'nama_asli' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'ukuran' => $file->getSize(),
            'keterangan' => $keterangan,
        ]);
    }
}
