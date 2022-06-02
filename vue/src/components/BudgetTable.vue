<template>
  <div class="container-fluid">

    <div>
      <div class="left">
        <vs-table align="center" v-loading="isLoading" striped>
          <template #thead>
            <vs-tr>
              <vs-th sort @click="budget = $vs.sortData($event, budget, 'title')">
                Title
              </vs-th>
              <vs-th sort @click="budget = $vs.sortData($event, budget, 'category')">
                Category
              </vs-th>
              <vs-th sort @click="budget = $vs.sortData($event, budget, 'type')">
                Type
              </vs-th>
              <vs-th sort @click="budget = $vs.sortData($event, budget, 'amount')">
                Amount
              </vs-th>
              <vs-th sort @click="budget = $vs.sortData($event, budget, 'card_id')">
                Card
              </vs-th>
              <vs-th sort @click="budget = $vs.sortData($event, budget, 'date')">
                Date
              </vs-th>
              <vs-th>
                Actions
              </vs-th>
            </vs-tr>
          </template>
          <template #tbody>
            <vs-tr
                :key="i"
                v-for="(tr, i) in $vs.getPage(budget, page, max_pag)"
                @click="changeState(i)"
            >
              <vs-td>
                {{ tr.title }}
              </vs-td>
              <vs-td>
                {{ tr.category }}
              </vs-td>
              <vs-td>
                {{ tr.type }}
              </vs-td>
              <vs-td>
                {{ tr.amount }}
              </vs-td>
              <vs-td>
                <vs-tooltip left>
                  <vs-button circle flat>
                    {{ tr.card.name }}
                  </vs-button>
                  <template #tooltip>
                    {{tr.card.type}} card
                    <br/>
                    Balance: {{ tr.card.balance }} $
                  </template>
                </vs-tooltip>
              </vs-td>
              <vs-td>
                {{ tr.date }}
              </vs-td>
              <vs-td>
                <vs-row>

                  <vs-tooltip bottom shadow not-hover v-model="tr.is_active" :delay="5000">
                  <vs-button @click="tr.is_active=!tr.is_active" danger icon>
                    <i class='bx bx-trash-alt'></i>
                  </vs-button>
                  <template #tooltip>
                    <div class="content-tooltip">
                      <h4 class="center">
                        Confirm
                      </h4>
                      <p>
                        You are sure to delete this user, by doing so you cannot recover the data
                      </p>
                      <footer>
                        <vs-button @click="tr.is_active=false, handleDelete(tr)" danger block>
                          Delete
                        </vs-button>
                        <vs-button @click="tr.is_active=false" transparent dark block>
                          Cancel
                        </vs-button>
                      </footer>
                    </div>
                  </template>
                  </vs-tooltip>
                  <vs-button @click="handleEditRedirect(tr)" flat icon>
                    <i class='bx bx-edit-alt'></i>
                  </vs-button>
                </vs-row>

              </vs-td>

            </vs-tr>
          </template>
          <template #footer>
            <vs-row justify="space-between">
              <vs-col w="2"></vs-col>
              <vs-col w="2">
                <vs-pagination infinite dotted progress class="m-2" v-model="page" :length="$vs.getLength(budget, max_pag)" />
              </vs-col>
              <vs-col w="2">
                <vs-select @change="resetCurrent" class="mr-2 ml-2 mt-2" filter placeholder="Pagination number" v-model="max_pag">
                  <vs-option v-for="n in ar" :label="n" :value="n" :key="n">
                    {{n}}
                  </vs-option>
                </vs-select>
              </vs-col>
            </vs-row>
          </template>
        </vs-table>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import router from "../router";

export default {
  name: "BudgetTable",
  props:{
    budget: Array,
    type: String,
    max: Number,
  },
  data() {
    return {
      editActive: false,
      edit: null,
      max_pag: 20,
      editProp: '',
      search: '',
      allCheck: false,
      page: 1,
      active: 0,
      selected: [],
      isLoading: false,
      visible: false,
      available: true,
      color: 'red',
      cardMissing: "Brak",
      category: {
        name: '',
        color: '#409EFF'
      },
      cards: [],
      ar: []
    }

  },
  methods: {
    handleEditRedirect(tr){
      router.push({name: 'BudgetEdit', params: {name: tr.title, form: tr, type: 'Edit'}})
    },
    changeState(i){
      let curr = this.$vs.getPage(this.budget, this.page, this.max_pag)
      curr[i].is_expanded = !curr[i].is_expanded
    },
    resetCurrent(){
      let curr = this.$vs.getPage(this.budget, this.page, this.max_pag)
      for(let obj in curr){
        if(obj.is_expanded)
          obj.is_expanded = false
      }
      this.page = 1
      window.scrollTo(0,0)
    },
    setStyle(type) {
      if (type.type === "Income") {
        return 'text-primary'
      }
    },
    setPopoverStyle(type) {
      if (type === 'Debit') {
        return 'info'
      } else {
        return 'warning'
      }
    },
    tableRowClassName({row}) {
      if (row.type === "Income") {
        console.log(row.type);
        return 'income-row';
      } else {
        return 'spending-row';
      }
    },
    handleDelete(item) {
      this.deleteBudget(item.id).then(() => {
        this.fetchBudget();
        window.location.reload();
      });
    },
    ...mapActions(['fetchBudget', 'deleteBudget', 'fetchSortedCards', 'updateBudget', 'fetchCategories', 'addCategory']),
  },
  computed: mapGetters(["allSortedCards", "allCategories"]),
  created() {
    console.log(this.$props)
    for(let x = 5; x <=30; x++){
      this.ar.push(x)
    }
    if(this.$props.type === 'all'){
      this.fetchBudget().then(()=>{
        this.isLoading = false
      })
    }
    if(this.allSortedCards.length === 0){
      this.fetchSortedCards().then(()=>{
        this.isLoading = false
      })}
    if(this.allCategories.length === 0){
      this.fetchCategories().then(()=>{
        this.isLoading = false
      })}
  }
}
</script>

<style scoped>

</style>
