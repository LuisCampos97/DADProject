<template>
<div id="id">
    <nav>
        <a v-if="loggedIn && currentUser.shift_active == '1'" class="fas fa-clock col-md-4" style="text-align: center"><router-link to="/dashboard">On Shift {{ shiftTime }}</router-link></a>
        <a v-if="loggedIn && currentUser.shift_active == '0'" class="far fa-clock col-md-4" style="text-align: center"><router-link to="/dashboard">Off Shift</router-link></a>
        <li class="nav-item dropdown" v-if="loggedIn && currentUser.type == 'manager'">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Manage
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item"><router-link to="/tablesManage">Restaurant Tables</router-link></a>
          <a class="dropdown-item"><router-link to="/menuItemsManage">Menu Items</router-link></a>
          <a class="dropdown-item"><router-link to="/invoiceManage">Invoices</router-link></a>
          <a class="dropdown-item"><router-link to="/mealManage">Meals</router-link></a>
          <a class="dropdown-item">Users</a>
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
        <a v-if="loggedIn" v-on:click.prevent="logout()" class="col-md-2">Logout</a>
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
            return this.$store.getters.loggedIn
        },
        shiftTime() {
            var diff = new Date() - new Date(this.$store.state.user.last_shift_start);
            var hours = Math.floor((diff / 1000) / 60 / 60);
            var minutes = Math.floor((diff / 1000) / 60) - hours * 60;
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
            axios.post("api/logout")
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
    color: #2c3e50;
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
    background: #18BC9C;
    margin-bottom: 24px;
}

nav a {
    color: black;
    padding: 0 25px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.1rem;
    text-decoration: none;
    text-transform: none;
}

a {
    text-decoration: none;
    color: black;
    font-weight: bold;
    size: 35px;
    cursor: pointer;
}

a:active,
a:hover {
    text-decoration: none;
}

</style>
