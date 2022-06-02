import axios from "axios";

const state = {
    donut: []
};

const getters = {
    getDataForDonutChart: (state) => state.donut
};

const actions = {
    async fetchDonutData({commit}) {
        const response = await axios.get('/chart/donut').then((response)=>{
            commit('setDonutData', response.data)
        })
    }
};

const mutations = {
    setDonutData: (state, data) => state.donut = data
};

export default {
    state,
    getters,
    actions,
    mutations,
};

