<template>
  <div class="chart">
    <vue-ellipse-progress
        :progress="checkProgress()"
        half
        line-mode="bottom"
        :gap="10"
        dot="10"
        :color="colorChange()"
        :angle="0"
        :legend="true"
        :legendFormatter="({currentValue}) => new Intl.NumberFormat('de-DE').format(currentValue)"
    >
      <template v-slot:legend-value>
        <span slot="legend-value">%</span>
      </template>
    </vue-ellipse-progress>
  </div>
</template>

<script>

export default {
  name: "SavingsProgressChart",
  props: {
    data: Object,
    progress: Number
  },
  methods: {
    checkProgress(){
      if(this.$props.progress > 100){
        return 100;
      }else{
        return this.$props.progress
      }
    },
    colorChange(){
      if(this.$props.progress > 100){
        return "#2daa00"
      }else {
        return "#007aaa"
      }
    }
  }
}
</script>

<style scoped>
  .chart{
    width: 100%;
    height: 100%;
  }
</style>
