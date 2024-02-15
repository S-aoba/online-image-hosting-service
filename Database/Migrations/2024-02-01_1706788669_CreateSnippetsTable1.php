<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateSnippetsTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE snippets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                snippet TEXT NOT NULL,
                language VARCHAR(255) NOT NULL,
                path VARCHAR(255) NOT NULL UNIQUE,
                expiration VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE snippets"
        ];
    }
}
