<?php

namespace App\Services;

use App\Models\CompanyModule;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
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

    public function createProduct(array $data)
    {
        $path = null;
        if (isset($data['image'])) {
            $path = $data['image']->store('products/user_' . $data['user_id'], 'public');
        }

        return Product::create([
            'user_id'     => $data['user_id'],
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'] ?? null,
            'image_path'  => $path,
        ]);
    }

    public function updateProduct(string $id, array $data)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);

        if (isset($data['image'])) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $data['image']->store('products/user_' . $product->user_id, 'public');
        }

        $product->name = $data['name'] ?? $product->name;
        $product->description = array_key_exists('description', $data) ? $data['description'] : $product->description;
        $product->price = array_key_exists('price', $data) ? $data['price'] : $product->price;
        $product->save();

        return $product;
    }

    public function deleteProduct(string $id)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);

        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        return $product->delete();
    }
}
