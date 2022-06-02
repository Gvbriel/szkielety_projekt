<template>
  <div id="app">
    <div class="container-fluid mb-4">
      <NavBar/>
    </div>
    <div class="margin">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import router from "./router";
import NavBar from "./components/NavBar";

export default {
  name: 'app',
  components: {NavBar},
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
      name: localStorage.getItem('name')
    }
  }
}
</script>

<style>
@import '~bootstrap/dist/css/bootstrap.css';

.vertical-center{
  min-height: 85%;
  min-height: 85vh;

  display: flex;
  align-items: center;
}

.margin {
  margin-top: 100px;
}

@media screen and (max-width: 768px) {

}

/*.center {*/
/*  display: flex;*/
/*  flex-direction: column;*/
/*  justify-content: center;*/
/*  align-items: center;*/
/*  text-align: center;*/
/*  min-height: 60vh;*/
/*}*/

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 15px;
}
</style>
