<template>
  <div class="container" v-loading="isLoading">
    <div class="row justify-content-center">
      <el-col class="m-2 col-4 col-sm-3" v-for="card in allCards" :key="card.id">
        <el-card :body-style="{ padding: '0px' }">
          <img :src="card.image" v-if="card.image" class="img-thumbnail">
          <div style="padding: 14px;" class="mt-2">
            <span><h5>{{ card.name }}</h5></span>
            <p class="text-right">{{ card.type }}</p>
            <p class="text-right">Balance: {{ card.balance }} $</p>
            <div class="bottom clearfix row justify-content-between">

              <router-link :to="{ name: 'CardDetails', params: {card_id: card.id}}">
                <el-button class="float-right ml-3" :loading="false" round>Show details</el-button>
              </router-link>

              <vs-tooltip bottom shadow not-hover v-model="card.is_active" :delay="10" class="mr-3 ml-auto">
                <vs-button @click="card.is_active=!card.is_active" danger icon>
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
                      <vs-button @click="card.is_active=false, handleDelete(card.id)" danger block>
                        Delete
                      </vs-button>
                      <vs-button @click="card.is_active=false" transparent dark block>
                        Cancel
                      </vs-button>
                    </footer>
                  </div>
                </template>
              </vs-tooltip>


              <!--              <div class="ml-3 mr-auto">-->
<!--                <el-popover-->
<!--                    placement="top"-->
<!--                    width="200"-->
<!--                    v-model="visible">-->
<!--                  <p>Are you sure to delete this?</p>-->
<!--                  <div style="text-align: right; margin: 0">-->
<!--                    <el-button size="mini" type="text" @click="visible = false" >cancel</el-button>-->
<!--                    <el-button type="primary" size="mini" @click="handleDelete(card.id), visible = false">confirm</el-button>-->
<!--                  </div>-->
<!--                  <el-button slot="reference"><i class='bx bx-trash-alt'></i></el-button>-->
<!--                </el-popover>-->
<!--              </div>-->

<!--              <div>-->
<!--                <router-link :to="{ name: 'CardDetails', params: {name: card.name, card_id: card.id}}">-->
<!--                  <el-button type="text" class="button mr-3" @click="setId(card.id)">Show details</el-button>-->
<!--                </router-link>-->
<!--              </div>-->

            </div>
          </div>
        </el-card>
      </el-col>
    </div>

    <div class="row justify-content-center mt-4">
      <el-collapse>
        <el-collapse-item width="1000px" name="1">
          <template slot="title">
            Add new card<i class="header-icon el-icon-plus ml-2"></i>
          </template>
          <CardForm :images="allImages"/>
        </el-collapse-item>
      </el-collapse>
    </div>

  </div>

</template>

<script>
import CardForm from "@/components/CardForm";
import {mapGetters, mapActions} from "vuex";

export default {
  name: "CardsList",
  components: {CardForm},
  data() {
    return {
      isLoading: true,
      visible: false
    }
  },
  computed: mapGetters(["allCards", "allImages"]),
  methods: {
    ...mapActions(['fetchCards', 'fetchImages', 'deleteCard']),
    handleDelete(id) {
      this.deleteCard(id).then(() => {
        window.location.reload();
      })
    },
    setId(id){
      localStorage.setItem('card_id', id);
    }
  },
  created() {
    localStorage.removeItem('card')
    if(this.allCards.length === 0){
      this.fetchCards().then(()=>this.isLoading = false)
    }
    if(this.allImages.length === 0){
      this.fetchImages().then(()=>this.isLoading = false)
    }
  }
}
</script>

<style scoped>

p {
  font-size: 12px;
}

.time {
  font-size: 13px;
  color: #999;
}

.bottom {
  margin-top: 13px;
  line-height: 12px;
}

.button {
  padding: 0;
  float: right;
}

.image {
  width: 100%;
  display: block;
}

.clearfix:before,
.clearfix:after {
  display: table;
  content: "";
}

.clearfix:after {
  clear: both
}
</style>
