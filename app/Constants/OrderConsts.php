<?php

namespace App\Constants;

class OrderConsts
{
    // 注文番号
    public const ORDER_NUMBER_LENGTH = 12;
    public const ORDER_NUMBER_PREFIX = 'ORD';

    // 配送
    public const FREE_SHIPPING_THRESHOLD = 5000;
    public const DEFAULT_SHIPPING_FEE = 800;
    public const EXPRESS_SHIPPING_FEE = 1200;

    // 返品・交換
    public const RETURN_PERIOD_DAYS = 14;
    public const EXCHANGE_PERIOD_DAYS = 30;

    // キャンセル
    public const CANCEL_LIMIT_HOURS = 24;

    // 決済
    public const PAYMENT_TIMEOUT_MINUTES = 30;
    public const REFUND_PROCESS_DAYS = 7;

    // 注文ステータス
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_COMPLETED = 'completed';

    // 支払いステータス
    public const PAYMENT_STATUS_PENDING = 'pending';
    public const PAYMENT_STATUS_PROCESSING = 'processing';
    public const PAYMENT_STATUS_COMPLETED = 'completed';
    public const PAYMENT_STATUS_FAILED = 'failed';
    public const PAYMENT_STATUS_REFUNDED = 'refunded';

    // 支払い方法
    public const PAYMENT_METHOD_CREDIT_CARD = 'credit_card';
    public const PAYMENT_METHOD_BANK_TRANSFER = 'bank_transfer';
    public const PAYMENT_METHOD_COD = 'cod';
    public const PAYMENT_METHOD_DIGITAL_WALLET = 'digital_wallet';

    // 配送方法
    public const SHIPPING_METHOD_STANDARD = 'standard';
    public const SHIPPING_METHOD_EXPRESS = 'express';
    public const SHIPPING_METHOD_SAME_DAY = 'same_day';

    // 数量制限
    public const MIN_QUANTITY = 1;
    public const MAX_QUANTITY = 99;

    // 金額制限
    public const MIN_ORDER_AMOUNT = 100;
    public const MAX_ORDER_AMOUNT = 1000000;

    // 配送先情報
    public const SHIPPING_NAME_MAX_LENGTH = 100;
    public const SHIPPING_PHONE_MAX_LENGTH = 20;
    public const SHIPPING_ADDRESS_MAX_LENGTH = 500;
    public const SHIPPING_POSTAL_CODE_LENGTH = 8;

    // 注文メモ
    public const NOTES_MAX_LENGTH = 1000;

    // キャッシュ
    public const CACHE_TAG = 'orders';
    public const CACHE_DURATION = 1800; // 30分

    // 通知
    public const NOTIFICATION_ORDER_CONFIRMED = 'order_confirmed';
    public const NOTIFICATION_ORDER_SHIPPED = 'order_shipped';
    public const NOTIFICATION_ORDER_DELIVERED = 'order_delivered';
    public const NOTIFICATION_PAYMENT_FAILED = 'payment_failed';

    // レポート
    public const REPORT_DAILY = 'daily';
    public const REPORT_WEEKLY = 'weekly';
    public const REPORT_MONTHLY = 'monthly';
    public const REPORT_YEARLY = 'yearly';

    // エクスポート
    public const EXPORT_FORMAT_CSV = 'csv';
    public const EXPORT_FORMAT_EXCEL = 'excel';
    public const EXPORT_FORMAT_PDF = 'pdf';
}
