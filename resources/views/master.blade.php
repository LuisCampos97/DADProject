<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restaurant Management</title>
    @yield('extrastyles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body class="container">

    <!-- Main content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="container" id="app">
                <div class="header clearfix">
                    <ul class="nav nav-pills pull-right">
                        <li>
                            <router-link :to="{ name: 'index' }">Home</router-link>
                        </li>
                        <li v-if="loggedIn">
                                <router-link :to="{ name: 'dashboard' }">Dasboard</router-link>
                        </li>
                        <li v-if="loggedIn">
                                <router-link :to="{ name: 'profile' }">Profile</router-link>
                        </li>
                        <li v-if="!loggedIn">
                            <router-link :to="{ name: 'login' }">Login</router-link>
                        </li>
                        <li v-if="loggedIn">
                            <router-link :to="{ name: 'logout' }">Logout</router-link>
                        </li>
                    </ul>
                </div>
                <router-view></router-view>

            </div>
        </div>
    </div>
    <!-- ./wrapper -->
    @yield('pagescript')

</body>

</html>