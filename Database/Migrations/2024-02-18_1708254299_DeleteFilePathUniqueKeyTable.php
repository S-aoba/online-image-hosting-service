<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class DeleteFilePathUniqueKeyTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE images DROP CONSTRAINT file_path"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE images ADD CONSTRAINT file_path UNIQUE (file_path)"
        ];
    }
}
