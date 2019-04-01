<template>
    <div class="container-fluid">
        <div class="navbar">
            <h1>Welcome to Tic-Tac-Toe</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Welcome to Tic-Tac Toe
                </div>
            </div>
            <div class="card-body">
                <p>You Will need to provide your name and character</p>

                <form>
                    <div class="row">
                        <label class="col-md-3">Email:</label>
                        <div class="col-md-8">
                            <input type="text" name="email" class="form-control" v-model="player.email" />
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-3">Your Name:</label>
                        <div class="col-md-8">
                            <input type="text" name="Fullname" class="form-control" v-model="player.fullname" />
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-3">Your Character:</label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="player.character">
                                <option selected disabled>Select Character</option>
                                <option value="X">X</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>

                    <div v-if="player.fullname!=='' && player.email!=='' && player.character!=='' ">
                        <button type="button" class="btn btn-primary" @click="openGame()" :disabled="loading">
                            <span v-if="loading">Logging In</span>
                            <span v-if="!loading">Proceeds</span>
                        </button>
                        <button class="btn btn-light">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data:function(){
            return{
                loading:false,
                player:{
                    email:'',
                    fullname:'',
                    character:''
                }
            };
        },
        methods:{
            openGame(){
                let self=this;
                this.loading=true;
                let url='/api/v1/start-game';
                axios.post(url,this.player).then(function(responseData){
                    if(responseData.status!=201){
                        error(responseData.data.message);
                        return;
                    }

                    let data=responseData.data.data;
                    let player={
                        fullname: data.fullname,
                        player_id:data.player_id,
                        character:self.player.character
                    };
                    let boardInfo=data.board;

                    console.log(player);
                    // console.log(boardInfo);

                    self.$store.commit('updateUserMut',player);
                    self.$router.push('/game');
                }).catch(e=>{
                    console.log(e);
                    error('An error occurred... '+e.message);
                });
            }
        }
    }
</script>

<style scoped>
    .row{
        margin-bottom: 10px;
    }
</style>