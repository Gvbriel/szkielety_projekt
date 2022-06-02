<template>
  <div class="container-fluid">
    <BudgetTable/>
  </div>
</template>

<script>
import DonutChart from "./Charts/DonutChart";
import BudgetTable from "@/components/BudgetTable";

export default {
  name: "Dashboard",
  components: {BudgetTable}
}
</script>

<style scoped>

</style>
