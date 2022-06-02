import axios from "axios";
import moment from "moment";

const url = "http://api.budgetifly.com/api/cards";
const urlImage = "http://api.budgetifly.com/api/images";

const formatDate = (value) => {
    if (value) {
        return moment(String(value)).format("DD-MM-YYYY hh:mm:ss");
    }
};

const state = {
    cards: [],
    sortedCards: [],
    images: [],
    card: [],
};

const getters = {
    allCards: (state) => state.cards,
    allImages: (state) => state.images,
    allSortedCards: (state) => state.sortedCards,
    getCard: (state) => state.card
};

const actions = {
    async fetchCards({commit, state}) {
        const response = await axios.get('/cards');
        console.log(response.data)
        commit("setCards", response.data);
    },
    async addCard({commit}, payload) {
        const response = await axios.post('/cards', payload);
        commit("newCard", response.data);
    },
    async fetchSortedCards({commit}) {
        const response = await axios.get('/cards/sorted');
        commit("setSortedCards", response.data);
    },
    async deleteCard({commit}, id) {
        const response = await axios.delete('/cards' + `/${id}`).then(() => {
            commit("deleteBudget", id);
        });
    },
    async fetchImages({commit}) {
        const response = await axios.get('/images');
        console.log(response.data);
        commit("setImages", response.data);
    },
    async addImage({commit}){
        const response = await axios.post('/post').then((response) => {
            console.log(response.data);
            commit('addImage', response.data);
        })
    },
    async fetchCard({commit}, id){
        const response = await axios.get('/cards' + `/${id}`).then((response) => {
            console.log(response.data)
            commit("setCard", response.data);
        });
    }
};

const mutations = {
    setCards: (state, cards) => (state.cards = cards),
    setCard: (state, card) => (state.card = card),
    newCard: (state, card) => state.cards.unshift(card),
    setImages: (state, images) => state.images = images,
    addImage: (state, image) => state.images.unshift(image),
    setSortedCards: (state, cards) => state.sortedCards = cards,
    deleteCard: (state, id) => {
        let prop = state.cards.findIndex(budget => id === budget.id)
        state.cards.splice(prop, 1);
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
