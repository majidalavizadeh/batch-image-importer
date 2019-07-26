<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Import CSV</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .button-success,
        .button-error,
        .button-warning,
        .button-secondary {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
            padding: 15px 32px;
            text-align: center;
            border: none;
            font-size: 16px;
        }

        .button-success {
            background: rgb(28, 184, 65); /* this is a green */
        }

        label {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        input[type=file] {
            margin-bottom: 10px;
        }

        .error {
            color: #b91d19;
            font-size: 13px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            Import CSV file
        </div>

        <form action="" method="post" class="links" enctype="multipart/form-data">
            @csrf
            <label for="file">Picture CSV file:</label>
            <br>
            <input type="file" name="file">
            @if ($errors->has('file'))
                <div class="error">
                    {{ $errors->first('file') }}
                </div>
            @endif
            <br>
            <input type="checkbox" name="header" id="header" value="1" checked>
            <label for="header">First line is header ?</label>
            <br><br>
            <button type="submit" class="button-success pure-button">Import</button>
        </form>
    </div>
</div>
</body>
</html>
