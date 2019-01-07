<template>
<div id="id">
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h4 class="text-white">Collapsed content</h4>
            <span class="text-muted">Toggleable via the navbar brand.</span>
        </div>
    </div>
    <nav >
        <a v-if="loggedIn && currentUser.shift_active == '1'" class="fas fa-clock col-md-4 "  style="text-align: center; padding-top: 0.4%">
        <router-link to="/dashboard">On Shift {{ shiftTime }}</router-link>
      </a>
        <a v-if="loggedIn && currentUser.shift_active == '0'" class="far fa-clock col-md-4" style="text-align: center; padding-top: 0.4%">
        <router-link to="/dashboard">Off Shift</router-link>
      </a>

        <li class="nav-item dropdown" v-if="loggedIn && currentUser.type == 'manager'">
            <button class="navbar-toggler" style="color: white;font-size: inherit; letter-spacing: 0.1rem; font-weight: 600;" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Management</button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="dropdown-item"><router-link to="/tablesManage">Restaurant Tables</router-link></a>
                <a class="dropdown-item"><router-link to="/menuItemsManage">Menu Items</router-link></a>
                <a class="dropdown-item"><router-link to="/invoiceManage">Invoices</router-link></a>
                <a class="dropdown-item"><router-link to="/mealManage">Meals</router-link></a>
                <a class="dropdown-item"><router-link to="/userManage">Users</router-link></a>
            </div>
        </li>

        <li>
            <router-link to="/">Menu</router-link>
        </li>
        <li v-if="loggedIn && currentUser.type == 'manager'">
            <router-link class="col-md-2" to="/registerWorker">Register</router-link>
        </li>
        <li v-if="loggedIn">
            <router-link class="col-md-2" to="/profile">Profile</router-link>
        </li>
        <li v-if="!loggedIn">
            <router-link class="col-md-2" to="/login">Login</router-link>
        </li>
        <li v-if="loggedIn">
            <a v-on:click.prevent="logout()" class="col-md-2" style="color:white;">Logout</a>
        </li>
    </nav>
    <div class="container">
        <router-view></router-view>
    </div>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
</div>
</template>

<script>
module.exports = {
    computed: {
        loggedIn() {
            return this.$store.getters.loggedIn;
        },
        shiftTime() {
            var diff = new Date() - new Date(this.$store.state.user.last_shift_start);
            var hours = Math.floor(diff / 1000 / 60 / 60);
            var minutes = Math.floor(diff / 1000 / 60) - hours * 60;
            if (hours == 0) {
                return minutes + " m";
            } else {
                return hours + " h : " + minutes + " m";
            }
        },
        currentUser() {
            return this.$store.state.user;
        }
    },
    methods: {
        logout() {
            axios
                .post("api/logout")
                .then(response => {
                    this.$store.commit("clearUserAndToken");
                    this.$router.push({
                        name: "home"
                    });
                })
                .catch(error => {
                    this.$store.commit("clearUserAndToken");
                    console.log(error);
                });
        }
    }
};
</script>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

#app {
    font-family: "Avenir", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: white;
    font-size: 24px;
    height: 100vh;
}

.flex-center {
    display: flex;
    justify-content: center;
}

nav {
    display: flex;
    list-style: none;
    padding: 15px 0;
    margin: 0;
    justify-content: center;
    background: #8B0000;
    margin-bottom: 24px;
}

nav a {
    color: white;
    padding: 0 25px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.1rem;
    text-decoration: none;
    text-transform: none;
}

a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    size: 35px;
    cursor: pointer;
}

a:active,
a:hover {
    text-decoration: none;
}
</style>
