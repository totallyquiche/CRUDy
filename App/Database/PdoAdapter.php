<?php declare(strict_types=1);

namespace App\Database;

use App\Config;
use \PDO;
use \PDOException;

class PdoAdapter implements DatabaseAdapterInterface
{
    /**
     * Instance of this class.
     *
     * @var PdoAdapter|null
     */
    private static ?PdoAdapter $self = null;

    /**
     * Instance of the PDO connection.
     *
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Sets the Pdo instance. Defaults to using the DB info in the app config.
     *
     * @param string|null $db_host
     * @param string|null $db_name
     * @param string|null $db_user
     * @param string|null $db_password
     *
     * @return void
     */
    private function setPdo(string $db_host = null, string $db_name = null, string $db_user = null, string $db_password = null)
    {
        $db_host = $db_host ?? Config::get('DB_HOST');
        $db_name = $db_name ?? Config::get('DB_NAME');
        $db_user = $db_user ?? Config::get('DB_USER');
        $db_password = $db_password ?? Config::get('DB_PASSWORD');

        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        try {
            $this->pdo = new PDO($dsn, $db_user, $db_password, $options);
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
     * @param string|null $db_host
     * @param string|null $db_name
     * @param string|null $db_user
     * @param string|null $db_password
     *
     * @return DatabaseAdapterInterface
     */
    public static function getInstance(string $db_host = null, string $db_name = null, string $db_user = null, string $db_password = null) : DatabaseAdapterInterface
    {

        // If we are connecting to a new DB or this is the first time connecting,
        // create a new connection.
        if (
            ($db_host && $db_name && $db_user && $db_password) ||
            is_null(self::$self)
        ) {
            self::$self = new self;

            self::$self->setPdo(
                $db_host ?? Config::get('DB_HOST'),
                $db_name ?? Config::get('DB_NAME'),
                $db_user ?? Config::get('DB_USER'),
                $db_password ?? Config::get('DB_PASSWORD')
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