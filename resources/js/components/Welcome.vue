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
                        <button type="button" class="btn btn-primary" @click="openGame()">Proceed</button>
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
                let url='http://localhost:8000/api/v1/start-game';
                axios.post(url,this.player).then(function(responseData){
                    if(responseData.status!=201){
                        error(responseData.data.message);
                        return;
                    }

                    let data=responseData.data.data;
                    let playerInfo={
                        fullname: data.fullname,
                        player_id:data.player_id
                    };
                    let boardInfo=data.board;

                    console.log(playerInfo);
                    console.log(boardInfo);

                    //we dispatch 2 actions
                    self.$store.dispatch('updateUserAction',playerInfo);
                    self.$store.dispatch('updateBoardAction',boardInfo);
                    self.$router.push('/game');
                }).catch(e=>{
                    console.log(e);
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