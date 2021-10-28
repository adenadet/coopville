<template>
<div class="row clearfix">
    <div class="modal fade" id="passwordModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="row clearfix">
                    <div class="col-10 offset-1">
                        <div class="card">
                            <div class="header">
                                <h2>Reset Password for {{user.unique_id}}</h2>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
<form @submit.prevent="passwordReset()">    
    <div class="row justify-content-center">
        <div class="col-md-10 col-sm-10">
            <div class="form-group">
            <label>New Password:</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter New password" required v-model="passwordForm.password">
            </div>
        </div>
        <div class="col-md-10 col-sm-10">
            <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Confirm New password" required v-model="passwordForm.password_confirm">
            </div>
        </div>
        <div class="col-md-10 col-sm-10">
            <input type="submit" name="submit" class="submit btn btn-success" value="Change Password" />
        </div>
    </div>
    
</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addNewModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <FormBioData :user="user" :branches="branches" :states="states" :outside="outside" :editMode="editMode"></FormBioData>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <DetailUserSummary :user_a="user"/>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>Your Branch Members</h2>
            </div>
            <div class="body">
                <ul class="nav nav-tabs-new2">                    
                    <li class="nav-item" v-for="branch in branches" :key="branch.id" :value="branch.id">
                    <a class="nav-link" v-bind:class="(branch.id == active_id)? 'active': ''" data-toggle="tab" :href="'#branch'+branch.id">{{branch.name}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div v-for="branch in branches" :key="branch.id" :id="'branch'+branch.id" 
                    class="tab-pane" v-bind:class="(branch.id == active_id)? 'active': ''" >
                        <DetailBranchMember :branch="branch" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            branches: [],
            states: [],
            outside: false,
            editMode: false,
            passwordForm: new Form({
                user_id: 0,
                password: '',
                password_confirmation: '',
            }),
            route: '',
            user: {},
            active_id : '',
        }
    },
    methods:{
        editUser(user){
            this.user = user;
            this.editMode = true;
            $('#addNewModal').modal('show');
        },
        getAllInitials(){
            this.$Progress.start();
            this.route = ((this.$route.params.id == null) || (this.$route.params.id == ''))? 
            "/api/coop/branches":
            '/api/coop/branches/' + this.$route.params.id;
            
            axios.get(this.route).then(response =>{
                this.branches = response.data.branches;
                this.states = response.data.states;
                this.active_id = this.branches[0].id; 
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Members not loaded successfully',
                })
            });
        },
        passwordChange(user){
            this.user = user;
            this.passwordForm.user_id = this.user.id;
            $('#passwordModal').modal('show');
        },
        passwordReset(){
            this.$Progress.start();
            this.passwordForm.post('/api/hrms/users/passwordReset').then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: response.data.message,
                });
                this.$Progress.finish();
                this.passwordForm.reset();
                $('#passwordModal').modal('hide');
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Your form was not sent try again later!',
                });
            });
        },
        refresh(){
            $('#addNewModal').modal('hide');
            this.getAllInitials();
        },
        viewUser(user){
            this.user = user;
            this.editMode = true;
            $('#userModal').modal('show');
        },
    },
    mounted() {
        this.getAllInitials();   
        Fire.$on('editUser', user =>{this.editUser(user);});  
        Fire.$on('passwordChange', user =>{this.passwordChange(user);});  
        Fire.$on('viewUser', user =>{this.viewUser(user);});  
        Fire.$on('Refresh', () =>{this.refresh();}); 
        },
}
</script>