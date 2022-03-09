<!DOCTYPE html>
<html>
<head>
    <title>Custom Auth in Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <form method="post" action="{{ route('update',$product->ProductID)}}" >
            @csrf
            <div id="input1" class="input-group mb-3">
                <span class="input-group-text">What is the new name of the product</span>
                <input type="text" aria-label="Last name" class="form-control" name="name" value="{{ $product->Name }}">
                <span class="input-group-text">What is the new price</span>
                <input type="number" aria-label="Last name" class="form-control" name="price" value="{{ $product->Price }}">
                <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04" name="add">Update</button>
            </div>
        </form>
        <form method="post" action="{{ route('delete',$product->ProductID)}}" >
            @csrf
            <button type="submit" class="btn btn-primary btn-lg btn-block" id="longbut">Delete this product</button>
        </form>
    </section>
    
    
</body>
</html>