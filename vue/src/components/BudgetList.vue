<template>
  <div class="container">
    <div>
      <DonutChart/>
    </div>
    <el-row class="mt-2">
      <router-link :to="{ name: 'BudgetAdd', params: {type: 'Create'}}">
        <el-button class="float-right" :loading="false" round>Add new budget</el-button>
      </router-link>

      <div class="float-left mr-2" style="border-radius: 20px;">
        <el-popover
            placement="top"
            width="auto"
            v-model="visible"
            round>
          <p>Enter category name:</p>
          <div style="text-align: right; margin: 0">
            <el-form ref="form" :model="category" class="p-2">
              <div class="row">
                <el-input placeholder="Please input" v-model="category.name" class="col-8 m-0 p-0" small></el-input>
                <el-color-picker v-model="category.color" class="col-4 m-0 p-0"></el-color-picker>
              </div>
              <div class="row justify-content-center mt-2">
                <el-button size="mini" type="text" @click="visible = false">cancel</el-button>
                <el-button type="primary" size="mini" @click="handleCategorySubmit">confirm</el-button>
              </div>
            </el-form>

          </div>
          <el-button slot="reference">Add category</el-button>
        </el-popover>

      </div>

    </el-row>

    <BudgetTable :budget="allBudget.data" :type="allBudgetList" :max_pag="allBudget.max" class="mt-4"/>

  </div>
</template>


<script>
import {mapGetters, mapActions} from "vuex"
import BudgetTable from "./BudgetTable";
import DonutChart from "@/components/Charts/DonutChart";

export default {
  name: "BudgetList",
  components: {DonutChart, BudgetTable},
  data() {
    return {
      allBudgetList: 'all',
      isLoading: true,
      visible: false,
      available: true,
      color: 'red',
      cardMissing: "Brak",
      category: {
        name: '',
        color: '#409EFF'
      },
      cards: [],
    }

  },
  methods: {
    handleCategorySubmit(e) {
      e.preventDefault()
      console.log(this.category)
      this.addCategory(this.category)
    },
    ...mapActions(['fetchBudget', 'deleteBudget', 'fetchSortedCards', 'updateBudget', 'fetchCategories', 'addCategory']),
  },
  computed: mapGetters(["allBudget", "allSortedCards", "allCategories"]),
  created() {
    console.log(this.$store.state.budget)
    console.log(this.allBudget.length)
    if(this.allBudget.length === 0)
    {
      this.fetchBudget().then(()=>{
        this.isLoading = false
      })
    }
  }
}
</script>

<style scoped>
.el-table {
  color: black !important;
}

.el-table .income-row {
  background-color: blue;
}

.el-table .spending-row {
  background-color: #FF1801;
  opacity: .2;
}
</style>
