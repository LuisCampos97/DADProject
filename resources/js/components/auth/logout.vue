<template>
</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { 
                typeofmsg: "alert-success",
                showMessage: false,
                message: "",
                loggedIn: true
            }
        },
        methods: {
            logout() {
                this.showMessage = false;
                axios.post('api/logout')
                    .then(response => {
                        //this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-success";
                        this.message = "User has logged out correctly";
                        this.showMessage = true;
                        Vue.set(this.$root, 'loggedIn', false);
                    })
                    .catch(error => {
                        //this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-danger";
                        this.message = "Logout incorrect. But local credentials were discarded";
                        this.showMessage = true;
                        console.log(error);
                    })            
                }
        },
        created() {
           this.logout();
        }

    }
</script>