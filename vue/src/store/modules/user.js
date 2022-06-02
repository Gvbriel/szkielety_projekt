import axios from "axios";
import router from "../../router";

const url = "http://localhost:80/api";

const state = {
    token: localStorage.getItem("token") || null,
    isAuthenticated: localStorage.getItem("token") !== null,
    name: localStorage.getItem("name"),
    error: []
};

const getters = {
    isAuthenticated: (state) => state.isAuthenticated,
};

const actions = {
    async retrieveToken({commit, getters}, payload) {
        return new Promise((resolve, reject) => {
            const response = axios.post("/login", payload).then((response) => {
                if(response.data.token) {
                    const token = response.data.token;
                    const name = response.data.name;
                    localStorage.setItem("token", token);
                    localStorage.setItem("name", name);
                    commit("setToken", token);
                }
                resolve(response)
            }).catch((error)=>{
                reject(error)
            });
        })
    },
    async register({commit}, payload) {
        return new Promise((resolve, reject) => {
            const response = axios.post("/register", payload)
            .then((response) => {
                resolve(response)
            }).catch((error)=> {
                reject(error)
            })
        })

    }
};

const mutations = {
    setToken: (token) => (state.token = token),
};

export default {
    state,
    getters,
    actions,
    mutations,
};
