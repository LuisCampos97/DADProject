<template>
<h1>Ola {{ this.id }}</h1>
</template>

<script>
module.exports = {
   data() {
      return {
         id: this.$route.params.id,
         currentInvoice: {}
      }
   },
   methods: {
      getCurrentInvoice() {
         axios.get('api/invoices/'+ this.id)
            .then(response => {
               console.log(response);
            })
            .catch(error => {
               
            })
      }
   },
   mounted() {
      this.getCurrentInvoice();
   },
}
</script>

