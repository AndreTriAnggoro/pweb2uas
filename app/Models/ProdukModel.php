<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'produk_id';
    protected $allowedFields = [
        'nama',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'kategori',
        'image',
        'rating'
    ];

    // public function getProductsWithImage()
    // {
    //     return $this->select('products.*, product_images.image_url')
    //         ->join('product_images', 'product_images.product_id = products.product_id AND product_images.is_primary = 1', 'left')
    //         ->where('products.status', 'active')
    //         ->orderBy('products.created_at', 'DESC')
    //         ->findAll();
    // }

    // public function getImages($productId)
    // {
    //     return $this->db->table('product_images')
    //         ->where('product_id', $productId)
    //         ->orderBy('is_primary', 'DESC')
    //         ->get()
    //         ->getResultArray();
    // }

    // public function getRelatedProducts($categoryId, $currentProductId)
    // {
    //     return $this->select("
    //             products.*, 
    //             product_images.image_url,
    //             (SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.product_id) AS avg_rating,
    //             (SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.product_id) AS review_count
    //         ")
    //         ->join(
    //             'product_images',
    //             'product_images.product_id = products.product_id 
    //             AND product_images.is_primary = 1',
    //             'left'
    //         )
    //         ->where('products.category_id', $categoryId)
    //         ->where('products.product_id !=', $currentProductId)
    //         ->where('products.status', 'active')
    //         ->limit(4)
    //         ->findAll();
    // }



}
