<template></template>

<script type="text/javascript">
module.exports = {
  methods: {
    logout() {
      axios.post("api/logout")
        .then(response => {
          this.$store.commit("clearUserAndToken");
          this.$router.push({ name: "home" });
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
