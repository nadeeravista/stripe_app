<html>
    <head>
        <title>Products</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">

            <nav class="navbar navbar-inverse">
                <ul class="nav navbar-nav">
                     <li><a href="{{ URL::to('/') }}">Home</a></li>
                    <li><a href="{{ URL::to('product') }}">View All Products</a></li>
                    <li><a href="{{ URL::to('product/create') }}">Add a Product</a>
                    <li><a href="{{ URL::to('shopping') }}">Shopping</a></li>
                    <li><a href="{{ URL::to('orders') }}">My Orders</a></li>
                </ul>
            </nav>
            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
