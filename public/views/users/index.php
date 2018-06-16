<div class="page-header">
    <h1>Usuários <small>Lista de usuários cadastrados</small></h1>
</div>

<div class="panel panel-info">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <a href="/users/add" class="btn btn-success btn-sm">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th class="hidden-xs">Sobrenome</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    if (count($users) > 0):
                        /** @var \Users\Entity\User $user */
                        foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/users/edit/?id=<?= $user->getId(); ?>" class="btn btn-sm btn-info">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-danger" onclick="User.remove('<?= $user->getId(); ?>')">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </div>
                                </td>

                                <td>
                                    <?= $user->getName(); ?>
                                </td>

                                <td class="hidden-xs">
                                    <?= $user->getLastName(); ?>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif; ?>
            </tbody>
        </table>
    </div>
</div>
