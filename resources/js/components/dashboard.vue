<template>
<div class="jumbotron">
    <div class="row">
        <div class="profile-shift">
            <p>Shift</p>
            <a>Start: {{ user.last_shift_start }}</a>
            <br>
            <a v-if="user.shift_active == '0'">End: {{ user.last_shift_end }}</a>
            <br>
            <a v-if="user.shift_active == '0'">Time: {{ timePassed }}</a>
            <br>
            <button v-if="user.shift_active == '0'" class="profile-shift-btn" @click.prevent="invertShift()">Start</button>
            <button v-if="user.shift_active == '1'" class="profile-shift-btn" @click.prevent="invertShift()">Quit</button>
        </div>
    </div>
    
    <dashboardWaiter :current-user="user" v-if="user.type == 'waiter'"></dashboardWaiter>
    <dashboardCook v-if="user.type == 'cook'"></dashboardCook>
</div>
</template>

<script>
module.exports = {
    computed: {
        user() {
            return this.$store.state.user;
        },
        timePassed() {
            var diff = new Date() - new Date(this.$store.state.user.last_shift_end);
            console.log(diff);
            var days = Math.floor((diff / 1000) / 60 / 60 / 24);
            var hours = Math.floor((diff / 1000) / 60 / 60);
            var minutes = Math.floor((diff / 1000) / 60) - hours * 60;
            if (days == 0 && hours == 0) {
                return minutes + " m";
            } else if (days == 0) {
                return hours + " h : " + minutes + " m";
            } else {
                return days + " d : " + hours + " h : " + minutes + " m";
            }
        }
    },
    methods: {
        invertShift: function () {
            const user = this.$store.state.user;
            axios
                .put("/api/users/" + user.id + "/shift", user)
                .then(response => {
                    Vue.set(this.user, response.data.data);
                    this.$store.commit("setUser", response.data.data);
                    this.$router.push({
                        name: "profile"
                    });
                })
                .catch(error => {
                    this.showFailure = true;
                    this.showSuccess = false;
                    this.failMessage = error.response.data.message;
                    console.dir(error);
                });
        }
    }
};
</script>
