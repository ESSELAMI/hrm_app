<template>
<router-view> </router-view>
</template>

<script>
    import {mapState,mapGetters} from 'vuex'
     export default {
        data(){
            return {
            }
        },
        computed: {
            ...mapGetters ({
                roles : 'ALL_ROLES'
            }),
            ...mapState ({
                lol : state => state.roles
            })
        },

        methods: {
            // getRoles(){
            //     var app = this;
            // axios.get('/getRoles')
            //     .then(response => {
            //         //  this.roles = ;
            //     app.$store.state.roles = response.data.roles;
            //     console.log(this.roles);

            // })
            // },
            // getPermissions(){
            //     var app = this;
            //     axios.get('/getPermissions')
            //      .then(response => {
            //         app.$store.state.permissions = response.data.permissions;
            //     })
            //  }
        },
        mounted() {

            this.$store.dispatch('fetch_roles');
            console.log(this.lol);
            console.log(this.roles);

        },
    }
</script>
