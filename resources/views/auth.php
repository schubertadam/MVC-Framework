<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <?php
                use App\Helpers\Form\Form;

                $form = new Form($model, 'post');
                    echo $form->input('username');
                    echo $form->input('password')->password();
                    echo $form->button('login');
                $form->close();
                ?>
            </div>
            <div class="col-4"></div>
        </div>

    </div>
</body>
</html>