<?php

namespace App\Constants;

class NotificationConsts
{
    // 通知種別
    public const TYPE_ORDER_CONFIRMED = 'order_confirmed';
    public const TYPE_ORDER_SHIPPED = 'order_shipped';
    public const TYPE_ORDER_DELIVERED = 'order_delivered';
    public const TYPE_PAYMENT_FAILED = 'payment_failed';
    public const TYPE_LOW_STOCK = 'low_stock';
    public const TYPE_PRODUCT_ACTIVATED = 'product_activated';
    public const TYPE_PRODUCT_DEACTIVATED = 'product_deactivated';
    public const TYPE_NEW_ORDER = 'new_order';
    public const TYPE_ORDER_CANCELLED = 'order_cancelled';
    public const TYPE_PAYMENT_COMPLETED = 'payment_completed';
    public const TYPE_REFUND_PROCESSED = 'refund_processed';

    // 通知チャンネル
    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_SMS = 'sms';
    public const CHANNEL_PUSH = 'push';
    public const CHANNEL_DATABASE = 'database';
    public const CHANNEL_SLACK = 'slack';
    public const CHANNEL_DISCORD = 'discord';

    // 通知優先度
    public const PRIORITY_LOW = 1;
    public const PRIORITY_NORMAL = 2;
    public const PRIORITY_HIGH = 3;
    public const PRIORITY_URGENT = 4;

    // 通知ステータス
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';
    public const STATUS_READ = 'read';

    // 通知テンプレート
    public const TEMPLATE_ORDER_CONFIRMED = 'emails.orders.confirmed';
    public const TEMPLATE_ORDER_SHIPPED = 'emails.orders.shipped';
    public const TEMPLATE_ORDER_DELIVERED = 'emails.orders.delivered';
    public const TEMPLATE_PAYMENT_FAILED = 'emails.payments.failed';
    public const TEMPLATE_LOW_STOCK = 'emails.products.low_stock';
    public const TEMPLATE_WELCOME = 'emails.auth.welcome';
    public const TEMPLATE_PASSWORD_RESET = 'emails.auth.password_reset';

    // 通知設定
    public const DEFAULT_CHANNELS = [self::CHANNEL_EMAIL, self::CHANNEL_DATABASE];
    public const URGENT_CHANNELS = [self::CHANNEL_EMAIL, self::CHANNEL_SMS, self::CHANNEL_PUSH];

    // 通知制限
    public const MAX_NOTIFICATIONS_PER_USER = 100;
    public const NOTIFICATION_RETENTION_DAYS = 90;
    public const RATE_LIMIT_PER_MINUTE = 10;

    // 通知グループ
    public const GROUP_ORDERS = 'orders';
    public const GROUP_PAYMENTS = 'payments';
    public const GROUP_PRODUCTS = 'products';
    public const GROUP_SYSTEM = 'system';
    public const GROUP_MARKETING = 'marketing';

    // 通知設定キー
    public const SETTING_EMAIL_NOTIFICATIONS = 'email_notifications';
    public const SETTING_SMS_NOTIFICATIONS = 'sms_notifications';
    public const SETTING_PUSH_NOTIFICATIONS = 'push_notifications';
    public const SETTING_ORDER_NOTIFICATIONS = 'order_notifications';
    public const SETTING_MARKETING_NOTIFICATIONS = 'marketing_notifications';

    // 通知メッセージ
    public const MESSAGE_ORDER_CONFIRMED = '注文が確定しました';
    public const MESSAGE_ORDER_SHIPPED = '商品が発送されました';
    public const MESSAGE_ORDER_DELIVERED = '商品が配達されました';
    public const MESSAGE_PAYMENT_FAILED = '決済に失敗しました';
    public const MESSAGE_LOW_STOCK = '在庫が少なくなっています';
    public const MESSAGE_WELCOME = 'ご登録ありがとうございます';
    public const MESSAGE_PASSWORD_RESET = 'パスワードリセットのご案内';

    // 通知アイコン
    public const ICON_ORDER = 'shopping-cart';
    public const ICON_PAYMENT = 'credit-card';
    public const ICON_PRODUCT = 'package';
    public const ICON_SYSTEM = 'settings';
    public const ICON_WARNING = 'alert-triangle';
    public const ICON_SUCCESS = 'check-circle';
    public const ICON_INFO = 'info';

    // 通知色
    public const COLOR_SUCCESS = 'success';
    public const COLOR_WARNING = 'warning';
    public const COLOR_ERROR = 'error';
    public const COLOR_INFO = 'info';
    public const COLOR_DEFAULT = 'default';
}
