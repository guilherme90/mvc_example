<?php

namespace Groups\Model;

use Core\Service\AbstractStatementService;
use Groups\Entity\Group;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class GroupsModel extends AbstractStatementService
{
    /**
     * @return array
     */
    public function findAllGroups() : array
    {
        $sql = <<<SQL
          SELECT 
              group_id AS id, 
              name 
          FROM 
              groups 
          ORDER BY name ASC
SQL;

        return $this->statement->fetchAll($sql, Group::class);
    }

    /**
     * @param string $userId
     *
     * @return array
     */
    public function findGroupsByUser(string $userId) : array
    {
        $sql = <<<SQL
          SELECT
             groups.name, users_groups.user_group_id AS id
          FROM
              groups
                  INNER JOIN users_groups ON groups.group_id = users_groups.group_id
                  INNER JOIN users ON users_groups.user_id = users.user_id
          WHERE
                users_groups.user_id = :userId
SQL;

        return $this->statement->fetchAll(
            $sql,
            Group::class,
            [
                ':userId' => $userId
            ]
        );
    }

    /**
     * @param string $userId
     *
     * @return array
     */
    public function findGroupsIdsByUser(string $userId) : array
    {
        $sql = <<<SQL
          SELECT
             users_groups.group_id AS id
          FROM
              groups
                  INNER JOIN users_groups ON groups.group_id = users_groups.group_id
                  INNER JOIN users ON users_groups.user_id = users.user_id
          WHERE
                users_groups.user_id = :userId
SQL;

        $connection = $this->statement->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute([
            ':userId' => $userId
        ]);

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @param string $groupId
     * @return Group
     */
    public function find(string $groupId) : Group
    {
        $sql = <<<SQL
          SELECT 
                group_id AS id, 
                name 
          FROM 
              groups 
          WHERE 
              group_id = :groupId
SQL;

        return $this->statement->fetchObject(
            $sql,
            Group::class,
            [
                ':groupId' => $groupId
            ]
        );
    }

    /**
     * @param string $userGroupId
     */
    public function removeUserGroup(string $userGroupId)
    {
        $sql = <<<SQL
          DELETE FROM users_groups WHERE users_groups.user_group_id = :userGroupId
SQL;

        $connection = $this->statement->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute([
            ':userGroupId' => $userGroupId
        ]);
    }
}
