<?php

namespace Users\Controllers;

use Core\Controller\AbstractController;
use Groups\Model\GroupsModel;
use Users\Model\Validation\UserValidatorTrait;
use Users\Service\UsersModel;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class UsersController extends AbstractController
{
    use UserValidatorTrait;

    /**
     * @return void
     */
    public function indexAction()
    {
        $usersModel = new UsersModel($this->statement);

        $this->render('users/index', [
            'users' => $usersModel->findAllUsers()
        ]);
    }

    /**
     * @return string|void
     */
    public function addAction()
    {
        if ($this->isGet()) {
            $groupsModel = new GroupsModel($this->statement);

            $this->render('users/form-add', [
                'groups' => $groupsModel->findAllGroups()
            ]);

            return;
        }

        $content = $this->getRawBody();

        try {
            $this->validate(
                $content['name'],
                $content['last_name'],
                $content['groups']
            );

            $usersModel = new UsersModel($this->statement);
            $usersModel->add(
                $content['name'],
                $content['last_name'],
                $content['groups']
            );

            return $this->jsonResponse([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @return string|void
     */
    public function editAction()
    {
        $usersModel = new UsersModel($this->statement);
        $groupsModel = new GroupsModel($this->statement);

        $userId = $this->getQueryParams()['id'];
        $user = $usersModel->find($userId);
        $groups = $groupsModel->findGroupsIdsByUser($userId);

        if ($this->isGet()) {
            try {
                $this->render('users/form-edit', [
                    'user' => $user,
                    'groupsIds' => $groups,
                    'groupsUser' => $groupsModel->findGroupsByUser($userId),
                    'groups' => $groupsModel->findAllGroups()
                ]);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

            return;
        }

        $content = $this->getRawBody();

        try {
            $this->validate(
                $content['name'],
                $content['last_name'],
                array_merge($groups, $content['groups'])
            );

            $usersModel = new UsersModel($this->statement);
            $usersModel->edit(
                $userId,
                $content['name'],
                $content['last_name'],
                $content['groups'],
                $groups
            );

            return $this->jsonResponse([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @return string
     */
    public function removeAction()
    {
        try {
            $content = $this->getRawBody();

            $usersModel = new UsersModel($this->statement);
            $usersModel->remove($content['userId']);

            return $this->jsonResponse([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
