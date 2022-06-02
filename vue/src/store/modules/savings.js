import axios from "axios";

const state = {
    goals: []
};

const getters = {
    getGoalsData: (state) => state.goals
};

const actions = {
    async fetchGoals({commit}){
        const response = await axios.get('/goals').then((response) => {
            commit('setGoalsData', response.data)
        })
    },
    async submitGoal({commit}, payload){
        return new Promise((resolve, reject) => {
            const response = axios.post('/goals', payload).then((response) => {
                commit('addGoal', response.data)
                resolve(response)
            }).catch((error) => {
                reject(error)
            });
        })
    },
    async deleteGoal({commit}, id){
        return new Promise((resolve, reject) => {
            const response = axios.delete(`/goals/${id}`).then((response) => {
                commit('removeGoal', id)
                resolve(response)
            }).catch((error) => reject(error))
        })
    }
};

const mutations = {
    setGoalsData: (state, goals) => state.goals = goals,
    addGoal: (state, goal) => state.goals.unshift(goal),
    removeGoal: (state, id) => {
        let prop = state.goals.findIndex(goal => id === goal.id)
        state.goals.splice(prop, 1);
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};

