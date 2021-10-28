<template>
    <div class="row clearfix">
        <div class="modal fade" id="addNewModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                <FormGuarantee :guarantee="guarantee" :users="users"></FormGuarantee>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>All Guarantor Requests</h2> 
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Loan</th>
                                    <th>Loan Status</th>
                                    <th>Guarantor</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="guarantee in guarantees" :key="guarantee.id" :value="guarantee.id">
                                    <td><span>{{guarantee.loan.name}}</span></td>
                                    <td>
                                        <span class="badge badge-danger" v-show="guarantee.loan.status == 0">Awaiting guarantees</span>
                                        <span class="badge badge-warning" v-show="guarantee.loan.status == 1">Awaitng Admin Confirmation</span>
                                        <span class="badge badge-warning" v-show="guarantee.loan.status == 2">Awaiting Disbursement</span>
                                        <span class="badge badge-success" v-show="guarantee.loan.status == 3">Ongoing</span>
                                        <span class="badge badge-primary" v-show="guarantee.loan.status == 4">Completed</span>
                                        <span class="badge badge-default" v-show="guarantee.loan.status == 5">Cancelled</span>
                                    </td>
                                    <td>{{guarantee.guarantor.unique_id}} | {{guarantee.guarantor.first_name}} {{guarantee.guarantor.middle_name}} {{guarantee.guarantor.last_name}}</td>
                                    <td>{{guarantee.amount | currency}}</td>
                                    <td>
                                        <span class="badge badge-info" v-show="(guarantee.status == 0)">Not Yet</span>
                                        <span class="badge badge-primary" v-show="(guarantee.status == 1)">Awaiting</span>
                                        <span class="badge badge-success" v-show="(guarantee.status == 3)">Ongoing</span>
                                        <span class="badge badge-info" v-show="(guarantee.status == 4)">Completed</span>
                                        <span class="badge badge-danger" v-show="(guarantee.status == 5)">Rejected</span>
                                        <span class="badge badge-default" v-show="(guarantee.status == 6)">Cancelled</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" v-show="guarantee.status < 3">
                                        <button class="btn btn-sm btn-primary" v-on:click="editGuarantee(guarantee)">Edit</button><button class="btn btn-sm btn-danger" v-on:click="rejectGuarantee(guarantee.id)">Cancel</button></div>
                                        <div class="btn-group" v-show="guarantee.status == 5">
                                        <button class="btn btn-sm btn-primary" v-on:click="editGuarantee(guarantee)">Change</button></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                loans:{},
                guarantees:{},
                guarantee:{},
                editMode:false,
                saving:{},
                users:[],
            }
        },
        methods:{
            editGuarantee(guarantee){
                Fire.$emit('editGuarantee', guarantee)
                this.guarantee = guarantee;
                $('#addNewModal').modal('show');
            },
            getAllInitials(){
                axios.get('/api/coop/guarantors/initials').then(response =>{
                    this.guarantees = response.data.guarantees;
                    this.loans = response.data.loans;
                    this.users = response.data.users;
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Guarantees loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Guarantors not loaded successfully',
                    })
                });
            },
            rejectGuarantee(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You don't want this cooperator to guarantee you",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    })
                    .then((result) => {
                    if(result.value){
                        axios.delete('/api/coop/guarantees/'+id).then(response=>{
                            Swal.fire({
                            icon: 'success',
                            title: 'The Guarantor Request was rejected',
                            });
                        })
                    .catch(()=>{
                            this.$Progress.fail();
                            toast.fire({
                                icon: 'error',
                                title: 'Closure Request was not submited try again later!',
                                })
                            });
                        }
                    });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>
