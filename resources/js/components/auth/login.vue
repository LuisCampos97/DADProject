<template>
  <div>
    <div class="container">
      <h2>Login</h2>
      <div class="form-group">
        <label for="inputEmail">Email</label>
        <input
          type="email"
          class="form-control"
          v-model.trim="user.email"
          name="email"
          id="inputEmail"
          placeholder="Enter email address"
        >
      </div>
      <div class="form-group">
        <label for="inputPassword">Password</label>
        <input
          type="password"
          class="form-control"
          v-model="user.password"
          name="password"
          id="inputPassword"
          placeholder="Enter password"
        >
      </div>
      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="login">Login</a>
      </div>
    </div>
  </div>
</template>
 <script>
module.exports = {
  name: "login",
  data() {
    return {
      user: {
        email: "",
        password: ""
      }
    };
  },
  methods: {
    login() {
      this.showMessage = false;
      axios
        .post("api/login", this.user)
        .then(response => {
          this.$store.commit("setToken", response.data.access_token);
          return axios.get("api/users/me");
        })
        .then(response => {
          this.$store.commit("setUser", response.data.data);
          this.$router.push({ name: "dashboard" });
        })
        .catch(error => {
          this.$store.commit("clearUserAndToken");
        });
    }
  }
};
</script> 