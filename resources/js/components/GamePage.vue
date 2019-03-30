<template>
    <div class="container-fluid">
        <div class="navbar">
            <h1>Welcome to Tic-Tac-Toe</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Welcome to Tic-Tac Toe.
                    <span style="float: right">Your Character is: {{ player.character }}</span>
                </div>
            </div>

            <div class="card-body">
                <div align="center">
                    <div style="width: 400px; max-height: 400px;">
                        <table border="1" align="center" width="100%" v-if="board.length>=2">
                            <tr v-for="(row,i) in board" :key="i">
                                <td style="padding:20px; font-size: 30pt;" align="center" v-for="(item,j) in row" @click="updateBoard(i,j)" :key="j">
                                    {{ item }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" @click="restart()" class="btn btn-info">Restart</button>
                <button type="button" class="btn btn-danger">Restart</button>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data:function(){
            return{
                player:'',
                board:[],
                componentIKey:0,
                componentJKey:1
            };
        },
        methods:{
            updateBoard(x,y){
                let player=this.$store.getters.getPlayer;
                let currentBoard=this.$store.getters.getBoardState;
                let self=this;
                // currentBoard[x][y]=player.character;
                currentBoard[x][y]=player.character;

                //lets send the coord out.
                axios.post('/api/v1/move',{
                    'player_id':this.player.player_id,
                    'x':x,
                    'y':y,
                    'board':currentBoard
                }).then(function(responseData){
                    console.log(responseData.data.data.board);

                    let data=responseData.data.data;


                    self.$store.dispatch('updateBoardAction',responseData.data.data.board);
                    self.board=self.$store.getters.getBoardState;
                    // self.$forceUpdate();
                    self.forceRenderer();

                    if(data.finished){
                        success(responseData.data.message);
                        return;
                    }
                });
            },
            restart(){
                let player=this.$store.getters.getPlayer;
                let self=this;
                axios.post('/api/v1/restart',{
                    player:player
                }).then(function(responseData){
                    let appData=responseData.data;
                    if(!appData.success){
                        error(appData.message);
                        return;
                    }

                    let respData=appData.data;
                    //lets start updating.
                    self.$store.dispatch('updateBoardAction',respData.board);
                    self.board=self.$store.getters.getBoardState;
                    self.$store.dispatch('changePlayerID',respData.player_id);
                    console.log(respData.player_id);
                });
            },
            forceRenderer(){
                this.componentIKey+=1;
                this.componentJKey+=1;
            }
        },
        computed:{
            ...mapGetters([
                "getBoardState"
            ])
        },
        mounted() {
            this.board=this.$store.getters.getBoardState
            let player=this.$store.getters.getPlayer;

            if(player==null){
                this.$router.push('/');
            }

            if(player.character===""){
                this.$router.push('/');
            }
            this.player=player;
        }
    }
</script>
<style scoped>

</style>