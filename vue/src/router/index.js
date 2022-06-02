import Vue from 'vue'
import VueRouter from 'vue-router'
import MainWindow from "@/views/MainWindow";
import BudgetForm from "@/components/BudgetForm";
import Login from "@/views/user/Login";
import Register from "@/views/user/Register";
import CardsList from "@/components/CardsList";
import CardForm from "@/components/CardForm";
import Dashboard from "../components/Dashboard";
import CardDetails from "../components/CardDetails";
import GoalsList from "../components/GoalsList";
import GoalForm from "../components/GoalForm";

Vue.use(VueRouter)

const routes = [
    {
        path: '/budget',
        name: 'Budget',
        component: MainWindow
    },
    {
        path: '/budget/add',
        name: 'BudgetAdd',
        component: BudgetForm,
        props: true
    },
    {
        path: '/budget/edit/:name',
        name: 'BudgetEdit',
        component: BudgetForm,
        props: true
    },
    {
        path: '/card/details/:name',
        name: 'CardDetails',
        component: CardDetails,
        props: true
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/cards',
        name: 'Cards',
        component: CardsList
    },
    {
        path: '/cards/add',
        name: 'CardsAdd',
        component: CardForm
    },
    {
        path: '/',
        name: 'Dashboard',
        component: Dashboard
    },
    {
        path: '/goals',
        name: 'GoalsList',
        component: GoalsList
    },
    {
        path: '/goals/add',
        name: 'GoalForm',
        component: GoalForm
    },
]

const router = new VueRouter({
    routes,
    mode: 'history'
})

export default router
