<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta charset="UTF-8">
        <title>MVC Example</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/dist/css/bootstrap-paper.min.css">
    </head>

    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Navegação</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="/">

                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/users">
                               Usuários
                            </a>
                        </li>

                        <li>
                            <a href="/groups">
                                Grupos
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <?= $content; ?>
                </div>
            </div>
        </div>

        <script src="/dist/js/jquery-1.12.4.min.js"></script>
        <script src="/dist/js/bootstrap.min.js"></script>
        <script src="/dist/js/bootbox.min.js"></script>
        <script src="/dist/js/validate.min.js"></script>

        <script src="/dist/js/modules/user.js"></script>
        <script src="/dist/js/modules/user_group.js"></script>
    </body>
</html>
