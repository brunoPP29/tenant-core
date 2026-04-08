<?php

namespace App\Services;

use App\Models\CompanyModule;
use App\Models\Link;

class LinkService
{
    public function isModuleActive($module_id)
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

    public function createLink(array $data)
    {
        return Link::create([
            'user_id' => $data['user_id'],
            'title'   => $data['title'],
            'url'     => $data['url'],
            'icon'    => $data['icon'] ?? null,
            'order'   => $data['order'] ?? 0,
        ]);
    }

    public function updateLink(string $id, array $data)
    {
        $link = Link::where('user_id', auth()->id())->findOrFail($id);

        $link->title = $data['title'] ?? $link->title;
        $link->url   = $data['url'] ?? $link->url;
        $link->icon  = array_key_exists('icon', $data) ? $data['icon'] : $link->icon;
        $link->order = array_key_exists('order', $data) ? $data['order'] : $link->order;
        $link->save();

        return $link;
    }

    public function deleteLink(string $id)
    {
        $link = Link::where('user_id', auth()->id())->findOrFail($id);
        return $link->delete();
    }
}
