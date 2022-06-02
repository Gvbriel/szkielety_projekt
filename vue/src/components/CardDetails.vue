<template>
  <div class="container">
    <BudgetTable :budget="this.getCard.budgets.data" :max_pag="this.getCard.budgets.max"/>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import BudgetTable from "./BudgetTable";
import router from "../router";

export default {
  name: "CardDetails",
  components: {BudgetTable},
  props:{
    card_id: Number

  },
  data(){
    return{
      isLoading: true
    }
  },
  methods:{
    getData(){
      // const isInStorage = str => localStorage.getItem(str) !== null;
      // const isSetInStorage = str => localStorage.getItem(str) !== undefined;
      // console.log(isInStorage('card_id'))
      // if(!isInStorage('card_id') || !isSetInStorage('card_id'))
      // {
      //   router.push({name:'Cards'});
      // }
      // else
      // {
      //   if(this.$store.state.card === undefined || this.$store.state.card === null)
      //   {
      //     localStorage.setItem('card_id', this.$props.card_id)
      //     let id = localStorage.getItem('card_id')
      //     this.fetchCard(id).then(() => {
      //       console.log(this.getCard)
      //       localStorage.setItem('card', JSON.stringify(this.getCard))
      //     })
      //   }
      // }
          this.fetchCard(this.$props.card_id).then(() => {
            console.log(this.getCard)
            localStorage.setItem('card', JSON.stringify(this.getCard))
            this.isLoading = false
          })
    },
    ...mapActions(['fetchCard'])
  },
  computed: mapGetters(['getCard']),
  created(){
    this.getData()
  }
}
</script>

<style scoped>

</style>
