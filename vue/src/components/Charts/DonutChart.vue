<template>
  <div id="chartdiv" v-loading="isLoading" style="height: auto;"></div>
</template>

<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import {mapActions, mapGetters} from "vuex";


export default {
  name: "DonutChart",
  components: {},

  data() {
    return {
      isLoading: true,
    };
  },
  methods: {
    ...mapActions(['fetchDonutData', 'fetchCategoriesNames']),
    createChart(){
      am4core.useTheme(am4themes_animated);
      let chart = am4core.create("chartdiv", am4charts.PieChart);
      chart.hiddenState.properties.opacity = 0;
      chart.data = this.getDataForDonutChart;
      chart.radius = am4core.percent(70);
      chart.innerRadius = am4core.percent(0);
      chart.startAngle = 0;
      chart.endAngle = 360;
      chart.width = am4core.percent(100);

      let series = chart.series.push(new am4charts.PieSeries());
      series.dataFields.value = "value";
      series.dataFields.category = "name";

      series.slices.template.cornerRadius = 0;
      series.slices.template.innerCornerRadius = 0;
      series.slices.template.draggable = false;
      series.slices.template.inert = true;
      series.alignLabels = true;
      // series.labels.template.text = "{category}: {value.value}";
      // series.slices.template.tooltipText = "{category}: {value.value}";
      // chart.legend.valueLabels.template.text = "{category}: {value.value}";

      series.hiddenState.properties.startAngle = 90;
      series.hiddenState.properties.endAngle = 90;

      chart.legend = new am4charts.Legend();
    }
  },
  computed: mapGetters(['getDataForDonutChart', 'allCategoriesNames']),
  created(){
    this.fetchCategoriesNames()
    this.fetchDonutData()
        .then(()=>{
          this.createChart()
          this.isLoading = false;
          console.log(this.getDataForDonutChart)
        })
  },
  mounted(){

  }
};
</script>

<style scoped>
.chart {
  height: 400px;
}
</style>
