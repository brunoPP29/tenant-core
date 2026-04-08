<?php

namespace App\Services;

use App\Models\CompanyModule;
use App\Models\Gallery;

class GalleryService
{
    
    public function isGalleryActive($module_id)
    {
        if (!is_numeric($module_id)) {
            return false;
        }

        $haveModel = CompanyModule::where('id', $module_id)
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->firstOrFail();

        return $haveModel->user_id;
    }

    public function uploadPhoto(array $data)
    {
        $file = $data['photo'];
        $path = $file->store('galleries/user_' . $data['user_id'], 'public');

        return \App\Models\Gallery::create([
            'user_id'     => $data['user_id'],
            'path'        => $path,
            'title'       => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'alt_text'    => $data['alt_text'] ?? null,
            'mime_type'   => $file->getClientMimeType(),
            'size'        => $file->getSize(),
        ]);
    }

    public function updatePhoto(string $id, array $data)
    {
        $photo = Gallery::where('user_id', auth()->id())->findOrFail($id);

        if (isset($data['photo'])) {
            // Delete old file
            if (\Storage::disk('public')->exists($photo->path)) {
                \Storage::disk('public')->delete($photo->path);
            }

            $file = $data['photo'];
            $path = $file->store('galleries/user_' . $photo->user_id, 'public');
            $photo->path = $path;
            $photo->mime_type = $file->getClientMimeType();
            $photo->size = $file->getSize();
        }

        $photo->title = array_key_exists('title', $data) ? $data['title'] : $photo->title;
        $photo->description = array_key_exists('description', $data) ? $data['description'] : $photo->description;
        $photo->alt_text = array_key_exists('alt_text', $data) ? $data['alt_text'] : $photo->alt_text;
        $photo->save();

        return $photo;
    }

    public function deletePhoto(string $id)
    {
        $photo = Gallery::where('user_id', auth()->id())->findOrFail($id);

        if (\Storage::disk('public')->exists($photo->path)) {
            \Storage::disk('public')->delete($photo->path);
        }

        return $photo->delete();
    }
}