<div class="page-header">
    <h1>Usuários <small>Adicionar usuário</small></h1>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <form id="form-add-user">
            <div class="alert alert-danger hidden" role="alert" id="alert-message"></div>

            <div class="form-group">
                <label for="name">Qual seu nome?</label>
                <input type="text" class="form-control" id="name" placeholder="Digite seu nome" autofocus>
            </div>

            <div class="form-group">
                <label for="last_name">E seu sobrenome?</label>
                <input type="text" class="form-control" id="last_name" placeholder="Digite seu sobrenome">
            </div>

            <div class="form-group">
                <label for="last_name">Informe os grupos desse usuário:</label>

                <select name="groups" id="groups" class="form-control" multiple>
                    <?php if (count($groups)):
                        /** @var \Groups\Entity\Group $group */
                        foreach ($groups as $group): ?>
                            <option value="<?= $group->getId(); ?>"><?= $group->getName(); ?></option>
                        <?php
                        endforeach;
                    endif;  ?>
                </select>

                <span id="helpBlock" class="help-block">
                    Selecione no mínimo 2 grupos
                </span>
            </div>
        </form>

        <div class="panel-footer">
            <div class="btn-group" role="group">
                <a href="/users" class="btn btn-sm btn-default">
                    <i class="glyphicon glyphicon-arrow-left"></i> Voltar
                </a>

                <button type="button" class="btn btn-sm btn-primary" name="btn-add-user" onclick="User.add()">
                    <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>
