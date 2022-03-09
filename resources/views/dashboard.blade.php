<!DOCTYPE html>
<html>
<head>
    <title>Custom Auth in Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
        <form method="post" action="{{ route('post') }}" >
            @csrf
            <div id="input1" class="input-group mb-3">
                <span class="input-group-text">Name the product u want to add</span>
                <input type="text" aria-label="Last name" class="form-control" name="name" >
                <span class="input-group-text">What price it will have</span>
                <input type="number" aria-label="Last name" class="form-control" name="price" >
                @if ($errors->has('name'))
                <script type="text/javascript">
                    alert("{{ $errors->first('name') }}")
                </script>
                @elseif ($errors->has('price'))
                <script type="text/javascript">
                    alert("{{ $errors->first('price') }}")
                </script>               
                @endif
                <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04" name="add">Add product</button>
            </div>
        </form>
        <?php
            $count = ''; 
        ?>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            @foreach($products as $product)<div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">{{ $product['Name']}}</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">{{ $product['Price']}} <small class="text-muted fw-light">lei/kg</small></h1>
                            <div class="btn-group" role="group"><?php if($product['UserID']  == Auth::user()->id ){ ?>
                                <a href="{{route('edit',$product->ProductID)}}"><button type="button" id="edit" class="w-100 btn btn-lg btn-outline-primary">Update product</button></a><?php }?>
                                <?php if (!$favors->isEmpty()){ ?>
                                    @foreach($favors as $fav)<?php
                                        if($product['ProductID']  == $fav->ProductID ){ 
                                            $count = $fav->ProductID;
                                        }?>@endforeach
                                    <?php if($product['ProductID'] != $count){ ?>
                                        <form method="post" action="{{ route('fav',$product->ProductID)}}">@csrf<button type="submit" id="fav"  class="w-100 btn btn-lg btn-outline-primary">Add to favorites</button></form>
                                    <?php }else{ ?>
                                        
                                    <?php } ?>
                                <?php }else{ ?>
                                    <form method="post" action="{{ route('fav',$product->ProductID)}}">@csrf<button type="submit" id="fav"  class="w-100 btn btn-lg btn-outline-primary">Add to favorites</button></form>
                                <?php } ?>
                            </div>
                    </div>
                </div>
            </div>@endforeach 
        </div>
        <span>{{$products->links('pagination::bootstrap-5')}}</span>
        <?php 
            $name = '';
            $price = '';
        ?>
        <hr></hr>
        <h1 style="text-align: center;"> My favorites</h1>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            @foreach($favorshow as $favor)<div class="col">
                @foreach($vars as $product)<?php
                    if($product['ProductID']  == $favor->ProductID){ 
                        $ID = $product['ProductID'];
                        $name = $product['Name'];
                        $price = $product['Price'];
                        ?>@break<?php
                    }?>@endforeach
                <?php if($ID  == $favor->ProductID){ ?>
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">{{ $name }}</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">{{ $price }} <small class="text-muted fw-light">lei/kg</small></h1>
                            <div class="btn-group" role="group"><?php if($product['UserID']  == Auth::user()->id ){ ?>
                                <a href="{{route('edit',$product->ProductID)}}"><button type="button" id="edit" class="w-100 btn btn-lg btn-outline-primary">Update product</button></a><?php }?>
                                 <form method="post" action="{{ route('deletefav',$favor->FavID )}}">@csrf<button type="submit" id="fav"  class="w-100 btn btn-lg btn-outline-primary">Del to favorites</button></form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>@endforeach 
        </div>
        <span>{{$favorshow->links('pagination::bootstrap-5')}}</span>
    </section>

    
</body>
</html>