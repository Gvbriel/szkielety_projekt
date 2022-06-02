<template>
  <div class="container-fluid">
    <div class="row justify-content-center" v-loading="isLoading">
        <vs-card shadow class="m-2 col-4 col-sm-3" v-for="goal in this.getGoalsData" :key="goal.id">
          <template #title>
            <h3>{{ goal.name }}</h3>
          </template>
          <template #img>
            <SavingsProgressChart class="mt-4" :progress="goal.chart_value"/>
          </template>
          <template #text>
            <p>
              {{ goal.description }}
            </p>
          </template>
          <template #interactions class="w-100">
            <vs-tooltip bottom shadow not-hover v-model="goal.is_active" :delay="5000">
              <vs-button @click="goal.is_active=!goal.is_active" danger icon>
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
                    <vs-button @click="goal.is_active=false, handleDelete(goal.id)" danger block>
                      Delete
                    </vs-button>
                    <vs-button @click="goal.is_active=false" transparent dark block>
                      Cancel
                    </vs-button>
                  </footer>
                </div>
              </template>
            </vs-tooltip>



            <vs-button class="btn-chat" shadow primary >
              <i class='bx bx-coin-stack' v-if="goal.savings_count > 1"></i>
              <i class='bx bx-coin' v-else></i>
              <template v-if="goal.savings_count >= 1">
                <span class="span">
                  {{goal.savings_count}}
                </span>
              </template>
              <template v-else>
                <span class="span">
                  0
                </span>
              </template>
            </vs-button>

          </template>
        </vs-card>
      </div>
    </div>

</template>

<script>
import SavingsProgressChart from "./Charts/SavingsProgressChart";
import {mapActions, mapGetters} from "vuex";
export default {
  name: "GoalsList",
  components: {SavingsProgressChart},
  data(){
    return{
      isLoading: true,
      activeTooltip1: false,
    }
  },
  methods: {
    ...mapActions(['fetchGoals', 'deleteGoal']),
    handleDelete(id){
      console.log(id)
      let loading = this.startLoading()
      this.deleteGoal(id).then((response) => {
        this.openSuccessDeleteNotification()
      }).catch((error)=>{
        this.openProblemNotificationDuration()
      })
      loading.close()
    }
  },
  computed: mapGetters(['getGoalsData']),
  created() {
    if(this.getGoalsData.length === 0){
      this.fetchGoals()
    }
    this.isLoading = false
  }
}
</script>

<style scoped>

</style>
