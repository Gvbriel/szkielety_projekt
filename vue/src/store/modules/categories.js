import axios from "axios";

const state = {
    categories: [],
    catNames: []
};

const getters = {
    allCategories: (state) => state.categories,
    allCategoriesNames: (state) => state.catNames
};

const actions = {
    async fetchCategories({commit}) {
        const response = await axios.get('/categories/all');
        commit('setCategories', response.data)
    },
    async addCategory({commit}, payload) {
        const response = await axios.post('/categories', payload).then((response) => {
            commit('newCategory', response.data)
        });
    },
    async fetchCategoriesNames({commit}) {
        const response = await axios.get('/categories/names').then((response) => {
            commit('setCategoriesNames', response.data)
        })
    }
};

const mutations = {
    setCategories: (state, categories) => state.categories = categories,
    newCategory: (state, category) => state.categories.unshift(category),
    setCategoriesNames: (state, categories) => state.catNames = categories
};

export default {
    state,
    getters,
    actions,
    mutations,
};

