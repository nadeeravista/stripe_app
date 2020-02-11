<html>
    <head>
        <title>Shopping</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-inverse">
                <div class="row">
                    <div class="col-md-10">
                        <ul class="nav navbar-nav">
                            <li><a href="{{ URL::to('/') }}">Home</a></li>
                            <li><a href="{{ URL::to('product') }}">View All Products</a></li>
                            <li><a href="{{ URL::to('product/create') }}">Add a Product</a>
                            <li><a href="{{ URL::to('shopping') }}">Shopping</a></li>
                            <li><a href="{{ URL::to('orders') }}">My Orders</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                            <a href="{{ url("view_cart") }}" data-toggle="tooltip" title="View Cart">
                                <span class="glyphicon glyphicon-shopping-cart"  style="font-size:30px;color:white; padding-top: 5px">{{ $itemCountInCart." item(s)" }}</span>
                            </a>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>