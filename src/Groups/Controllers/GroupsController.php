<?php

namespace Groups\Controllers;

use Core\Controller\AbstractController;
use Groups\Model\GroupsModel;

/**
 * @author Guilherme P. Nogueira <guilhermenogueira90@gmail.com>
 */
class GroupsController extends AbstractController
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $groupsModel = new GroupsModel($this->statement);

        $this->render('groups/index', [
            'groups' => $groupsModel->findAllGroups()
        ]);
    }

    /**
     * @return string
     */
    public function removeUserGroupAction() : string
    {
        try {
            $content = $this->getRawBody();

            $groupsModel = new GroupsModel($this->statement);
            $groupsModel->removeUserGroup($content['userGroupId']);

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
