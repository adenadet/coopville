<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Add New Saving Account</h2>
            </div>
            <div class="body">
                <form @submit.prevent="editMode ? updateSavingAccount() : createSavingAccount()">      
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control" id="branch_id" name="branch_id" v-model="SavingAccountForm.branch_id" @change="selectUser" required>
                                    <option value="">---Select Branch---</option>
                                    <option v-for="(branch, index) in branches" :key="index" :value="index">{{branch.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Cooperator</label>
                                <select class="form-control" id="user_id" name="user_id" v-model="SavingAccountForm.user_id" required>
                                    <option value="">---Select Cooperator---</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.unique_id}} | {{user.first_name}} {{user.middle_name}} {{user.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Savings Type</label>
                                <select class="form-control" id="type_id" name="type_id" v-model="SavingAccountForm.saving_type_id" required>
                                    <option value="">---Select Type---</option>
                                    <option v-for="saving_type in saving_types" :key="saving_type.id" :value="saving_type.id">{{saving_type.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control" id="name" name="name"  v-model="SavingAccountForm.name" placeholder="Quick Name" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <label>Target Amount</label>
                            <input type="number" class="form-control" id="target" name="target"  v-model="SavingAccountForm.target" placeholder="Enter Zero if N/A" required>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
                </form>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            accounts:{},
            editMode:false,
            SavingAccountForm: new Form({
                branch_id: '',
                user_id: '',
                name:'',
                saving_type_id:'',
                target:'',
            }),
            users:[],
            selectedDrink: -1,
            selectedOption:'',
        }
    },
    methods:{
        createSavingAccount(){
            this.SavingAccountForm.post('/api/coop/savings').then(response=>{
                Swal.fire({
                    icon: 'success',
                    title: 'Saving Account was successfully added!',
                });
                thisa.$router.push('/admin_area/dashboard');
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'Saving Account was not added try again later!',
                })
            });
        },
        editSavingAccount(account){
            this.editMode = true;
            this.SavingAccountForm.fill(account);
        },
        getAllInitials(){
            axios.get('/api/coop/savings/initials').then(response =>{
                this.saving_types = response.data.saving_types;
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Savings Account Form loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'All Savings Accounts were not loaded successfully',
                })
            });
        },
        selectUser() {
            this.selectedOption = '';
            this.users = this.branches[this.SavingAccountForm.branch_id].users;
            console.log('Caught');
            console.log(this.users);
            
            //this.branchNames = this.branches[this.selectedDrink].name;
        },
        updateContribution(){
            this.SavingAccountForm.put('/api/coop/savings/'+this.form.id)
            .then(response=>{
                this.form.reset();
                Fire.$emit('Refresh')
                Swal.fire({
                    icon: 'success',
                    title: 'Savings Account was successfully updated!',
                });
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Savings Account was not updated try again later!',
                })
            });
        },
        updateUsers(users){
            console.log(users);
            this.users = users;
        }
    },
    mounted() {
        Fire.$on('userFill', branches => {
            if(this.$route.params.id !== null){ this.users = branches[0].users;}   
        });
        Fire.$on('SavingAccountFill', update =>{
            this.editMode = true;
            this.SavingAccountForm.fill(update);
        });
    },
    props: {'branches': Array,'saving_types':Array,},
}
</script>
