<?php

declare(strict_types=1);

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repositories\Secu;

use App\Models\Secu;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

final class SecuRepositoryEloquent implements SecuRepository
{
    private Secu $secu;

    private Secu $instance;

    public function __construct(
        Secu $secu
    ) {
        $this->secu = $secu;
    }

    /**
     * Get SЁCU id.
     */
    public function getId(): string
    {
        return $this->instance->getAttribute('id');
    }

    /**
     * Get SЁCU hash.
     */
    public function getHash(): string
    {
        return $this->instance->getAttribute('hash');
    }

    /**
     * Store data.
     *
     * @param string|array $data Data needed to be stored
     * @return void
     */
    public function store(
        $data
    ): void {
        $data = json_encode($data);

        $this->instance = $this->secu->query()->create([
            'data' => $data,
        ]);
    }

    /**
     * Retrieve record and destroy.
     *
     * @throws Exception
     */
    public function findByHashAndDestroy(
        string $hash
    ): Secu {
        /** @var \App\Models\Secu $secu */
        $secu = $this->secu->findByHash($hash);
        if (!$secu) {
            // TODO: Throw custom exception
            throw new \RuntimeException();
        }

        $secu->delete();

        return $secu;
    }

    /**
     * Get records older than timestamp.
     */
    public function olderThan(
        Carbon $timestamp
    ): Builder {
        return $this->secu->olderThan($timestamp);
    }

    /**
     * Get SЁCU total created count.
     */
    public function getSecuTotalCreatedCount(): int
    {
        $dbDriverName = DB::getDriverName();

        switch ($dbDriverName) {
            case 'sqlite':
                return $this->getSequenceOfSqliteTable(
                    $this->secu->getTable()
                );
            case 'mysql':
                return $this->getSequenceOfMysqlTable(
                    $this->secu->getTable()
                );
            case 'pgsql':
                return $this->getSequenceOfPgsqlTable(
                    'secu_id_seq'
                );
            default:
                throw new \DomainException("Unsupported database driver `$dbDriverName`");
        }
    }

    protected function getSequenceOfSqliteTable(
        string $tableName
    ): int {
        $schema = DB::table('SQLITE_SEQUENCE')
            ->where('name', $tableName)
            ->select('seq')
            ->first();

        return intval($schema->seq);
    }

    private function getSequenceOfMysqlTable(
        string $tableName
    ): int {
        $databaseName = config('database.connections.mysql.database');

        // TODO: Use config instead of `env`
        $schema = DB::table('INFORMATION_SCHEMA.TABLES')
            ->where('TABLE_SCHEMA', $databaseName)
            ->where('TABLE_NAME', $tableName)
            ->select('AUTO_INCREMENT')
            ->first();

        if ($schema === null) {
            return 0;
        }

        return intval($schema->AUTO_INCREMENT) - 1;
    }

    private function getSequenceOfPgsqlTable(
        string $sequenceName
    ): int {
        $schemaName = config('database.connections.pgsql.schema');

        $nextSequenceId = DB::selectOne(
            <<<SQL
                SELECT last_value
                FROM pg_sequences
                WHERE schemaname = :schema_name
                AND sequencename = :sequence_name
            SQL,
            [
                'schema_name' => $schemaName,
                'sequence_name' => $sequenceName,
            ]
        );

        if ($nextSequenceId === null) {
            return 0;
        }

        return $nextSequenceId->last_value;
    }
}
