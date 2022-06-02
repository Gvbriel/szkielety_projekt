import router from "./router";

export default {
    methods: {
        startLoading() {
            return this.$vs.loading({
                type: 'default'
            })
        },
        open422Notification(position = null, color, title) {
            const noti = this.$vs.notification({
                color: 'warning',
                position: 'top-center',
                title: 'Looks like something is wrong with your data, try again.',
            })
        },
        openProblemNotificationDuration(position = null, color, title) {
            const noti = this.$vs.notification({
                duration: 4000,
                progress: 'auto',
                icon: `<i class='bx bxs-time'></i>`,
                color: 'warning',
                position: 'top-center',
                title: 'Looks like something went wrong, try again later...',
            })
        },
        openSuccessDeleteNotification(){
            const noti = this.$vs.notification({
                color: 'success',
                position: 'top-center',
                title: 'Successfully deleted!',
            })
        },
        openSuccessSubmitNotification(){
            const noti = this.$vs.notification({
                color: 'success',
                position: 'top-center',
                title: 'Successfully submited!',
            })
        },
        openSuccessEditNotification(){
            const noti = this.$vs.notification({
                color: 'success',
                position: 'top-center',
                title: 'Successfully edited!',
            })
        },
        redirectToBudgetTimeout(){
            setTimeout(function(){
                router.push({name:'Dashboard'})
                window.location.reload();
            },2000);
        }
}}
