import api from "../api";

export default{
    state: {
        uaa: []
    },
    mutations: {
        setMyStatus(state, b){
            state.uaa = b;
        }
    },
    actions: {
        getIndex({commit}){
            api.getIndex().then(function(res){
                commit("setMyStatus", res);
            });
        }
    }
}