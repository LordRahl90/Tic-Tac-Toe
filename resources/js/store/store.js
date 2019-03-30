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
        board:{

        }
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
            state.player=data;
        },
        updateBoardMut: function(state,board){
            state.board=board;
        }
    },
    actions:{
        updateUserAction: function(context,data){
            context.commit('updateUserMut',data);
        },
        updateBoardAction: function(context,data){
            context.commit('updateBoardMut',data);
        }
    }
});