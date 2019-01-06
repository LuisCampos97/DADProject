<template>
  <div id="id">
    <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-dark p-4">
        <h4 class="text-white">Collapsed content</h4>
        <span class="text-muted">Toggleable via the navbar brand.</span>
      </div>
    </div>
    <nav>
      <a v-if="loggedIn && currentUser.shift_active == '1'" class="fas fa-clock col-md-4" style="text-align: center">
        <router-link to="/dashboard">On Shift {{ shiftTime }}</router-link>
      </a>
      <a v-if="loggedIn && currentUser.shift_active == '0'" class="far fa-clock col-md-4" style="text-align: center">
        <router-link to="/dashboard">Off Shift</router-link>
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Management</button>
      <li class="nav-item dropdown">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="dropdown-item waves-light"><router-link class="col-md-2" to="/profile">Profile</router-link></a>
            <a class="dropdown-item waves-light"><router-link class="col-md-2" to="/profile">Profile</router-link></a>
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
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"
      integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP"
      crossorigin="anonymous"
    >
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
  background: #18bc9c;
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
