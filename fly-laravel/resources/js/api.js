import axios from "axios";
export default {
    getIndex: function(params){
        return axios.post("api/visits");
    }
}