<template>
  <!--  <div>-->
<!--    <el-button class="mr-4 border-0 cursor-pointer" @click="goBack()">-->
<!--      <i class="el-icon-back"></i>-->
<!--    </el-button>-->
<!--    <template v-if="checkAuth()">-->
<!--      <router-link to="/" class="mr-4">Hello {{ name }}!</router-link>-->
<!--      <router-link to="/budget">Budget</router-link>-->
<!--      |-->
<!--      <router-link to="/cards">Cards</router-link>-->
<!--      |-->
<!--    </template>-->
<!--    <template v-if="!checkAuth()">-->
<!--      <router-link to="/login">Login</router-link>-->
<!--      |-->
<!--      <router-link to="/register">Register</router-link>-->
<!--    </template>-->
<!--    <template v-else>-->
<!--      <a @click="logout()">-->
<!--        <router-link to="/">Logout</router-link>-->
<!--      </a>-->
<!--    </template>-->
<!--  </div>-->
    <vs-navbar center-collapsed collapse v-model="active">

      <template #left>
          <vs-navbar-item v-if="checkAuth()" to="/" :active="active == 'main'" id="main">
            Hello {{name}}!
          </vs-navbar-item>
      </template>

      <template v-if="checkAuth()">
        <vs-navbar-group>
          <vs-navbar-item :active="active == 'budget'" id="budget" to="/budget">
            Budget
            <template>
              <i class='bx bxs-archive'></i>
            </template>
          </vs-navbar-item>
          <template #items>
            <vs-navbar-item :active="active == 'budget_list'" id="budget_list" to="/budget">
              Budget list
            </vs-navbar-item>
            <vs-navbar-item :active="active == 'add_budget'" id="add_budget" :to="{ name: 'BudgetAdd', params: {type: 'Create'}}">
              Add budget
            </vs-navbar-item>
            <vs-navbar-item to="/cards" :active="active == 'cards_list'" id="cards_list">
              Cards list
            </vs-navbar-item>
          </template>
        </vs-navbar-group>

        <vs-navbar-group>
          <vs-navbar-item to="/cards" :active="active == 'cards'" id="cards">
            Cards
            <i class='bx bxs-collection'></i>

          </vs-navbar-item>

          <template #items>
            <vs-navbar-item to="/cards/add" :active="active == 'add_card'" id="add_card">
              Add card
            </vs-navbar-item>
          </template>
        </vs-navbar-group>

<!--        <vs-navbar-group>-->
<!--          <vs-navbar-item to="/goals" :active="active == 'goals'" id="goals">-->
<!--            Saving goals-->
<!--            <i class='bx bxs-bank'></i>-->
<!--          </vs-navbar-item>-->

<!--          <template #items>-->
<!--            <vs-navbar-item to="/goals/add" :active="active == 'add_goals'" id="add_goals">-->
<!--              Add saving goal-->
<!--            </vs-navbar-item>-->
<!--          </template>-->
<!--        </vs-navbar-group>-->


      </template>

      <template #right>
        <template v-if="!checkAuth()">
          <vs-button to="/login">
            Login
            <template #animate>
              <i class='bx bx-log-in' ></i>
            </template>
          </vs-button>

          <vs-button to="/register">Get Started</vs-button>
        </template>
        <template v-else>
          <vs-button flat to="/login" @click="logout()">
            Logout
            <template #animate>
              <i class='bx bx-log-out' ></i>
            </template>
          </vs-button>
        </template>
      </template>
    </vs-navbar>
</template>

<script>
import {mapGetters} from "vuex";
import router from "../router";
import Login from "../views/user/Login";

export default {
  name: "NavBar",
  components: {},
  methods: {
    ...mapGetters(['isAuthenticated']),
    checkAuth() {
      if (this.isAuthenticated())
        return true
      else
        return false
    },
    logout() {
      localStorage.clear()
      window.location.reload();
    },
    goBack(){
      router.go(-1)
    }
  },
  mounted() {
    this.checkAuth()
  },
  data() {
    return {
      name: localStorage.getItem('name'),
      active: '',
      dialog: false,
    }
  }
}
</script>


