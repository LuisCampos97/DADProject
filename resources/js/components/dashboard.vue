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
    
    <dashboardWaiter :currentUser="user" v-if="user.type == 'waiter'"></dashboardWaiter>
    <dashboardCook :currentUser="user" v-if="user.type == 'cook'"></dashboardCook>
    <dashboardCashier :currentUser="user" v-if="user.type == 'cashier'"></dashboardCashier>

    <br><br>
    <p> Message to all managers: </p>
    <div>
        <input type="text" id="inputGlobal" class="inputchat" v-model="msgGlobalText" @keypress.enter="sendGlobalMsg">
        <br>
        <textarea id="textGlobal" class="inputchat" v-model="msgGlobalTextArea">Global Chat</textarea>
    </div>

</div>
</template>

<script>
module.exports = {
    data: function() {
        return {
            msgGlobalText: '',
            msgGlobalTextArea: '',
        };
    },
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
        },
        sendGlobalMsg: function(){
            console.log('Sending to the server this message: "' + this.msgGlobalText + '"');
            if (this.$store.state.user === null) {
                this.$socket.emit('msg_from_client', this.msgGlobalText);
            } else {
                this.$socket.emit('msg_from_client', this.msgGlobalText, this.$store.state.user);
            }
            this.msgGlobalText = "";
        },
    },
    sockets:{
        connect(){
            console.log('socket connected (socket ID = '+this.$socket.id+')');
        }, 
        msg_from_server(dataFromServer){
            console.log('Receiving this message from Server: "' + dataFromServer + '"');            
            this.msgGlobalTextArea = dataFromServer + '\n' + this.msgGlobalTextArea ;
        }
    },
};
</script>
