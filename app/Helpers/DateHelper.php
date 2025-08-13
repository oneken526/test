<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Constants\SystemConsts;

class DateHelper
{
    /**
     * 日付を日本語形式でフォーマット
     */
    public static function formatJapanese($date, string $format = 'Y年n月j日'): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format($format);
    }

    /**
     * 日時を日本語形式でフォーマット
     */
    public static function formatJapaneseDateTime($date, string $format = 'Y年n月j日 G:i'): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format($format);
    }

    /**
     * 相対時間を取得（〜時間前、〜日前など）
     */
    public static function getRelativeTime($date): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->diffForHumans();
    }

    /**
     * 日付を短縮形式でフォーマット
     */
    public static function formatShort($date, string $format = 'n/j'): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format($format);
    }

    /**
     * 日付を長形式でフォーマット
     */
    public static function formatLong($date, string $format = 'Y年n月j日（D）'): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format($format);
    }

    /**
     * 時間のみをフォーマット
     */
    public static function formatTime($date, string $format = 'G:i'): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format($format);
    }

    /**
     * 曜日を日本語で取得
     */
    public static function getJapaneseDayOfWeek($date): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        $dayOfWeek = $carbon->dayOfWeek;
        
        $days = ['日', '月', '火', '水', '木', '金', '土'];
        return $days[$dayOfWeek];
    }

    /**
     * 月を日本語で取得
     */
    public static function getJapaneseMonth($date): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format('n月');
    }

    /**
     * 年を日本語で取得
     */
    public static function getJapaneseYear($date): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format('Y年');
    }

    /**
     * 期間を計算（日数）
     */
    public static function calculateDaysDifference($startDate, $endDate): int
    {
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $end = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);
        
        return $start->diffInDays($end);
    }

    /**
     * 期間を計算（時間）
     */
    public static function calculateHoursDifference($startDate, $endDate): int
    {
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $end = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);
        
        return $start->diffInHours($end);
    }

    /**
     * 期間を計算（分）
     */
    public static function calculateMinutesDifference($startDate, $endDate): int
    {
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $end = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);
        
        return $start->diffInMinutes($end);
    }

    /**
     * 今日かどうかチェック
     */
    public static function isToday($date): bool
    {
        if (!$date) return false;
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->isToday();
    }

    /**
     * 昨日かどうかチェック
     */
    public static function isYesterday($date): bool
    {
        if (!$date) return false;
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->isYesterday();
    }

    /**
     * 今週かどうかチェック
     */
    public static function isThisWeek($date): bool
    {
        if (!$date) return false;
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->isThisWeek();
    }

    /**
     * 今月かどうかチェック
     */
    public static function isThisMonth($date): bool
    {
        if (!$date) return false;
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->isThisMonth();
    }

    /**
     * 今年かどうかチェック
     */
    public static function isThisYear($date): bool
    {
        if (!$date) return false;
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->isThisYear();
    }

    /**
     * 過去の日付かどうかチェック
     */
    public static function isPast($date): bool
    {
        if (!$date) return false;
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->isPast();
    }

    /**
     * 未来の日付かどうかチェック
     */
    public static function isFuture($date): bool
    {
        if (!$date) return false;
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->isFuture();
    }

    /**
     * 日付範囲内かどうかチェック
     */
    public static function isBetween($date, $startDate, $endDate): bool
    {
        if (!$date) return false;
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $end = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);
        
        return $carbon->between($start, $end);
    }

    /**
     * 年齢を計算
     */
    public static function calculateAge($birthDate): int
    {
        if (!$birthDate) return 0;
        
        $birth = $birthDate instanceof Carbon ? $birthDate : Carbon::parse($birthDate);
        return $birth->age;
    }

    /**
     * 営業日を計算（土日祝日を除く）
     */
    public static function calculateBusinessDays($startDate, $endDate): int
    {
        $start = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $end = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);
        
        $businessDays = 0;
        $current = $start->copy();
        
        while ($current->lte($end)) {
            if ($current->isWeekday()) {
                $businessDays++;
            }
            $current->addDay();
        }
        
        return $businessDays;
    }

    /**
     * 日付をISO形式でフォーマット
     */
    public static function formatISO($date): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->toISOString();
    }

    /**
     * 日付をデータベース形式でフォーマット
     */
    public static function formatDatabase($date): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format(SystemConsts::DATETIME_FORMAT);
    }

    /**
     * 日付を表示用にフォーマット（スマート表示）
     */
    public static function formatSmart($date): string
    {
        if (!$date) return '';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        
        if ($carbon->isToday()) {
            return '今日 ' . $carbon->format('G:i');
        }
        
        if ($carbon->isYesterday()) {
            return '昨日 ' . $carbon->format('G:i');
        }
        
        if ($carbon->isThisWeek()) {
            return $carbon->format('n/j（D） G:i');
        }
        
        if ($carbon->isThisYear()) {
            return $carbon->format('n/j G:i');
        }
        
        return $carbon->format('Y/n/j G:i');
    }
}
