<?php declare(strict_types=1);

namespace App\Database;

use App\Config;
use \PDO;
use \PDOException;

class MySqlConnector implements DatabaseConnectorInterface
{
    /**
     * Instance of this class.
     *
     * @var MySqlConnector|null
     */
    private static ?MySqlConnector $self = null;

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
     * @param string|null $host
     * @param string|null $name
     * @param string|null $user
     * @param string|null $password
     * @param string|null $port
     *
     * @return DatabaseConnectorInterface
     */
    public static function getInstance(string $host = null, string $name = null, string $user = null, string $password = null, string $port = null) : DatabaseConnectorInterface
    {

        // If we are connecting to a new DB or this is the first time connecting,
        // create a new connection.
        if (
            ($host && $name && $user && $password) ||
            is_null(self::$self)
        ) {
            self::$self = new self;

            self::$self->setPdo(
                $host ?? Config::get('DB_HOST'),
                $name ?? Config::get('DB_NAME'),
                $user ?? Config::get('DB_USER'),
                $password ?? Config::get('DB_PASSWORD'),
                $port ?? Config::get('DB_PORT')
            );
        }

        return self::$self;
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