<?php

namespace App\Constants;

class SystemConsts
{
    // ページネーション
    public const DEFAULT_PER_PAGE = 20;
    public const MAX_PER_PAGE = 100;
    public const ADMIN_PER_PAGE = 50;

    // ファイルサイズ制限（バイト）
    public const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
    public const MAX_DOCUMENT_SIZE = 10 * 1024 * 1024; // 10MB

    // 画像サイズ
    public const THUMBNAIL_WIDTH = 200;
    public const THUMBNAIL_HEIGHT = 200;
    public const MEDIUM_IMAGE_WIDTH = 600;
    public const MEDIUM_IMAGE_HEIGHT = 600;
    public const LARGE_IMAGE_WIDTH = 1200;
    public const LARGE_IMAGE_HEIGHT = 1200;

    // キャッシュ有効期間（秒）
    public const CACHE_SHORT = 300; // 5分
    public const CACHE_MEDIUM = 3600; // 1時間
    public const CACHE_LONG = 86400; // 24時間
    public const CACHE_VERY_LONG = 604800; // 7日

    // セッション有効期間
    public const SESSION_LIFETIME = 120; // 分

    // API制限
    public const API_RATE_LIMIT = 60; // 1分間のリクエスト数
    public const API_RATE_LIMIT_PREMIUM = 300; // プレミアムユーザー

    // 検索関連
    public const SEARCH_MIN_LENGTH = 2;
    public const SEARCH_MAX_RESULTS = 1000;

    // バックアップ保持期間
    public const BACKUP_RETENTION_DAYS = 30;

    // パスワードポリシー
    public const PASSWORD_MIN_LENGTH = 8;
    public const PASSWORD_MAX_LENGTH = 255;

    // メールアドレス制限
    public const EMAIL_MAX_LENGTH = 255;

    // 名前制限
    public const NAME_MIN_LENGTH = 2;
    public const NAME_MAX_LENGTH = 100;

    // 説明文制限
    public const DESCRIPTION_MAX_LENGTH = 2000;

    // 電話番号パターン
    public const PHONE_PATTERN = '/^0\d{9,10}$/';
    public const MOBILE_PHONE_PATTERN = '/^0[789]0-\d{4}-\d{4}$/';

    // 郵便番号パターン
    public const POSTAL_CODE_PATTERN = '/^\d{3}-\d{4}$/';

    // ファイル形式
    public const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    public const ALLOWED_DOCUMENT_EXTENSIONS = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];

    // 税関連
    public const TAX_RATE = 0.10; // 10%
    public const TAX_RATE_REDUCED = 0.08; // 軽減税率 8%

    // 通貨
    public const CURRENCY = 'JPY';
    public const CURRENCY_SYMBOL = '¥';

    // 日付フォーマット
    public const DATE_FORMAT = 'Y-m-d';
    public const DATETIME_FORMAT = 'Y-m-d H:i:s';
    public const TIME_FORMAT = 'H:i:s';

    // タイムゾーン
    public const TIMEZONE = 'Asia/Tokyo';

    // ログレベル
    public const LOG_LEVEL_DEBUG = 'debug';
    public const LOG_LEVEL_INFO = 'info';
    public const LOG_LEVEL_WARNING = 'warning';
    public const LOG_LEVEL_ERROR = 'error';

    // 通知チャンネル
    public const NOTIFICATION_CHANNEL_EMAIL = 'email';
    public const NOTIFICATION_CHANNEL_SMS = 'sms';
    public const NOTIFICATION_CHANNEL_PUSH = 'push';
    public const NOTIFICATION_CHANNEL_DATABASE = 'database';

    // 通知優先度
    public const NOTIFICATION_PRIORITY_LOW = 1;
    public const NOTIFICATION_PRIORITY_NORMAL = 2;
    public const NOTIFICATION_PRIORITY_HIGH = 3;
    public const NOTIFICATION_PRIORITY_URGENT = 4;
}
