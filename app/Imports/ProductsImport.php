<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Kiểm tra category_id tồn tại
        $category = Category::find($row['category_id']);
        if (!$category) {
            return null; // Bỏ qua nếu danh mục không tồn tại
        }

        // Tạo slug duy nhất
        $slug = Str::slug($row['name']);
        $count = 1;
        $originalSlug = $slug;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return new Product([
            'name' => $row['name'],
            'price' => $row['price'],
            'discount_price' => $row['discount_price'] ?? null,
            'quantity' => $row['quantity'],
            'slug' => $slug,
            'category_id' => $row['category_id'],
            'description' => $row['description'],
        ]);
    }
}
