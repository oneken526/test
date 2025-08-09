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

        if ($type === 'thumbnail' && $product->thumbnail_path) {
            return Storage::url($product->thumbnail_path);
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
            return self::getProductImageUrl($product->coverImage);
        }

        // 最初の画像を返す
        if ($product->images && $product->images->count() > 0) {
            return self::getProductImageUrl($product->images->first());
        }

        return self::getDefaultImageUrl();
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

        return self::getDefaultThumbnailUrl();
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
}
