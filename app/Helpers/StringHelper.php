<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class StringHelper
{
    /**
     * 文字列をサニタイズ
     */
    public static function sanitize(string $string): string
    {
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    }

    /**
     * 文字列を短縮（省略記号付き）
     */
    public static function truncate(string $string, int $length = 100, string $suffix = '...'): string
    {
        if (mb_strlen($string) <= $length) {
            return $string;
        }

        return mb_substr($string, 0, $length) . $suffix;
    }

    /**
     * 文字列を単語単位で短縮
     */
    public static function truncateWords(string $string, int $words = 10, string $suffix = '...'): string
    {
        $wordArray = explode(' ', $string);

        if (count($wordArray) <= $words) {
            return $string;
        }

        return implode(' ', array_slice($wordArray, 0, $words)) . $suffix;
    }

    /**
     * 文字列をキャメルケースに変換
     */
    public static function toCamelCase(string $string): string
    {
        return Str::camel($string);
    }

    /**
     * 文字列をスネークケースに変換
     */
    public static function toSnakeCase(string $string): string
    {
        return Str::snake($string);
    }

    /**
     * 文字列をケバブケースに変換
     */
    public static function toKebabCase(string $string): string
    {
        return Str::kebab($string);
    }

    /**
     * 文字列をパスカルケースに変換
     */
    public static function toPascalCase(string $string): string
    {
        return Str::studly($string);
    }

    /**
     * 文字列をタイトルケースに変換
     */
    public static function toTitleCase(string $string): string
    {
        return Str::title($string);
    }

    /**
     * 文字列をランダムに生成
     */
    public static function random(int $length = 16): string
    {
        return Str::random($length);
    }

    /**
     * 文字列をランダムに生成（英数字のみ）
     */
    public static function randomAlphaNumeric(int $length = 16): string
    {
        return Str::random($length);
    }

    /**
     * 文字列をランダムに生成（数字のみ）
     */
    public static function randomNumeric(int $length = 6): string
    {
        $numbers = '0123456789';
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $numbers[rand(0, strlen($numbers) - 1)];
        }

        return $result;
    }

    /**
     * 文字列をランダムに生成（英字のみ）
     */
    public static function randomAlpha(int $length = 16): string
    {
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $letters[rand(0, strlen($letters) - 1)];
        }

        return $result;
    }

    /**
     * 文字列をマスク処理
     */
    public static function mask(string $string, string $mask = '*', int $start = 0, int $length = null): string
    {
        $stringLength = mb_strlen($string);

        if ($start >= $stringLength) {
            return $string;
        }

        if ($length === null) {
            $length = $stringLength - $start;
        }

        $end = min($start + $length, $stringLength);
        $masked = str_repeat($mask, $end - $start);

        return mb_substr($string, 0, $start) . $masked . mb_substr($string, $end);
    }

    /**
     * メールアドレスをマスク処理
     */
    public static function maskEmail(string $email): string
    {
        $parts = explode('@', $email);

        if (count($parts) !== 2) {
            return $email;
        }

        $username = $parts[0];
        $domain = $parts[1];

        if (mb_strlen($username) <= 2) {
            $maskedUsername = $username;
        } else {
            $maskedUsername = mb_substr($username, 0, 1) .
                             str_repeat('*', mb_strlen($username) - 2) .
                             mb_substr($username, -1);
        }

        return $maskedUsername . '@' . $domain;
    }

    /**
     * 電話番号をマスク処理
     */
    public static function maskPhone(string $phone): string
    {
        $length = mb_strlen($phone);

        if ($length <= 4) {
            return $phone;
        }

        return mb_substr($phone, 0, $length - 4) . '****';
    }

    /**
     * 文字列をスラグに変換
     */
    public static function toSlug(string $string): string
    {
        return Str::slug($string);
    }

    /**
     * 文字列をURLエンコード
     */
    public static function urlEncode(string $string): string
    {
        return urlencode($string);
    }

    /**
     * 文字列をURLデコード
     */
    public static function urlDecode(string $string): string
    {
        return urldecode($string);
    }

    /**
     * 文字列をBase64エンコード
     */
    public static function base64Encode(string $string): string
    {
        return base64_encode($string);
    }

    /**
     * 文字列をBase64デコード
     */
    public static function base64Decode(string $string): string
    {
        return base64_decode($string);
    }

    /**
     * 文字列をMD5ハッシュに変換
     */
    public static function md5(string $string): string
    {
        return md5($string);
    }

    /**
     * 文字列をSHA1ハッシュに変換
     */
    public static function sha1(string $string): string
    {
        return sha1($string);
    }

    /**
     * 文字列をSHA256ハッシュに変換
     */
    public static function sha256(string $string): string
    {
        return hash('sha256', $string);
    }

    /**
     * 文字列の最初の文字を大文字に変換
     */
    public static function ucfirst(string $string): string
    {
        return Str::ucfirst($string);
    }

    /**
     * 文字列の最初の文字を小文字に変換
     */
    public static function lcfirst(string $string): string
    {
        return Str::lcfirst($string);
    }

    /**
     * 文字列を大文字に変換
     */
    public static function upper(string $string): string
    {
        return Str::upper($string);
    }

    /**
     * 文字列を小文字に変換
     */
    public static function lower(string $string): string
    {
        return Str::lower($string);
    }

    /**
     * 文字列の長さを取得
     */
    public static function length(string $string): int
    {
        return mb_strlen($string);
    }

    /**
     * 文字列が空かどうかチェック
     */
    public static function isEmpty(string $string): bool
    {
        return empty(trim($string));
    }

    /**
     * 文字列が空でないかチェック
     */
    public static function isNotEmpty(string $string): bool
    {
        return !self::isEmpty($string);
    }

    /**
     * 文字列に特定の文字列が含まれているかチェック
     */
    public static function contains(string $haystack, string $needle): bool
    {
        return Str::contains($haystack, $needle);
    }

    /**
     * 文字列が特定の文字列で始まるかチェック
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        return Str::startsWith($haystack, $needle);
    }

    /**
     * 文字列が特定の文字列で終わるかチェック
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        return Str::endsWith($haystack, $needle);
    }

    /**
     * 文字列から特定の文字列を削除
     */
    public static function remove(string $string, string $remove): string
    {
        return str_replace($remove, '', $string);
    }

    /**
     * 文字列を置換
     */
    public static function replace(string $string, string $search, string $replace): string
    {
        return str_replace($search, $replace, $string);
    }

    /**
     * 文字列を配列に分割
     */
    public static function split(string $string, string $delimiter = ' '): array
    {
        return explode($delimiter, $string);
    }

    /**
     * 配列を文字列に結合
     */
    public static function join(array $array, string $glue = ' '): string
    {
        return implode($glue, $array);
    }

    /**
     * 文字列を改行で分割
     */
    public static function splitLines(string $string): array
    {
        return explode("\n", $string);
    }

    /**
     * 文字列の改行をHTMLの改行タグに変換
     */
    public static function nl2br(string $string): string
    {
        return nl2br($string);
    }

    /**
     * HTMLタグを削除
     */
    public static function stripTags(string $string): string
    {
        return strip_tags($string);
    }

    /**
     * 文字列をエスケープ
     */
    public static function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * 文字列をアンエスケープ
     */
    public static function unescape(string $string): string
    {
        return htmlspecialchars_decode($string, ENT_QUOTES);
    }

    /**
     * 文字列をJSONに変換
     */
    public static function toJson($data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * JSONを配列に変換
     */
    public static function fromJson(string $json): array
    {
        return json_decode($json, true) ?? [];
    }

    /**
     * 文字列をCSVに変換
     */
    public static function toCsv(array $data): string
    {
        $output = fopen('php://temp', 'r+');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }

    /**
     * CSVを配列に変換
     */
    public static function fromCsv(string $csv): array
    {
        $data = [];
        $lines = explode("\n", $csv);

        foreach ($lines as $line) {
            if (trim($line) !== '') {
                $data[] = str_getcsv($line);
            }
        }

        return $data;
    }

    /**
     * 文字列をUUIDに変換
     */
    public static function uuid(): string
    {
        return Str::uuid();
    }

    /**
     * 文字列をULIDに変換
     */
    public static function ulid(): string
    {
        return Str::ulid();
    }

    /**
     * 文字列をパスワードに変換（ハッシュ化）
     */
    public static function hashPassword(string $password): string
    {
        return bcrypt($password);
    }

    /**
     * パスワードを検証
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
