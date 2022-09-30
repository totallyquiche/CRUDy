<?php declare(strict_types=1);

namespace App\Database\Connectors;

use App\Config;
use App\Database\Configs\DatabaseConnectorConfig;
use App\Database\Configs\MySqlConnectorConfig;
use \PDO;
use \PDOException;

class MySqlConnector implements DatabaseConnector
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
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $password
     * @param string $port
     *
     * @return void
     */
    private function setPdo(string $host, string $name, string $user, string $password, string $port)
    {
        $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $password, $options);
       } catch (PDOException $exception) {
            throw new PDOException(
                $exception->getMessage(),
                (int) $exception->getCode()
            );
       }
    }

    /**
     * Singleton to ensure we always use the same instance of this class.
     *
     * @param null|DatabaseConnectorConfig $database_connector_config
     *
     * @return self
     */
    public static function getInstance(?DatabaseConnectorConfig $database_connector_config = null) : self
    {
        static $self = null;

        if (is_null($self) && is_null($database_connector_config)) {
            $database_connector_config = new MySqlConnectorConfig();

            $database_connector_config->host = Config::get('MYSQL_DB_HOST');
            $database_connector_config->name = Config::get('MYSQL_DB_NAME');
            $database_connector_config->user = Config::get('MYSQL_DB_USER');
            $database_connector_config->password = Config::get('MYSQL_DB_PASSWORD');
            $database_connector_config->port = Config::get('MYSQL_DB_PORT');
        }

        if (!is_null($database_connector_config)) {
            $self = new self;

            $self->setPdo(
                $database_connector_config->get('host'),
                $database_connector_config->get('name'),
                $database_connector_config->get('user'),
                $database_connector_config->get('password'),
                $database_connector_config->get('port')
            );
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