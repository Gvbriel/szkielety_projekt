import axios from "axios";
import moment from "moment";

const url = "http://api.budgetifly.com/api/budget";

const formatDate = (value) => {
    if (value) {
        return moment(String(value)).format("DD-MM-YYYY hh:mm:ss");
    }
};

const state = {
    budget: [],
    token: localStorage.getItem("token") || null,
};

const getters = {
    allBudget: (state) => state.budget,
    getHeader: (state) => state.header,
    getBudget: (state, id) => state.budget.filter(budget => budget.id === id)
};

const actions = {
    async fetchBudget({commit, state}) {
        const response = await axios.get('/budget');

        commit("setBudget", response.data);
    },
    async addBudget({commit}, payload) {
        return new Promise((resolve, reject) => {
            payload.date = formatDate(payload.date);
            console.log(payload.date);
            const response = axios.post('/budget', payload).then((response) => {
                commit("newBudget", response.data);
                resolve(response)
            }).catch((error) => reject(error))
        })
    },
    async updateBudget({commit}, payload) {
        return new Promise((resolve, reject) => {
            const response = axios.put('/budget' + `/${payload.id}`, payload).then((response) => {
                commit("updateBudget", response.data);
                console.log(response)
                resolve(response)
            }).catch((error) =>{
                reject(error)
            })
        })

    },
    async deleteBudget({commit}, id) {
        const response = await axios.delete('/budget' + `/${id}`).then(() => {
            commit('deleteBudget', id);
            window.location.reload();
        })
    }
};

const mutations = {
    setBudget: (state, budget) => (state.budget = budget),
    newBudget: (state, singleBudget) => state.budget.unshift(singleBudget),
    deleteBudget: (state, id) => {
        let prop = state.budget.findIndex(budget => id === budget.id)
        state.budget.splice(prop, 1);
    },
    updateBudget: (state, singleBudget) => {
        let index = state.budget.findIndex(budget => budget.id === singleBudget.id)
        state.budget.splice(index, 1, singleBudget)
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
};
