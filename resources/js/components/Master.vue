<template>
  <div id="id">
    <nav>
      <li><router-link to="/">Home</router-link></li>
      <li v-if="loggedIn && currentUser.type == 'manager'"><router-link to="/registerWorker">Register Worker</router-link></li>
      <li v-if="loggedIn"><router-link to="/dashboard">Dashboard</router-link></li>
      <li v-if="loggedIn"><router-link to="/profile">Profile</router-link></li>
      <li v-if="loggedIn"><router-link to="/logout">Logout</router-link></li>
      <li v-if="!loggedIn"><router-link to="/login">Login</router-link></li>
    </nav>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
module.exports = {
  computed: {
    loggedIn() {
      return this.$store.getters.loggedIn
    },
    currentUser() {
      return this.$store.state.user;
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
  justify-content: flex-end;
  background: #f5f8fa;
  border-bottom: 1px solid lightgrey;
  margin-bottom: 24px;
}
nav a {
  color: #636b6f;
  padding: 0 25px;
  font-size: 14px;
  font-weight: 600;
  letter-spacing: 0.1rem;
  text-decoration: none;
  text-transform: uppercase;
}

a {
  text-decoration: none;
  color: black;
  font-weight: bold;
  size: 35px;
}

a:active,
a:hover {
  text-decoration: none;
}
</style>
