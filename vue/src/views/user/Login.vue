<template>
  <div class="vertical-center">
    <div class="container-fluid w-50">
      <form>
        <div class="row mx-auto justify-content-center">
          <div class="col-lg-6 col-12">
            <vs-input border v-model="loginForm.email" placeholder="Email">
              <template #icon>
                <i class='bx bx-user'></i>
              </template>
            </vs-input>
          </div>
          <div class="col-lg-6 col-12">
            <vs-input border type="password" icon-after v-model="loginForm.password" placeholder="Password">
              <template #icon>
                <i class='bx bx-lock-open-alt'></i>
              </template>
            </vs-input>
          </div>
        </div>

        <div class="justify-content-center">

          <div class="row mt-2">

            <div class="col-12" align="center">
              <vs-button style="width: 100px" @click="login">
                Login
                <template #animate>
                  <i class='bx bx-log-in' ></i>
                </template>
              </vs-button>
            </div>

            <div class="col-12 align-middle">
              New Here? <router-link to="/register">Create New Account</router-link>
            </div>
          </div>
        </div>

      </form>

    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import router from "@/router";

export default {
  name: "Login",
  props:{
    active: Boolean,
  },
  data() {
    return {
      loginForm: {
        email: "",
        password: "",
      },
    };
  },
  computed: {...mapGetters(["isAuthenticated"])},
  methods: {
    ...mapActions(["retrieveToken"]),
    login(e) {
      e.preventDefault()
      let loading = this.startLoading()
      this.retrieveToken(this.loginForm).then((response)=>{
        // console.log(response.data.token)
        if(response.data.token) {
          this.openNotificationDuration('top-center', 'success', 'You have been successfully logged in!')

          setTimeout(function(){
            router.push({name:'Budget'})
            loading.close()
            window.location.reload();
          },4000);

        }else{
          this.openNotification('top-center', 'warning', 'Wrong password, please try again.')
          loading.close()
        }
      }).catch((error)=>{
        console.log(error)
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
    },
    startLoading() {
      return this.$vs.loading({
        type: 'default'
      })
    }
  },
};
</script>

<style scoped>
.hasOpenLoading
{
.box-loading
{
  opacity: 0;
  transform: scale(.7)
}
}

.box-loading
{
  width: 120px;
  height: 120px;
  position: relative;
  margin: 5px;
  border-radius: 20px;
  box-shadow: 0px 10px 20px -10px rgba(0,0,0,.07);
  overflow: hidden;
  cursor: pointer;
  transition: all .25s ease;
&:hover{
   transform: translate(0,-5px);
   box-shadow: 0px 15px 20px -10px rgba(0,0,0,.09);
 }
>>>.vs-loading{
  padding: 0px;
}
}
</style>
