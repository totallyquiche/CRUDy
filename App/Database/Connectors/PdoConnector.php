<?php

declare(strict_types=1);

namespace App\Database\Connectors;

use \PDO;
use \PDOException;
use App\Database\Configs\DatabaseConnectorConfig;
use App\Database\Connectors\DatabaseConnector;

abstract class PdoConnector implements DatabaseConnector
{
    /**
     * Instance of the PDO connection.
     *
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Sets the Pdo instance. Defaults to using the DB info in the app config.
     *
     * @param DatabaseConnectorConfig $database_connector_config
     *
     * @return void
     */
    private function setPdo(DatabaseConnectorConfig $database_connector_config) : void
    {
        $dsn = $this->generateDsn($database_connector_config);

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->pdo = new PDO(
                $dsn,
                $database_connector_config->user ?? null,
                $database_connector_config->password ?? null,
                $options
            );
       } catch (PDOException $exception) {
            throw new PDOException(
                $exception->getMessage(),
                (int) $exception->getCode()
            );
       }
    }

    /**
     * Construct and return the DSN.
     *
     * @param DatabaseConnectorConfig $database_connector_config
     *
     * @return string
     */
    abstract protected function generateDsn(DatabaseConnectorConfig $database_connector_config) : string;

    /**
     * Singleton to ensure we always use the same instance of this class.
     *
     * @param DatabaseConnectorConfig|null $database_connector_config
     *
     * @return self
     */
    public static function getInstance(DatabaseConnectorConfig $database_connector_config = null) : self
    {
        static $self = null;

        if (is_null($self) && is_null($database_connector_config)) {
            $database_connector_config = self::generateConnectorConfig();
        }

        if (!is_null($database_connector_config)) {
            $self = new static;

            $self->setPdo($database_connector_config);
        }

        return $self;
    }

    /**
     * Wrapper for PDO::query().
     *
     * @param string $query
     *
     * @return array
     */
    public function query(string $query) : array
    {
        $statement = $this->pdo->query($query);

        $results = [];

        while ($row = $statement->fetch()) {
            $results[] = $row;
        }

        return $results;
    }

    /**
     * Wrapper for PDO::execute().
     *
     * @param string $query
     *
     * @return void
     */
    public function execute(string $query) : void
    {
        $this->pdo->exec($query);
    }
}