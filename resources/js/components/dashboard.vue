<template>
  <div>
    <h1>Hello {{user.name}}</h1>
  </div>
</template>

<script>
module.exports = {
  computed: {
    user() {
      return this.$store.state.user;
    }
  }
};
</script>

