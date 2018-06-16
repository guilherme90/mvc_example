<div class="page-header">
    <h1>Grupos <small>Lista de grupos cadastrados</small></h1>
</div>

<div class="panel panel-info">
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (count($groups) > 0):
                    /** @var \Groups\Entity\Group $group */
                    foreach ($groups as $group): ?>
                        <tr>
                            <td>
                                <?= $group->getName(); ?>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>
