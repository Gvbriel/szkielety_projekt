<template>
  <div class="container-fluid w-50 p-0">
    <form v-loading="isLoading" class="mx-auto justify-content-center">

      <vs-input border class="mt-2" v-model="goal.name" placeholder="Name of your goal:" />

      <vs-input border class="mt-2" v-model="goal.description" placeholder="Description:" />

      <div class="row">

        <vs-input border class="mt-2 col-8" v-model="goal.goal" placeholder="Amount you want to save:">
          <template v-if="!checkNumber && goal.goal !== ''" #message-danger>
            Insert correct number
          </template>
        </vs-input>

        <vs-select class="mt-2 col-4 text-center" align="center" placeholder="Choose currency" v-model="goal.currency">
          <vs-option align="center" class="p-1" v-for="c in this.getCurrencies" :label="c.currency" :value="c.id" :key="c.id">
            {{ c.name }}
          </vs-option>
        </vs-select>
      </div>

      <vs-button @click="handleSubmit">
        Add goal
      </vs-button>

    </form>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import router from "../router";

export default {
  name: "GoalForm",
  data(){
    return{
      isLoading: true,
      goal: {
        name: '',
        description: '',
        goal: '',
        currency: '',
      }
    }
  },
  methods:{
    ...mapActions(['fetchCurrencies', 'submitGoal']),
    handleSubmit(e){
      e.preventDefault();
      const loading = this.startLoading()
      this.submitGoal(this.goal).then((response)=>{
        this.openNotification('top-center', 'success', 'Success! You can login now.')
        this.isLoading = false
        loading.close()
        router.push({name: 'GoalsList'});
      })
          .catch((error)=>
          {
            console.log(error.response.status)
            if(error.response.status == 422)
            {
              this.openNotification('top-center', 'warning', 'Looks like something is wrong with your data, try again.')
            }else{
              this.openNotification('top-center', 'warning', 'Looks like something went wrong, try again later...')
            }
            this.isLoading = false
            loading.close()
          })
    },
    startLoading() {
      return this.$vs.loading({
        type: 'default'
      })
    },
    openNotification(position = null, color, title) {
      const noti = this.$vs.notification({
        color,
        position,
        title,
      })
    },
    openNotificationDuration(position = null, color, title) {
      const noti = this.$vs.notification({
        duration: 4000,
        progress: 'auto',
        icon: `<i class='bx bxs-time'></i>`,
        color,
        position,
        title,
      })
    }

  },
  computed: {
    ...mapGetters(['getCurrencies']),
    checkNumber(){
      return /^\d+$/.test(this.goal.goal);
    }
  },
  created(){
    this.fetchCurrencies().then(()=> {
          this.isLoading = false
        }
    )
  }
}
</script>

<style scoped>
</style>
