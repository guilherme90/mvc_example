<div class="page-header">
    <h1>Usuários <small>Editar usuário</small></h1>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form id="form-add-user">
            <div class="alert alert-danger hidden" role="alert" id="alert-message"></div>

            <div class="form-group">
                <label for="name">Qual seu nome?</label>
                <input type="text" class="form-control" id="name" placeholder="Digite seu nome" value="<?= $user->getName(); ?>" autofocus>
            </div>

            <div class="form-group">
                <label for="last_name">E seu sobrenome?</label>
                <input type="text" class="form-control" id="last_name" placeholder="Digite seu sobrenome" value="<?= $user->getLastName(); ?>">
            </div>

            <div class="form-group">
                <label for="last_name">Informe os grupos para esse usuário:</label>

                <select name="groups" id="groups" class="form-control" multiple>
                    <?php if (count($groups)):
                        /** @var \Groups\Entity\Group $group */
                        foreach ($groups as $group):
                            if (!in_array($group->getId(), $groupsIds)): ?>
                                <option value="<?= $group->getId(); ?>"><?= $group->getName(); ?></option>
                            <?php
                            endif;
                        endforeach;
                    endif; ?>
                </select>

                <span id="helpBlock" class="help-block">
                    Selecione no mínimo 2 grupos
                </span>
            </div>

            <?php if (count($groupsUser) > 0):?>
                <div class="panel panel-info">
                    <header class="panel-heading">
                        Meus Grupos
                    </header>

                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($groupsUser as $group): ?>
                                    <tr>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="UserGroup.remove('<?= $group->getId(); ?>')">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </div>
                                        </td>

                                        <td>
                                            <?= $group->getName(); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </form>

        <div class="panel-footer">
            <div class="btn-group" role="group">
                <a href="/users" class="btn btn-sm btn-default">
                    <i class="glyphicon glyphicon-arrow-left"></i> Voltar
                </a>

                <button type="button" class="btn btn-sm btn-primary" name="btn-add-user" onclick="User.edit('<?= $user->getId(); ?>')">
                    <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>
