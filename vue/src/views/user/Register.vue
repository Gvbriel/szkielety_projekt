<template>
  <div class="vertical-center">
    <div class="container-fluid w-50">
      <form>
        <div class="mx-auto justify-content-center">
          <div class="row m-4">
            <div class="col-6">
              <vs-input border v-model="registerForm.name" placeholder="Name"></vs-input>
            </div>

            <div class="col-6">
              <vs-input border v-model="registerForm.surname" placeholder="Surname"></vs-input>
            </div>
          </div>

          <div class="row m-4">
            <div class="col-12">
              <vs-input border v-model="registerForm.email" placeholder="Email">
                <template v-if="validEmail" #message-success>
                  Email Valid
                </template>
                <template v-if="!validEmail && registerForm.email !== ''" #message-danger>
                  Email Invalid
                </template>
              </vs-input>
            </div>
          </div>

          <div class="row m-4">
            <div class="col-6">
              <vs-input
                  id="password"
                  border
                  type="password"
                  v-model="registerForm.password"
                  placeholder="Password"
                  :progress="getProgress"
                  :visiblePassword="hasVisiblePassword"
                  icon-after
                  @click-icon="hasVisiblePassword = !hasVisiblePassword">
                <template #icon>
                  <i v-if="!hasVisiblePassword" class='bx bx-show-alt'></i>
                  <i v-else class='bx bx-hide'></i>
                </template>
                <template v-if="getProgress >= 100" #message-success>
                  Secure password
                </template>
              </vs-input>
            </div>

            <div class="col-6">
              <vs-input
                  type="password" border
                  v-model="registerForm.password_confirmation"
                  id="password_confirmation"
                  placeholder="Confirm password"
                  :visiblePassword="hasVisiblePasswordC"
                  icon-after
                  @click-icon="hasVisiblePasswordC = !hasVisiblePasswordC">
                >
                <template #icon>
                  <i v-if="!hasVisiblePasswordC" class='bx bx-show-alt'></i>
                  <i v-else class='bx bx-hide'></i>
                </template>
                <template v-if="checkPassword" #message-success>
                  Passwords match
                </template>
                <template v-if="!checkPassword && registerForm.password_confirmation !== ''" #message-danger>
                  Passwords are different
                </template>
              </vs-input>
            </div>
          </div>

          <div class="row mx-auto justify-content-center">
            <vs-button
                flat
                @click="clear">
              Clear
            </vs-button>
            <vs-button
                @click="handleRegister">
              Register
            </vs-button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import router from "../../router";

export default {
  name: "Register",
  data() {
    return {
      registerForm: {
        name: "",
        surname: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      hasVisiblePassword: false,
      hasVisiblePasswordC: false,
      matchingPassword: false,
      isLoading: true,
      hasOpenLoading: false,
      types: [
        'default',
      ]
    };
  },
  methods: {
    ...mapActions(['register']),
    handleRegister(e){
      e.preventDefault()
      const loading = this.startLoading()
      this.register(this.registerForm)
          .then(()=>
      {
        this.openNotification('top-center', 'success', 'Success! You can login now.')
        this.isLoading = false
        loading.close()
        router.push({name: 'Login'});
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
    clear(){
      this.registerForm = ''
    },
    openNotification(position = null, color, title) {
      const noti = this.$vs.notification({
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
  computed: {
    validEmail() {
      return /^\w+([-]?\w+)*@\w+([-]?\w+)*(\.\w{2,3})+$/.test(this.registerForm.email)
    },
    checkPassword(){
      if(this.registerForm.password == this.registerForm.password_confirmation && this.registerForm.password.length > 0)
      {
        return true;
      }else{
        return false
      }
    },
    getProgress() {
      let progress = 0
      if (/\d/.test(this.registerForm.password)) {
        progress += 20
      }
      if (/(.*[A-Z].*)/.test(this.registerForm.password)) {
        progress += 20
      }
      if (/(.*[a-z].*)/.test(this.registerForm.password)) {
        progress += 20
      }
      if (this.registerForm.password.length >= 6) {
        progress += 20
      }
      if (/[^A-Za-z0-9]/.test(this.registerForm.password)) {
        progress += 20
      }
      return progress
    },

  }
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
