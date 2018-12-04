<template></template>

<script type="text/javascript">
module.exports = {
  methods: {
    logout() {
      axios.post("api/logout")
        .then(response => {
          this.$router.push({ name: "home" });
          this.$store.commit("clearUserAndToken");
        })
        .catch(error => {
          this.$store.commit("clearUserAndToken");
          console.log(error);
        });
    }
  },
  mounted() {
    this.logout();
  }
};
</script>
