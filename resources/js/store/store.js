import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);


export const store=new Vuex.Store({
    state:{
        player:{
            fullname:'',
            character:'',
            player_id:''
        },
        board:[
            ["","",""],
            ["","",""],
            ["","",""],
        ]
    },
    getters:{
        getBoardState: function(state){
            return state.board;
        },
        getPlayer: function(state){
            return state.player;
        }
    },
    mutations:{
        updateUserMut: function (state,data) {
            state.player.fullname=data.fullname;
            state.player.character=data.character;
            state.player.player_id=data.player_id;
        },
        updateBoardMut: function(state,board){
            state.board=board;
        },
        updatePlayerIDMut: function(state,id){
            state.player.player_id=id;
        },
        logoutMut(state){
            state.board=[
                ["","",""],
                ["","",""],
                ["","",""],
            ];
            state.player={
                fullname:'',
                character:'',
                player_id:''
            }
        }
    },
    actions:{
        updateUserAction: function(context,player){
            console.log('mutation data ',player);
            context.commit('updateUserMut',player);
        },
        updateBoardAction: function(context,data){
            context.commit('updateBoardMut',data);
        },
        changePlayerID: function (context,id) {
            context.commit('updatePlayerIDMut',id);
        },
        logout(context){
            context.commit('logoutMut');
        }
    }
});