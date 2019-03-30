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
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data:function(){
            return{
                board:[
                    ["","",""],
                    ["","",""],
                    ["","",""]
                ]
            };
        },
        methods:{
            updateBoard(x,y){
                let board=this.board;
                if(board[x][y]!==""){
                    console.log("Invalid Box clicked");
                    return;
                }

                let newBoard=[
                    ["","O",""],
                    ["X","",""],
                    ["","","O"]
                ];
                // console.log('Board Updated '+x+y);
                // this.board[x][y]='X';
                this.$set(this.board[x],y,'X');
                console.log('board updated');
            }
        },
        computed:{
            ...mapGetters([
                "getBoardState"
            ])
        }

    }
</script>

<style scoped>

</style>