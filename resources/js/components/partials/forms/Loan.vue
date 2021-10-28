<template>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>Loan Request Form</h2>
                </div>
                <div class="body">
<form @submit.prevent="createLoan">    
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
            <label>Your Bank </label>
            <select class="form-control" id="type_id" name="type_id" v-model="form.bank_id" required>
                <option value="">---Select Type---</option>
                <option v-for="all_bank in all_banks" :key="all_bank.id" :value="all_bank.id">{{all_bank.bank_name}}</option>
            </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label>Account Name</label>
            <input type="text" class="form-control" id="acct_name" name="acct_name" placeholder="Enter Account Name" v-model="form.acct_name" required>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
            <label>Account Number</label>
            <input type="number" class="form-control" id="acct_name" name="acct_name" placeholder="Enter Account Number" v-model="form.acct_number" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label>Loan Type</label>
            <select class="form-control" id="type_id" name="type_id" v-model="form.loan_type_id" required>
                <option value="">---Select Type---</option>
                <option v-for="loan_type in loan_types" :key="loan_type.id" :value="loan_type.id">{{loan_type.name}}</option>
            </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label>Requested Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Fund Requested" v-model="form.amount" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label>Guarantors</label>
            <multiselect v-model="form.guarantors" :options="guarantors" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                <template slot="selection" slot-scope="{ values, search, isOpen }">
                    <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">
                        {{ values.length }} options selected
                    </span>
                </template>
            </multiselect>
            <pre class="language-json"><code>{{ value  }}</code></pre>    
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" rows=5 id="description" name="description" placeholder="Description"></textarea>
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
                all_banks: [],
                editMode: false,
                form: new Form({
                    loan_type_id:'',
                    acct_name: '',
                    acct_number: '',
                    amount: '',
                    bank_id: '',
                    guarantors: [],
                    description: '',
                    user_id: '',
                }),
                loan_types:{},
                users:{},
                guarantors:[],
                values:{},
                value:'',
                acct_balance: '',
            }
        },
        methods:{
            createLoan(){
                this.$Progress.start();
                console.log(this.form.amount);
                axios.get('/api/coop/savings/balance/'+this.form.user_id)
                .then(response=>{
                    if (this.form.amount > response.data.balance){
                        Swal.fire({
                            icon: 'error',
                            title: 'Insufficient balance for this loan',
                        });
                        return false;
                    }
                    else{
                        this.form.post('/api/coop/loans')
                        .then(response=>{
                            Swal.fire({
                                icon: 'success',
                                title: 'Loan Account was successfully added!',
                            });
                            
                            this.form.reset();
                            this.$Progress.finish();
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
                        title: 'We can not connect to the server now, this is a lie',
                    })
                });
                
            },
            getAllInitials(){
                axios.get('/api/coop/loans/initials').then(response =>{
                    this.all_banks = response.data.all_banks;
                    this.accounts = response.data.accounts;
                    this.loan_types = response.data.loan_types;
                    this.users = response.data.users;
                    this.form.user_id = response.data.user_id;
                    let guarantors = [];
                    
                    for (let i = 0; i < this.users.length; i++) {
                        guarantors.push({
                            'id' : this.users[i].id, 
                            'name' : this.users[i].unique_id+' | '+this.users[i].first_name+' '+this.users[i].last_name,
                            'value' : this.users[i].unique_id,
                            });
                        }
                    
                    this.guarantors = guarantors;
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Loan form was not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>