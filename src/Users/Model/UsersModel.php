<?php

namespace Users\Service;

use Core\Service\AbstractStatementService;
use Database\CustomMessages\DuplicateEntry;
use Ramsey\Uuid\Uuid;
use Users\Entity\User;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class UsersModel extends AbstractStatementService
{
    /**
     * @return array
     */
    public function findAllUsers() : array
    {
        $sql = <<<SQL
          SELECT 
              user_id AS id, 
              name,
              last_name AS lastName,
              created_at AS createdAt
          FROM 
              users 
          ORDER BY name ASC
SQL;

        return $this->statement->fetchAll($sql, User::class);
    }

    /**
     * @param string $userId
     *
     * @return User
     * @throws \Exception
     */
    public function find(string $userId) : User
    {
        $sql = <<<SQL
          SELECT 
                user_id AS id, 
                name,
                last_name AS lastName
          FROM 
              users 
          WHERE 
              user_id = :id
SQL;

        $user = $this->statement->fetchObject(
            $sql,
            User::class,
            [
                ':id' => $userId
            ]
        );

        if (! $user) {
            throw new \Exception(
                sprintf('Usuário com o código "%s" não foi encontrado.', $userId)
            );
        }

        return $user;
    }

    /**
     * @param string $userId
     * @param array  $groups
     * @param array  $groupsUser
     */
    private function addUsersGroups(
        string $userId,
        array $groups,
        array $groupsUser = []
    ) {
        $statement = $this->statement->getConnection();

        $sql = <<<SQL
          INSERT INTO users_groups (user_group_id, user_id, group_id) VALUES (:id, :userId, :groupId)
SQL;

        foreach ($groups as $groupId) {
            if (! in_array($groupId, $groupsUser)) {
                $stmt = $statement->prepare($sql);
                $stmt->execute([
                    ':id' => (string) Uuid::uuid4(),
                    ':userId' => $userId,
                    ':groupId' => $groupId
                ]);
            }
        }
    }

    /**
     * @param string $name
     * @param string $lastName
     * @param array  $groups
     *
     * @throws \Exception
     */
    public function add(string $name, string $lastName, array $groups)
    {
        $statement = $this->statement->getConnection();

        $sql = <<<SQL
          INSERT INTO users (user_id, name, last_name, created_at) VALUES (:id, :name, :lastName, :createdAt)    
SQL;
        try {
            $userId = (string) Uuid::uuid4();

            $statement->beginTransaction();
            $stmt = $statement->prepare($sql);
            $stmt->execute([
                ':id' => $userId,
                ':name' => trim($name),
                ':lastName' => trim($lastName),
                ':createdAt' => (new \DateTimeImmutable())->format('Y-m-d H:i:s')
            ]);

            $this->addUsersGroups($userId, $groups);

            $statement->commit();
        } catch (\Exception $e) {
            $statement->rollBack();

            $message = $e->getMessage();
            if ($e->getCode() === '23000') {
                $message = DuplicateEntry::fromString($e->getMessage());
            }

            throw new \Exception(
                $message,
                $e->getCode(),
                $e->getPrevious()
            );
        }
    }

    /**
     * @param string $userId
     * @param string $name
     * @param string $lastName
     * @param array  $groups
     *
     * @throws \Exception
     */
    public function edit(
        string $userId,
        string $name,
        string $lastName,
        array $groups,
        array $groupsUser
    ) {
        $statement = $this->statement->getConnection();

        $sql = <<<SQL
          UPDATE users 
          SET name = :name, last_name = :lastName, updated_at = :updatedAt
          WHERE user_id = :userId
      
SQL;
        try {
            $statement->beginTransaction();
            $stmt = $statement->prepare($sql);
            $stmt->execute([
                ':userId' => $userId,
                ':name' => trim($name),
                ':lastName' => trim($lastName),
                ':updatedAt' => (new \DateTimeImmutable())->format('Y-m-d H:i:s')
            ]);

            $this->addUsersGroups(
                $userId,
                $groups,
                $groupsUser
            );

            $statement->commit();
        } catch (\Exception $e) {
            $statement->rollBack();

            $message = $e->getMessage();
            if ($e->getCode() === '23000') {
                $message = DuplicateEntry::fromString($e->getMessage());
            }

            throw new \Exception(
                $message,
                $e->getCode(),
                $e->getPrevious()
            );
        }
    }

    /**
     * @param string $userId
     *
     * @throws \Exception
     */
    public function remove(string $userId)
    {
        $statement = $this->statement->getConnection();

        if (! $this->find($userId)) {
            throw new \Exception('Usuário não encontrado.');
        }

        $sql = <<<SQL
          DELETE FROM users WHERE user_id = :userId
SQL;

        $stmt = $statement->prepare($sql);
        $stmt->execute([
            ':userId' => $userId
        ]);
    }
}
