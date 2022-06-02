import axios from "axios";

const state = {
    currencies: []
};

const getters = {
    getCurrencies: (state) => state.currencies
};

const actions = {
    async fetchCurrencies({commit}){
        const response = await axios.get('/currencies').then((response) => {
            commit('setCurrencies', response.data)
        })
    },

};

const mutations = {
    setCurrencies: (state, currencies) => state.currencies = currencies,
};

export default {
    state,
    getters,
    actions,
    mutations,
};

