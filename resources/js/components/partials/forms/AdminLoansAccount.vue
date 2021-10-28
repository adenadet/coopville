<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Add New Loans Account</h2>
            </div>
            <div class="body">
                <form @submit.prevent="editMode ? updateLoanAccount() : createLoanAccount()">      
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control" id="branch_id" name="branch_id" v-model="LoanAccountForm.branch_id" @change="selectUser" required>
                                    <option value="">---Select Branch---</option>
                                    <option v-for="(branch, index) in branches" :key="index" :value="index">{{branch.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Cooperator</label>
                                <select class="form-control" id="user_id" name="user_id" v-model="LoanAccountForm.user_id" required>
                                    <option value="">---Select Cooperator---</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.unique_id}} | {{user.first_name}} {{user.middle_name}} {{user.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                            <label>Your Bank </label>
                            <select class="form-control" id="type_id" name="type_id" v-model="LoanAccountForm.bank_id" required>
                                <option value="">---Select Type---</option>
                                <option v-for="all_bank in all_banks" :key="all_bank.id" :value="all_bank.id">{{all_bank.bank_name}}</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                            <label>Account Name</label>
                            <input type="text" class="form-control" id="acct_name" name="acct_name" placeholder="Enter Account Name" v-model="LoanAccountForm.acct_name" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                            <label>Account Number</label>
                            <input type="number" class="form-control" id="acct_number" name="acct_number" placeholder="Enter Account Number" v-model="LoanAccountForm.acct_number" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Loan Type</label>
                                <select class="form-control" id="type_id" name="type_id" v-model="LoanAccountForm.loan_type_id" required>
                                    <option value="">---Select Type---</option>
                                    <option v-for="loan_type in loan_types" :key="loan_type.id" :value="loan_type.id">{{loan_type.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount"  v-model="LoanAccountForm.amount" placeholder="Enter Loan Amount Requested" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <label>Guarantors</label>
                            <multiselect class="form-control" v-model="LoanAccountForm.guarantors" :options="guarantors" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                                <template slot="selection" slot-scope="{ values, search, isOpen }">
                                    <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">
                                        {{ values.length }} options selected
                                    </span>
                                </template>
                            </multiselect>
                            <pre class="language-json"><code>{{ value  }}</code></pre>    
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
            //all_banks: [],
            editMode:false,
            //guarantors:[],
            LoanAccountForm: new Form({
                acct_name: '',
                acct_number: '',
                amount:'',
                bank_id: '',
                branch_id: '',
                guarantors:'',
                loan_type_id:'',
                user_id: '',
            }),
            value:'',
            users:[],
            selectedDrink: -1,
            selectedOption:'',
        }
    },
    methods:{
        createLoanAccount(){
            this.$Progress.start();
            axios.get('/api/coop/savings/balance/'+this.LoanAccountForm.user_id)
            .then(response=>{
                if (this.LoanAccountForm.amount > response.data.balance){
                    Swal.fire({
                        icon: 'error',
                        title: 'Insufficient balance for this loan',
                    });
                    return false;
                }
                else{
                    this.LoanAccountForm.post('/api/coop/loans')
                    .then(response=>{
                        Swal.fire({
                            icon: 'success',
                            title: 'Loan Account was successfully added!',
                        });
                        this.$Progress.finish();
                        this.LoanAccountForm.reset();
                        this.$router.push('admin_area/dashboard');
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                        Swal.fire({
                            icon: 'error',
                            title: 'Loan Account was not added try again later!',
                        })
                    });
                }
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({
                    icon: 'error',
                    title: 'We can not connect to the server now',
                })
            });
            
        },
        editLoanAccount(account){
            this.editMode = true;
            this.LoanAccountForm.fill(account);
        },
        getAllInitials(){
            axios.get('/api/coop/loans/initials').then(response =>{
                this.all_banks = response.data.all_banks;
                this.loan_types = response.data.loan_types;
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Loan Account Form loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'All Loan Accounts were not loaded successfully',
                })
            });
        },
        selectUser() {
            this.selectedOption = '';
            this.users = this.branches[this.LoanAccountForm.branch_id].users;
            console.log('Caught');
            console.log(this.users);
            console.log(this.branches[this.LoanAccountForm.branch_id]);
        },
        updateLoanAccount(){
            this.LoanAccountForm.put('/api/coop/loans/'+this.form.id)
            .then(response=>{
                this.form.reset();
                Fire.$emit('Refresh')
                Swal.fire({
                    icon: 'success',
                    title: 'Loan Account was successfully updated!',
                });
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Loan Account was not updated try again later!',
                })
            });
        },
        updateUsers(users){
            //console.log(users);
            this.users = users;
        }
    },
    mounted() {
        Fire.$on('userFill', branches => {
            if(this.$route.params.id !== null){ this.users = branches[0].users;}   
        });
        Fire.$on('LoanAccountFill', update =>{
            this.editMode = true;
            this.LoanAccountForm.fill(update);
        });
    },
    props: {'all_banks': Array, 'branches': Array, 'guarantors':Array, 'loan_types':Array,},
}
</script>