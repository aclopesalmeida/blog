<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="content-width;initial-scale=1.0"/>
        
    <base href="/">
    
    @include('partials.head-inc')
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    </head>
    
    <body ng-app="blog" class="container-fluid" id="admin">
    
        <div ng-include="'partials/admin/navbar.html'" ng-controller="adminNav"></div>
    
        @yield('content')
    

        
    </body>
    </html>