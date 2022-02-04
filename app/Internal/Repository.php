<?php

namespace App\Internal;

use App\Exceptions\Database\QueryFailureException;

class Repository
{
    public const FETCH_ONE = 'one';
    public const FETCH_ALL = 'all';

    /**
     * @param Database $connection 
     * 
     * @return void 
     */
    public function __construct(protected readonly Database $connection) {}

    /**
     * @param string $query 
     * @param array $params 
     * 
     * @return PDOStatement 
     * 
     * @throws PDOException 
     * @throws QueryFailureException
     */
    public function query(string $query, array $params = []): \PDOStatement
    {
        $query = $this->connection->pdo->prepare($query);
        $query->execute($params);

        if($query->errorCode() !== \PDO::ERR_NONE) {
            throw new QueryFailureException(message: (string) $query->errorInfo()[2], code: 500);
        }

        return $query;
    }

    /**
     * @param string $query 
     * @param array $params 
     * @param string $fetch 
     * 
     * @return array 
     * 
     * @throws PDOException 
     */
    public function select(
        string $query, 
        array $params = [], 
        string $fetch = Repository::FETCH_ALL
    ): array
    {
        $query = (! $params) 
            ? $this->query($query)
            : $this->query($query, $this->protectAttributes($params));

        return match ($fetch) {
            Repository::FETCH_ALL => $query->fetchAll(),
            Repository::FETCH_ONE => $query->fetch(),
        } ?: [];
    }

    /**
     * @param string $table 
     * @param array $params 
     * 
     * @return int 
     * 
     * @throws PDOException 
     */
    public function insert(string $table, array $params): int
    {
        $params = $this->protectAttributes($params);

        $columns = sprintf('(%s)', implode(', ', array_keys($params)));
        $values = sprintf('(:%s)', implode(', :', array_keys($params)));

		$this->query(sprintf("INSERT INTO %s %s VALUES %s", $table, $columns, $values), $params);
        
		return $this->connection->pdo->lastInsertId();
    }

    /**
     * @param string $table 
     * @param array $params 
     * @param string $where 
     * 
     * @return int 
     * 
     * @throws PDOException 
     */
    public function update(string $table, array $params, string $where): int
    {
        $where = $this->protectAttribute($where);
        $params = $this->protectAttributes($params);

        foreach($params as $key => $value) {
            unset($params[$key]);
            $params[] = "$key = :$value";
        } 
        
        $set = sprintf('%s', implode(', ', $params));
        $query = sprintf('UPDATE %s SET %s WHERE %s', $table, $set, $where);

        return $this->query($query, $params)->rowCount();
    }

    /**
     * @param string $table 
     * @param string $where 
     * 
     * @return int 
     * 
     * @throws PDOException 
     */
    public function delete(string $table, string $where): int
    {
        $query = sprintf(
            'DELETE FROM %s WHERE %s', 
            $this->protectAttribute($table), 
            $this->protectAttribute($where)
        );

        return $this->query($query)->rowCount();
    }

    /**
     * @param string $param 
     * 
     * @return string 
     */
    protected function protectAttribute(string $param): string
    {
        return htmlspecialchars(trim($param));
    }

    /**
     * @param array $params 
     * 
     * @return array 
     */
    protected function protectAttributes(array $params): array
    {
        $protected = [];

        foreach ($params as $param => $value) {
            $_param = $this->protectAttribute($param);
            $_value = $this->protectAttribute($value);

            $protected[$_param] = $_value;
        }

        return $protected;
    }
}