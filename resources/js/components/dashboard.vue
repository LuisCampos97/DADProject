<template>
   <div>
      <h1>Hello {{user.name}}</h1>
   </div>
</template>

<script>
module.exports = {
   data() {
      return {
         user: this.$store.state.user
      }
   }
}
</script>

