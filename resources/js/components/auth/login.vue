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
      <p class="help-block" v-for="error in errors.validate">{{ error }}</p>
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
      },
      errors:{
        validate: []
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
          console.log(response.data.data.email_verified_at);
          if (response.data.data.email_verified_at) {
            this.$store.commit("setUser", response.data.data);
            this.$router.push({ name: "dashboard" });
          } else {
            this.errors[validate] = "Your account has not been activated."
            this.$store.commit("clearUserAndToken");
          }
        })
        .catch(error => {
          this.$store.commit("clearUserAndToken");
        });
    }
  }
};
</script> 

<style>
.help-block {
  color: red;
  display: table-row;
  font-weight: bold;
}
</style>