<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * 商品画像のURLを取得
     */
    public static function getProductImageUrl($product, string $type = 'original'): string
    {
        if (!$product) {
            return self::getDefaultImageUrl();
        }

        // thumbnail_pathが'dummy'の場合、カテゴリ別のランダム画像を返す
        if ($type === 'thumbnail' && $product->thumbnail_path === 'dummy') {
            $category = $product->product->category ?? 1;
            return self::getRandomCategoryImage($category);
        }

        if ($type === 'thumbnail' && $product->thumbnail_path) {
            return Storage::url($product->thumbnail_path);
        }

        // file_pathが'dummy'の場合、カテゴリ別のランダム画像を返す
        if ($product->file_path === 'dummy') {
            $category = $product->product->category ?? 1;
            return self::getRandomCategoryImage($category);
        }

        if ($product->file_path) {
            return Storage::url($product->file_path);
        }

        return self::getDefaultImageUrl();
    }

    /**
     * 商品のメイン画像URLを取得
     */
    public static function getProductMainImageUrl($product): string
    {
        if (!$product) {
            return self::getDefaultImageUrl();
        }

        // カバー画像がある場合はカバー画像を返す
        if ($product->coverImage) {
            return self::getProductImageUrl($product->coverImage, 'original');
        }

        // 最初の画像を返す
        if ($product->images && $product->images->count() > 0) {
            return self::getProductImageUrl($product->images->first(), 'original');
        }

        // cover_image_idがnullの場合は指定された画像を返す
        if ($product->cover_image_id === null) {
            return asset('images/products/20200501_noimage.jpg');
        }

        // 画像がない場合はカテゴリ別のランダム画像を返す
        return self::getRandomCategoryImage($product->category ?? 1);
    }

    /**
     * 商品のサムネイル画像URLを取得
     */
    public static function getProductThumbnailUrl($product): string
    {
        if (!$product) {
            return self::getDefaultThumbnailUrl();
        }

        // カバー画像がある場合はカバー画像のサムネイルを返す
        if ($product->coverImage) {
            return self::getProductImageUrl($product->coverImage, 'thumbnail');
        }

        // 最初の画像のサムネイルを返す
        if ($product->images && $product->images->count() > 0) {
            return self::getProductImageUrl($product->images->first(), 'thumbnail');
        }

        // cover_image_idがnullの場合は指定された画像を返す
        if ($product->cover_image_id === null) {
            return asset('images/products/20200501_noimage.jpg');
        }

        // 画像がない場合はカテゴリ別のランダム画像を返す
        return self::getRandomCategoryImage($product->category ?? 1);
    }

    /**
     * デフォルト画像URLを取得
     */
    public static function getDefaultImageUrl(): string
    {
        return asset('images/no-image.png');
    }

    /**
     * デフォルトサムネイルURLを取得
     */
    public static function getDefaultThumbnailUrl(): string
    {
        return asset('images/no-image-thumbnail.png');
    }

    /**
     * 画像パスを生成
     */
    public static function generateImagePath(string $directory, string $filename): string
    {
        return $directory . '/' . date('Y/m/d/') . $filename;
    }

    /**
     * 画像ファイル名を生成
     */
    public static function generateImageFilename(string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid() . '_' . time() . '.' . $extension;
    }

    /**
     * 画像サイズを取得
     */
    public static function getImageSize(string $path): array
    {
        if (!Storage::exists($path)) {
            return [0, 0];
        }

        $fullPath = Storage::path($path);
        if (!file_exists($fullPath)) {
            return [0, 0];
        }

        $imageInfo = getimagesize($fullPath);
        return $imageInfo ? [$imageInfo[0], $imageInfo[1]] : [0, 0];
    }

    /**
     * 画像のMIMEタイプを取得
     */
    public static function getImageMimeType(string $path): string
    {
        if (!Storage::exists($path)) {
            return 'image/png';
        }

        $fullPath = Storage::path($path);
        if (!file_exists($fullPath)) {
            return 'image/png';
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fullPath);
        finfo_close($finfo);

        return $mimeType ?: 'image/png';
    }

    /**
     * 画像が有効かチェック
     */
    public static function isValidImage($file): bool
    {
        if (!$file || !$file->isValid()) {
            return false;
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($file->getMimeType(), $allowedMimes);
    }

    /**
     * 画像サイズを検証
     */
    public static function validateImageSize($file, int $maxSize = 5242880): bool
    {
        return $file->getSize() <= $maxSize;
    }

        /**
     * カテゴリ別のランダム画像を取得
     */
    public static function getRandomCategoryImage(int $category): string
    {
        $categoryFolders = [
            1 => 'toys',      // おもちゃ
            2 => 'sports',    // スポーツ
            3 => 'furniture', // 家具
            4 => 'books',     // 書籍
            5 => 'beauty',    // 美容
            6 => 'clothing',  // 衣類
            7 => 'electronics', // 電子機器
            8 => 'food'       // 食品
        ];

        $folderName = $categoryFolders[$category] ?? 'toys';
        $imagePath = public_path("images/products/{$folderName}");

        // フォルダが存在しない場合はデフォルト画像を返す
        if (!is_dir($imagePath)) {
            return self::getDefaultImageUrl();
        }

        // 画像ファイルを取得
        $imageFiles = glob($imagePath . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

        if (empty($imageFiles)) {
            return self::getDefaultImageUrl();
        }

        // ランダムに画像を選択
        $randomImage = $imageFiles[array_rand($imageFiles)];

        // ファイル名のみを取得
        $fileName = basename($randomImage);

        // 正しいURLパスを生成
        return asset("images/products/{$folderName}/{$fileName}");
    }
}
