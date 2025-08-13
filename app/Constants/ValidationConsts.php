<?php

namespace App\Constants;

class ValidationConsts
{
    // 文字列長制限
    public const NAME_MIN_LENGTH = 2;
    public const NAME_MAX_LENGTH = 100;
    public const EMAIL_MAX_LENGTH = 255;
    public const PASSWORD_MIN_LENGTH = 8;
    public const PASSWORD_MAX_LENGTH = 255;
    public const DESCRIPTION_MAX_LENGTH = 2000;
    public const TITLE_MIN_LENGTH = 2;
    public const TITLE_MAX_LENGTH = 200;
    public const COMMENT_MAX_LENGTH = 1000;

    // 電話番号パターン
    public const PHONE_PATTERN = '/^0\d{9,10}$/';
    public const MOBILE_PHONE_PATTERN = '/^0[789]0-\d{4}-\d{4}$/';
    public const PHONE_PATTERN_STRICT = '/^0[789]0-\d{4}-\d{4}$/';

    // 郵便番号パターン
    public const POSTAL_CODE_PATTERN = '/^\d{3}-\d{4}$/';
    public const POSTAL_CODE_PATTERN_STRICT = '/^\d{3}-\d{4}$/';

    // ファイル形式
    public const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    public const ALLOWED_DOCUMENT_EXTENSIONS = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    public const ALLOWED_VIDEO_EXTENSIONS = ['mp4', 'avi', 'mov', 'wmv'];

    // ファイルサイズ制限（バイト）
    public const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
    public const MAX_DOCUMENT_SIZE = 10 * 1024 * 1024; // 10MB
    public const MAX_VIDEO_SIZE = 100 * 1024 * 1024; // 100MB

    // 価格制限
    public const MIN_PRICE = 1;
    public const MAX_PRICE = 9999999;

    // 数量制限
    public const MIN_QUANTITY = 1;
    public const MAX_QUANTITY = 999;

    // 在庫制限
    public const MIN_STOCK = 0;
    public const MAX_STOCK = 99999;

    // パスワード要件
    public const PASSWORD_REQUIRES_UPPERCASE = true;
    public const PASSWORD_REQUIRES_LOWERCASE = true;
    public const PASSWORD_REQUIRES_NUMBERS = true;
    public const PASSWORD_REQUIRES_SYMBOLS = false;

    // ユーザー名制限
    public const USERNAME_MIN_LENGTH = 3;
    public const USERNAME_MAX_LENGTH = 50;
    public const USERNAME_PATTERN = '/^[a-zA-Z0-9_-]+$/';

    // URL制限
    public const URL_MAX_LENGTH = 2048;
    public const URL_PATTERN = '/^https?:\/\/.+/';

    // 日付制限
    public const MIN_DATE = '1900-01-01';
    public const MAX_DATE = '2100-12-31';

    // 検索制限
    public const SEARCH_MIN_LENGTH = 2;
    public const SEARCH_MAX_LENGTH = 100;

    // カテゴリ制限
    public const CATEGORY_MIN_LENGTH = 2;
    public const CATEGORY_MAX_LENGTH = 50;
    public const MAX_CATEGORIES = 10;

    // タグ制限
    public const TAG_MIN_LENGTH = 2;
    public const TAG_MAX_LENGTH = 30;
    public const MAX_TAGS = 20;

    // レビュー制限
    public const REVIEW_MIN_LENGTH = 10;
    public const REVIEW_MAX_LENGTH = 1000;
    public const MIN_RATING = 1;
    public const MAX_RATING = 5;

    // 住所制限
    public const ADDRESS_MIN_LENGTH = 10;
    public const ADDRESS_MAX_LENGTH = 500;

    // 会社名制限
    public const COMPANY_NAME_MIN_LENGTH = 2;
    public const COMPANY_NAME_MAX_LENGTH = 200;

    // 店舗名制限
    public const SHOP_NAME_MIN_LENGTH = 2;
    public const SHOP_NAME_MAX_LENGTH = 100;

    // SKU制限
    public const SKU_MIN_LENGTH = 3;
    public const SKU_MAX_LENGTH = 50;
    public const SKU_PATTERN = '/^[A-Z0-9_-]+$/';

    // 商品コード制限
    public const PRODUCT_CODE_MIN_LENGTH = 5;
    public const PRODUCT_CODE_MAX_LENGTH = 20;
    public const PRODUCT_CODE_PATTERN = '/^[A-Z0-9]+$/';

    // 注文番号制限
    public const ORDER_NUMBER_MIN_LENGTH = 8;
    public const ORDER_NUMBER_MAX_LENGTH = 20;
    public const ORDER_NUMBER_PATTERN = '/^[A-Z0-9]+$/';

    // メモ制限
    public const NOTES_MAX_LENGTH = 1000;
}
