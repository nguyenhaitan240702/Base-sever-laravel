<?php

namespace App\Helpers\Mysql;

use Closure;
use Exception;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class RetryReadyMySqlConnection extends MySqlConnection
{
    const DEADLOCK_ERROR_CODE = 40001;
    const ATTEMPTS_COUNT = 3;
    protected function runQueryCallback($query, $bindings, Closure $callback)
    {
        $attempts_count = self::ATTEMPTS_COUNT;

        for ($attempt = 1; $attempt <= $attempts_count; $attempt++) {
            try {
                return $callback($this, $query, $bindings);
            } catch (Exception $e) {
                if (((int)$e->getCode() !== self::DEADLOCK_ERROR_CODE) || ($attempt >= $attempts_count)) {
                    throw new QueryException(
                        $query, $this->prepareBindings($bindings), $e
                    );
                } else {
                    $sql = str_replace_array('\?', $this->prepareBindings($bindings), $query);
                    Log::warning("Transaction has been restarted. Attempt {$attempt}/{$attempts_count}. SQL: {$sql}");
                }
            }
        }

    }
}
