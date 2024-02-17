<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateImageTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE IF NOT EXISTS images (
                id INT PRIMARY KEY AUTO_INCREMENT,
                file_path VARCHAR(255) NOT NULL UNIQUE,
                shared_path VARCHAR(255) NOT NULL UNIQUE,
                delete_path VARCHAR(255) NOT NULL UNIQUE,
                id_address VARCHAR(255) NOT NULL,
                view_count INT DEFAULT 0,
                file_size INT DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                last_accessed_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE IF EXISTS images"
        ];
    }
}
