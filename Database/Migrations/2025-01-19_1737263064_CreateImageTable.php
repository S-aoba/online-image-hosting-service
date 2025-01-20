<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateImageTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE IF NOT EXISTS images (
                id INT PRIMARY KEY AUTO_INCREMENT,           -- プライマリキー
                name VARCHAR(50) NOT NULL,                   -- 画像名
                image_path VARCHAR(255) NOT NULL,            -- 画像の保存パス
                delete_path VARCHAR(255) NOT NULL,           -- 画像の削除パス
                size BIGINT NOT NULL,                        -- 画像ファイルのサイズ（バイト単位）
                mime_type VARCHAR(50) NOT NULL,              -- MIMEタイプ（例: image/jpeg）
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- 作成日時
                views INT NOT NULL DEFAULT 0,                -- 閲覧回数
                unique_token VARCHAR(64) NOT NULL             -- URL
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE images"
        ];
    }
}