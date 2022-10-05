const app = new Vue({
    el: '#app', 
  
          data(){
              return {
                  selectedRole:'',
                  selectedRoleName:'',
                  role_permissions:[],
                  roles:[],
                  permissions:[],
              }
          },
          computed: {
              //  ...mapGetters ({
              //     allroles :'ALL_ROLES',
              //     //'role_permissions',
              //  })
          },
          methods:{
              showPermissions(role, permissions){
                  this.role_permissions = permissions;
                  console.log(permissions);
  
                  this.selectedRole = role.id;
                  this.selectedRoleName = role.name;
                  console.log(this.selectedRole);
              },
              deleteRole(id, index){
                  if(confirm("Sure ! wanna delete this??")){
                      var app = this;
                      axios.delete('/role_delete/' +id)
                       .then(function (response) {
                           app.roles.splice(index,1)
                         //  Vue.delete(app.roles, index);
                         //console.log(response.data)
                       })
                  }
              },
              revokePermissions(id, index){
                  // if(confirm("Sure ! wanna delete this??")){
                  //     var app = this;
                  //     axios.delete('/role_revoke_permission/' +id)
                  //      .then(function (response) {
                  //          app.$store.state.permission.splice(index,1)
                  //          Vue.delete(app.$store.state.permission, index);
                  //      })
                  // }
              },
              fetch_roles() {
                    return axios.get('/getRoles')
                          .then(response => this.roles = response.data.roles)
                          .catch();
            },
              fetch_role_permissions() {
                  //  commit('FETCH_ROLE_PERMISSIONS')
            },
  
          },
          mounted() {
          console.log('RolesList created..');
             this.fetch_roles(); 
  
         //this.$store.dispatch('fetch_roles');
          //console.log(this.$store.state.roles);
          },
  
      
  
  });