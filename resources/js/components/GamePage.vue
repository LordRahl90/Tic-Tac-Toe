<template>
    <div class="container-fluid">
        <div class="navbar">
            <h1>Welcome to Tic-Tac-Toe</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Welcome to Tic-Tac Toe.
                    <span style="float: right">Your Character is: </span>
                </div>
            </div>

            <div class="card-body">
                <div align="center">
                    <div style="width: 400px; max-height: 400px;">
                        <table border="1" align="center" width="100%" v-if="board.length>=2">
                            <tr v-for="(row,i) in board">
                                <td style="padding:20px; font-size: 30pt;" align="center" v-for="(item,j) in row" @click="updateBoard(i,j)">
                                    {{ item }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="button" class="btn btn-info">Restart</button>
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
                board:[]
            };
        },
        methods:{
            updateBoard(x,y){
                let player=this.$store.getters.getPlayer;
                let currentBoard=this.board;
                let self=this;
                // currentBoard[x][y]=player.character;
                currentBoard[x][y]='O';
                this.$set(this.board[x],y,'X');

                //lets send the coord out.
                axios.post('/api/v1/move',{
                    'player_id':1,
                    'x':x,
                    'y':y,
                    'board':currentBoard
                }).then(function(responseData){
                    console.log(responseData.data.data.board);
                   self.$store.dispatch('updateBoardAction',responseData.data.data.board);
                   self.$set(self.$store.getters.getBoardState);
                });
            }
        },
        computed:{
            ...mapGetters([
                "getBoardState"
            ])
        },
        mounted() {
            this.board=this.$store.getters.getBoardState
        }
    }
</script>
<style scoped>

</style>