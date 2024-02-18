<?php

namespace Helpers;

use DateTime;
use DateInterval;

class ValidationHelper
{
  public static function integer($value, float $min = -INF, float $max = INF): int
  {
    // PHPには、データを検証する組み込み関数があります。詳細は https://www.php.net/manual/en/filter.filters.validate.php を参照ください。
    $value = filter_var($value, FILTER_VALIDATE_INT, ["min_range" => (int) $min, "max_range" => (int) $max]);

    // 結果がfalseの場合、フィルターは失敗したことになります。
    if ($value === false) throw new \InvalidArgumentException("The provided value is not a valid integer.");

    // 値がすべてのチェックをパスしたら、そのまま返します。
    return $value;
  }

  public static function String($value): string
  {
    $value = filter_var($value, FILTER_SANITIZE_STRING);
    if ($value === false) throw new \InvalidArgumentException("The provided value is not a valid string.");
    return $value;
  }

  public static function URL($value): string
  {
    $value = filter_var($value, FILTER_VALIDATE_URL);
    if ($value === false) throw new \InvalidArgumentException("The provided value is not a valid URL.");
    return $value;
  }

  public static function checkExpiration($created_at, $expiration)
  {
    // $created_at を DateTime オブジェクトに変換
    $created_at = new DateTime($created_at);

    // $expiration から数値と単位を取得
    preg_match('/(\d+)\s*(\w+)/', $expiration, $matches);
    $value = (int)$matches[1];
    $unit = $matches[2];

    // 現在の時間を取得
    $current_time = new DateTime('Asia/Tokyo');

    // $expiration に応じて有効期限を追加
    switch ($unit) {
      case 'minute':
      case 'minutes':
        $created_at->add(new DateInterval('PT' . $value . 'M'));
        break;
      case 'hour':
      case 'hours':
        $created_at->add(new DateInterval('PT' . $value . 'H'));
        break;
      case 'day':
      case 'days':
        $created_at->add(new DateInterval('P' . $value . 'D'));
        break;
      default:
        // 不明な単位の場合はエラーを返す
        return false;
    }
    // 現在の時間が有効期限を超えているかどうかを確認
    return $current_time->format('Y-m-d H:i:s') > $created_at->format('Y-m-d H:i:s');
  }

  public static function checkFileExtension(string $file_type)
  {
    $file_type = strtolower($file_type);
    $allowed_extensions = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file_type, $allowed_extensions)) {
      return false;
    }
    return true;
  }
}
