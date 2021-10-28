<template>
    <div class="row clearfix">
        <div class="modal fade" id="addNewModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                <FormGuarantor :guarantor="guarantor" :saving="saving"></FormGuarantor>
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
                                    <th>Amount</th>
                                    <th>Loan Status</th>
                                    <th>Guarantor</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="guarantor in guarantors" :key="guarantor.id" :value="guarantor.id">
                                    <td><span>{{guarantor.loan.name}}</span></td>
                                    <td><span>{{guarantor.loan.amount}}</span></td>
                                    <td>
                                        <span class="badge badge-danger" v-show="guarantor.loan.status == 0">Awaiting Guarantors</span>
                                        <span class="badge badge-warning" v-show="guarantor.loan.status == 1">Awaitng Admin Confirmation</span>
                                        <span class="badge badge-warning" v-show="guarantor.loan.status == 2">Awaiting Disbursement</span>
                                        <span class="badge badge-success" v-show="guarantor.loan.status == 3">Ongoing</span>
                                        <span class="badge badge-primary" v-show="guarantor.loan.status == 4">Completed</span>
                                        <span class="badge badge-default" v-show="guarantor.loan.status == 5">Cancelled</span>
                                    </td>
                                    <td>{{guarantor.guarantor.unique_id}} | {{guarantor.guarantor.first_name}} {{guarantor.guarantor.middle_name}} {{guarantor.guarantor.last_name}}</td>
                                    <td>{{guarantor.amount | currency}}</td>
                                    <td>
                                        <span class="badge badge-info" v-show="(guarantor.status == 0)">Not Yet</span>
                                        <span class="badge badge-primary" v-show="(guarantor.status == 1)">Awaiting</span>
                                        <span class="badge badge-success" v-show="(guarantor.status == 3)">Ongoing</span>
                                        <span class="badge badge-info" v-show="(guarantor.status == 4)">Completed</span>
                                        <span class="badge badge-danger" v-show="(guarantor.status == 5)">Rejected</span>
                                        <span class="badge badge-default" v-show="(guarantor.status == 6)">Cancelled</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" v-show="guarantor.status < 3">
                                        <button class="btn btn-sm btn-primary" v-on:click="editGuarantor(guarantor)">Agree</button><button class="btn btn-sm btn-danger" v-on:click="rejectGuarantor(guarantor.id)">Reject</button></div>
                                        <div class="btn-group" v-show="guarantor.status == 5">
                                        <button class="btn btn-sm btn-primary" v-on:click="editGuarantor(guarantor)">Agree</button></div>
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
                guarantors:{},
                guarantor:{},
                editMode:false,
                saving:{},
            }
        },
        methods:{
            editGuarantor(guarantor){
                Fire.$emit('editGuarantor', guarantor)
                this.guarantor = guarantor;
                $('#addNewModal').modal('show');
            },
            getAllInitials(){
                axios.get('/api/coop/guarantors').then(response =>{
                    this.guarantors = response.data.guarantors;
                    this.saving = response.data.saving[0];
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Guarantors loaded successfully',
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
            rejectGuarantor(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You don't want to guarantee this cooperator",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    })
                    .then((result) => {
                    if(result.value){
                        axios.delete('/api/coop/guarantors/'+id).then(response=>{
                            Swal.fire({
                            icon: 'success',
                            title: 'The Guarantor Request was rejected',
                            });
                        })
                    .catch(()=>{
                            this.$Progress.fail();
                            toast.fire({
                                icon: 'error',
                                title: 'Guarantor Request was not submited, try again later!',
                                })
                            });
                        }
                    });
            },
        },
        mounted() {
            this.getAllInitials();
            Fire.$on('refresh')
        }
    }
</script>
