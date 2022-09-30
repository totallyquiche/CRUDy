<?php declare(strict_types=1);

namespace App\Database\Connectors;

use App\Config;
use App\Database\Configs\DatabaseConnectorConfig;
use App\Database\Configs\SQLiteConnectorConfig;
use \SQLite3;

class SQLiteConnector implements DatabaseConnector
{
    /**
     * Instance of the SQLite3 connection.
     *
     * @var SQLite3
     */
    private SQLite3 $sqlite3;

    /**
     * Sets the SQLite3 instance. Defaults to using the DB info in the app config.
     *
     * @param string $name
     *
     * @return void
     */
    private function setSQLite3(string $name) : void
    {
        $this->sqlite3 = new SQLite3($name . '.db');
    }

    /**
     * Singleton to ensure we always use the same instance of this class.
     *
     * @param null|DatabaseConnectorConfig
     *
     * @return self
     */
    public static function getInstance(?DataBaseConnectorConfig $database_connector_config = null) : self
    {
        static $self;

        if (is_null($self) && is_null($database_connector_config)) {
            $database_connector_config = new SQLiteConnectorConfig();

            $database_connector_config->name = Config::get('SQLITE_DB_NAME');
        }

        if (!is_null($database_connector_config)) {
            $self = new self;

            $self->setSQLite3($database_connector_config->get('name'));
        }

        return $self;
    }

    /**
     * Wrapper for SQLite3::query().
     *
     * @param string $query
     *
     * @return array
     */
    public function query(string $query) : array
    {
        $statement = $this->sqlite3->query($query);

        $results = [];

        while ($row = $statement->fetchArray()) {
            $results[] = $row;
        }

        return $results;
    }

    /**
     * Wrapper for SQLite3::execute().
     *
     * @param string $query
     *
     * @return void
     */
    public function execute(string $query) : void
    {
        $this->sqlite3->exec($query);
    }
}