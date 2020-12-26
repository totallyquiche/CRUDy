<?php declare(strict_types=1);

namespace App;

use \PDO;
use \PDOException;

class DatabaseAdapter
{
    /**
     * Instance of this class.
     *
     * @var DatabaseAdapter|null
     */
    private static ?DatabaseAdapter $self = null;

    /**
     * Instance of the PDO connection.
     *
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Instantiate the object, establishing a connection to the database.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pdo = $this->setPdo(
            Config::get('DB_HOST'),
            Config::get('DB_NAME'),
            Config::get('DB_USER'),
            Config::get('DB_PASSWORD')
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
    private function setPdo() : PDO
    {
        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
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
     * @return DatabaseAdapter
     */
    public static function getInstance() : DatabaseAdapter
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }

        return self::$self;
    }
}