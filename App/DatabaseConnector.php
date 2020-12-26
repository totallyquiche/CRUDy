<?php declare(strict_types=1);

namespace App;

use \PDO;
use \PDOException;

class DatabaseConnector
{
    /**
     * Instance of this class.
     *
     * @var DatabaseConnector|null
     */
    private static ?DatabaseConnector $self = null;

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
        $db_host = Config::get('DB_HOST');
        $db_name = Config::get('DB_NAME');
        $db_user = Config::get('DB_USER');
        $db_password = Config::get('DB_PASSWORD');

        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
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
     * @return DatabaseConnector
     */
    public static function getInstance() : DatabaseConnector
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }

        return self::$self;
    }
}