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
     * Instantiate the object, establishing a connection to the database.
     *
     * @param string $db_host
     * @param string $db_name
     * @param string $db_user
     * @param string $db_password
     *
     * @return void
     */
    public function __construct(string $db_host, string $db_name, string $db_user, string $db_password)
    {
        $this->pdo = $this->setPdo(
            $db_host,
            $db_name,
            $db_user,
            $db_password
        );
    }

    /**
     * Create PDO connection.
     *
     * @param string $db_host
     * @param string $db_name
     * @param string $db_user
     * @param string $db_password
     *
     * @return PDO
     */
    private function setPdo(string $db_host, string $db_name, string $db_user, string $db_password) : PDO
    {
        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        try {
            return new PDO($dsn, $db_user, $db_password, $options);
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
     * @param string $db_host
     * @param string $db_name
     * @param string $db_user
     * @param string $db_password
     *
     * @return DatabaseAdapterInterface
     */
    public static function getInstance(?string $db_host = null, ?string $db_name = null, ?string $db_user = null, ?string $db_password = null) : DatabaseAdapterInterface
    {
        if (is_null(self::$self)) {
            self::$self = new self(
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