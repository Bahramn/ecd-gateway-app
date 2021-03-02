<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sample Application To Test ECD Gateway In Laravel">
    <meta name="author" content="Bahram Nedaei">
    <title>ECD Gateway Test Application</title>

    <link href="/css/app.css" rel="stylesheet">

    <link rel="icon" href="/favicon.png">
    <meta name="theme-color" content="#303A91">
</head>
<body class="bg-light">

<div class="container">
    <main>
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-5" src="/images/logo.png" alt="" width="83" height="67">
            <h1>{{ __('main.head-title') }}</h1>
            <p class="lead">{{ __('main.head-desc') }}</p>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h4 class="mb-4">{{ __('main.billing') }}</h4>
                <form action="/invoice" method="POST" novalidate>
                    {{ csrf_field() }}

                    <div class="card">
                        <div class="card-header">
                            {{ __('main.card') }}
                        </div>
                        <div class="card-body">
                            <table class="table table-hover align-middle text-center table-lg mb-0">
                                <tbody>
                                <tr>
                                    <td>{{ __('main.first-item') }}</td>
                                    <td>200 {{ __('main.rial') }}</td>
                                    <td>3 {{ __('main.qty') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('main.second-item') }}</td>
                                    <td>400 {{ __('main.rial') }}</td>
                                    <td>1 {{ __('main.qty') }}</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td>{{ __('main.total') }}</td>
                                    <td>1000 {{ __('main.rial') }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <hr class="my-5">
                    <button class="w-100 btn btn-primary btn-lg" type="submit">{{ __('main.pay') }}</button>
                </form>
            </div>
        </div>
    </main>
    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">Made with ❤︎ By <a href="https://github.com/Bahramn" target="_blank" >Bahram </a> </p>
    </footer>
</div>

</body>
</html>
