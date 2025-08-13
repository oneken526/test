<?php

namespace App\Constants;

class ProductConsts
{
    // 商品コード
    public const PRODUCT_CODE_LENGTH = 8;
    public const PRODUCT_CODE_PREFIX = 'PRD';

    // 在庫管理
    public const LOW_STOCK_THRESHOLD = 10;
    public const OUT_OF_STOCK_THRESHOLD = 0;

    // 価格
    public const MIN_PRICE = 1;
    public const MAX_PRICE = 9999999;

    // 商品画像
    public const MAX_IMAGES_PER_PRODUCT = 10;
    public const MAIN_IMAGE_INDEX = 0;

    // カテゴリ
    public const MAX_CATEGORY_DEPTH = 3;
    public const MAX_CATEGORIES_PER_PRODUCT = 5;

    // レビュー
    public const MIN_REVIEW_RATING = 1;
    public const MAX_REVIEW_RATING = 5;
    public const REVIEW_COMMENT_MAX_LENGTH = 1000;

    // 商品名
    public const NAME_MIN_LENGTH = 2;
    public const NAME_MAX_LENGTH = 200;

    // 商品説明
    public const DESCRIPTION_MIN_LENGTH = 10;
    public const DESCRIPTION_MAX_LENGTH = 5000;

    // SKU
    public const SKU_MIN_LENGTH = 3;
    public const SKU_MAX_LENGTH = 50;

    // 重量・サイズ
    public const MIN_WEIGHT = 0.01;
    public const MAX_WEIGHT = 1000.00;
    public const MIN_DIMENSIONS = 0.1;
    public const MAX_DIMENSIONS = 1000.0;

    // 検索関連
    public const SEARCH_MIN_LENGTH = 2;
    public const SEARCH_MAX_RESULTS = 100;

    // 表示関連
    public const FEATURED_PRODUCTS_LIMIT = 8;
    public const NEW_PRODUCTS_LIMIT = 12;
    public const RELATED_PRODUCTS_LIMIT = 6;

    // キャッシュ
    public const CACHE_TAG = 'products';
    public const CACHE_DURATION = 3600; // 1時間

    // ファイル関連
    public const ALLOWED_IMAGE_TYPES = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    public const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
    public const THUMBNAIL_QUALITY = 80;

    // 商品ステータス
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_OUT_OF_STOCK = 'out_of_stock';

    // 商品タイプ
    public const TYPE_PHYSICAL = 'physical';
    public const TYPE_DIGITAL = 'digital';
    public const TYPE_SERVICE = 'service';

    // 配送関連
    public const FREE_SHIPPING_THRESHOLD = 5000;
    public const DEFAULT_SHIPPING_FEE = 800;
    public const EXPRESS_SHIPPING_FEE = 1200;
}
